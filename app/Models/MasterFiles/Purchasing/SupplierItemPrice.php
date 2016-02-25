<?php

namespace App\Models\MasterFiles\Purchasing;

use App\Models\Searchable;
use App\Models\SGModel;

class SupplierItemPrice extends SGModel {

    use Searchable;

    public $incrementing         = false;
    protected $table             = "supplier_item_price";
    protected $primaryKey        = "supplier_number";
    protected $fillable          = ['supplier_number', "item_code", "unit_cost"];
    protected $searchableColumns = ['supplier_number', "item_code", "unit_cost"];

    public function scopeSupplier($query, $supplierNumber) {
        return $query->where("supplier_number", $supplierNumber);
    }

    public function scopeItem($query, $itemCode) {
        return $query->where("item_code", $itemCode);
    }

}
