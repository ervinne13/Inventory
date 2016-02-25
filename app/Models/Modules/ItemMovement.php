<?php

namespace App\Models\Modules;

use App\Exceptions\OutOfStockException;
use App\Models\BelongsToAnItem;
use App\Models\HasAuditLogs;
use App\Models\Inventory\InventoryStock;
use App\Models\Inventory\LocationItemStockSummary;
use App\Models\MasterFiles\Accounting\ItemMovementSource;
use App\Models\SGModel;
use Carbon\Carbon;

class ItemMovement extends SGModel {

    use HasAuditLogs;
    use BelongsToAnItem;

    protected $table    = "item_movement";
    protected $dates    = ["movement_date"];
    protected $fillable = [
        "ref_doc_type",
        "ref_doc_no",
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

    public function itemMovementSource() {
        return $this->belongsTo(ItemMovementSource::class, "ref_doc_type");
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
