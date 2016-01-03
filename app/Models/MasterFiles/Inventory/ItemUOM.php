<?php

namespace App\Models\MasterFiles\Inventory;

use App\Models\Searchable;
use Illuminate\Database\Eloquent\Model;

class ItemUOM extends Model {

    use Searchable;

    public $incrementing         = false;
    public $timestamps           = false;
    protected $table             = "item_uom";
    protected $primaryKey        = ["item_code", "uom_code"];
    protected $searchableColumns = ["item_code", "uom_code"];

    public function uom() {
        return $this->belongsTo(UOM::class, "uom_code");
    }

    public function scopeItemCode($query, $itemCode) {
        return $query->where("item_code", $itemCode);
    }

}
