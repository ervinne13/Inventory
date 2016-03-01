<?php

namespace App\Models\MasterFiles\Inventory;

use App\Models\HasAuditLogs;
use App\Models\Searchable;
use App\Models\SGModel;

class Item extends SGModel {

    use HasAuditLogs;
    use Searchable;

    const MODULE_CODE = "I";

    public $incrementing         = false;
    protected $table             = "item";
    protected $primaryKey        = "code";
    protected $fillable          = ['item_type_code', "code", "name", "default_currency_code", "default_unit_cost", "threshold_low", "threshold_high"];
    protected $searchableColumns = ['item_type_code', "code", "name"];

    public function scopeItemTypeCode($query, $itemTypeCode) {
        return $query->where("item_type_code", $itemTypeCode);
    }

    /**     * *************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="Relationships">

    public function itemType() {
        return $this->belongsTo(ItemType::class, "item_type_code", "code");
    }

    public function images() {
        return $this->hasMany(ItemImage::class, "item_code");
    }

    public function UOMList() {
        return $this->hasMany(ItemUOM::class, "item_code");
    }

    // </editor-fold>    
}
