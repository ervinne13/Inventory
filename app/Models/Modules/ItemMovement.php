<?php

namespace App\Models\Modules;

use App\Models\Inventory\InventoryStock;
use App\Models\Inventory\LocationItemStockSummary;
use App\Models\MasterFiles\Inventory\Item;
use App\Models\MasterFiles\Inventory\UOM;
use App\Models\SGModel;
use Carbon\Carbon;

class ItemMovement extends SGModel {

    protected $table    = "item_movement";
    protected $dates    = ["movement_date"];
    protected $fillable = [
        "ref_doc_type",
        "ref_doc_no",
        "movement_date",
        "company_code",
        "location_code",
        "item_type",
        "item_code",
        "item_name",
        "item_uom_code",
        "unit_cost",
        "qty",
        "remarks",
        "status",
    ];

    public function item() {
        return $this->belongsTo(Item::class, "item_code");
    }

    public function itemUOM() {
        return $this->belongsTo(UOM::class, "item_uom_code");
    }

    //
    /**     * *************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="Posting Function(s)">

    /**
     * WARNING! make sure to use an external transaction before posting
     */
    public function post() {
        $this->pushToInventoryStoreStack();
        $this->updateLocationItemStockSummary();
        $this->status = "Posted";
        $this->save();
    }

    private function pushToInventoryStoreStack() {
        $stock                  = new InventoryStock();
        $stock->entry_date_time = Carbon::now();
        $stock->item_type_code  = $this->item_type;
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

        $summary->stock = $summary->stock ? $summary->stock + $this->qty : $this->qty;
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
