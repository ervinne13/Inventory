<?php

namespace App\Models\Modules;

use App\Exceptions\OutOfStockException;
use App\Models\BelongsToAnItem;
use App\Models\HasAuditLogs;
use App\Models\Inventory\InventoryStock;
use App\Models\Inventory\LocationItemStockSummary;
use App\Models\MasterFiles\Accounting\ItemMovementSource;
use App\Models\ModuleLog;
use App\Models\SGModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemMovement extends SGModel {

    use HasAuditLogs;
    use BelongsToAnItem;

    protected $table    = "item_movement";
    protected $dates    = ["movement_date"];
    protected $fillable = [
        "ref_doc_type",
        "ref_doc_no",
        "item_source_type",
        "movement_date",
        "company_code",
        "location_code",
        "item_type_code",
        "item_code",
        "item_name",
        "item_uom_code",
        "item_source",
        "unit_cost",
        "qty",
        "remarks",
        "status",
    ];

    public static function boot() {
        parent::boot();

        static::created(function($record) {
            ModuleLog::create([
                "module_code"        => "IM",
                "record_identifier"  => $record["id"],
                "action_date"        => Carbon::now(),
                "action"             => "Created Document",
                "action_by_username" => Auth::user()->username
            ]);
        });

        static::updating(function($record) {
            $original     = $record->getOriginal();
            $exceptFields = ['updated_at', 'created_at', "created_by", "updated_by"];

            foreach ($original as $field => $value) {
                if (!in_array($field, $exceptFields) && $value != $record[$field]) {
                    ModuleLog::create([
                        "module_code"        => "IM",
                        "record_identifier"  => $record["id"],
                        "action_date"        => Carbon::now(),
                        "action"             => "Updated field {$field} from {$value} to {$record[$field]}",
                        "action_by_username" => Auth::user()->username
                    ]);
                }
            }
        });
    }

    public function logs() {
        return $this->hasMany(ModuleLog::class, "record_identifier", "id")
                        ->where('module_code', "IM");
    }

    public function itemMovementSource() {
        return $this->belongsTo(ItemMovementSource::class, "ref_doc_type");
    }

    public static function getTotalSales($dateFrom, $dateTo) {
        $totalSalesRow = ItemMovement::select(DB::raw('sum(qty * unit_cost) AS total_sales'))
                ->sales()
                ->dateFrom($dateFrom)
                ->dateTo($dateTo)
                ->first();

        if ($totalSalesRow) {
            return $totalSalesRow->total_sales;
        } else {
            return 0;
        }
    }

    public static function getSoldItems($dateFrom, $dateTo) {

        $columns = [
            'location.name AS location_name',
            'item_type.name AS item_type_name',
            'item_name',
            'unit_of_measurement.name AS uom_name',
            DB::raw('sum(qty) AS total_qty'),
            DB::raw('sum(qty * unit_cost) AS total_sales'),
        ];

        return ItemMovement::select($columns)
                        ->sales()
                        ->dateFrom($dateFrom)
                        ->dateTo($dateTo)
                        ->join("location", "location_code", "=", "location.code")
                        ->join("item_type", "item_type_code", "=", "item_type.code")
                        ->join("unit_of_measurement", "item_uom_code", "=", "unit_of_measurement.code")
                        ->groupBy(["location.name", "item_code", "item_uom_code", "item_type.name", "item_name", "unit_of_measurement.name"])
                        ->get();
    }

    public function scopeSales($query) {
        return $query->where("ref_doc_type", "SI");
    }

    public function scopeDateFrom($query, $date) {
        return $query->where("movement_date", ">=", $date);
    }

    public function scopeDateTo($query, $date) {
        return $query->where("movement_date", "<=", $date);
    }

    //
    /**     * *************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="Posting Function(s)">

    /**
     * WARNING! make sure to use an external transaction before posting
     */
    public function post() {

        if ($this->itemMovementSource->nature == "Gain") {
            $this->pushToInventoryStoreStack();
        } else if ($this->itemMovementSource->nature == "Loss") {
            InventoryStock::commitStocks(
                    $this->company_code, $this->location_code, $this->item_code, $this->item_uom_code, $this->qty
            );
        } else {
            throw new Exception("Unhandled item movement nature {$this->itemMovementSource->nature}");
        }

        $this->updateLocationItemStockSummary();

        $this->status = "Posted";
        $this->save();

        ModuleLog::create([
            "module_code"        => "IM",
            "record_identifier"  => $this->id,
            "action_date"        => Carbon::now(),
            "action"             => "Posted",
            "action_by_username" => Auth::user()->username
        ]);
    }

    private function pushToInventoryStoreStack() {
        $stock                  = new InventoryStock();
        $stock->entry_date_time = Carbon::now();
        $stock->item_type_code  = $this->item_type_code;
        $stock->item_code       = $this->item_code;
        $stock->item_uom_code   = $this->item_uom_code;
        $stock->company_code    = $this->company_code;
        $stock->location_code   = $this->location_code;
        $stock->unit_cost       = $this->unit_cost;
        $stock->qty             = $this->qty;
        $stock->save();
    }

    private function updateLocationItemStockSummary() {

        $summary = LocationItemStockSummary::firstOrNew([
                    "company_code"  => $this->company_code,
                    "location_code" => $this->location_code,
                    "item_code"     => $this->item_code,
                    "item_uom_code" => $this->item_uom_code,
        ]);

        if ($this->itemMovementSource->nature == "Gain") {
            $summary->stock = $summary->stock ? $summary->stock + $this->qty : $this->qty;
        } else if ($this->itemMovementSource->nature == "Loss" && $summary && $summary->stock && $summary->stock >= $this->qty) {
            $summary->stock -= $this->qty;
        } else if ($this->itemMovementSource->nature == "Loss") {
            //  params: item code, remaining stocks, stocks needed
            throw new OutOfStockException($this->item_code, $summary && $summary->stock ? $summary->stock : 0, $this->qty);
        }

        $summary->save();
    }

    // </editor-fold>

    /**     * *************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="Mutators">

    public function setMovementDateAttribute($value) {
        $this->attributes['movement_date'] = Carbon::createFromFormat('m/d/Y H:i a', $value);
    }

    // </editor-fold>
}
