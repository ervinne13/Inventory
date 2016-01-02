<?php

namespace App\Models\MasterFiles\Inventory;

use App\Models\Searchable;
use App\Models\SGModel;

class Item extends SGModel {

    use Searchable;

    public $incrementing         = false;
    protected $table             = "item";
    protected $primaryKey        = "code";
    protected $searchableColumns = ['item_type_code', "code", "name"];

    public function scopeItemTypeCode($query, $itemTypeCode) {
        return $query->where("item_type_code", $itemTypeCode);
    }    
    
    public function itemType() {
        return $this->belongsTo(ItemType::class, "item_type_code", "code");
    }

}
