<?php

namespace App\Models\Inventory;

use App\Models\CompositeKeyModel;
use App\Models\SGModel;

class LocationItemStockSummary extends SGModel {

    use CompositeKeyModel;

    public $incrementing  = false;
    public $timestamps    = false;
    protected $table      = "location_item_stock_summary";
    protected $primaryKey = [
        "company_code", "location_code", "item_code", "item_uom_code"
    ];
    protected $fillable   = [
        "company_code", "location_code", "item_code", "item_uom_code", "stock"
    ];

    public function scopeCompositeKey($query, $keys) {

        return $query
                        ->where("company_code", $keys["company_code"])
                        ->where("location_code", $keys["location_code"])
                        ->where("item_code", $keys["item_code"])
                        ->where("item_uom_code", $keys["item_uom_code"])
        ;
    }

}
