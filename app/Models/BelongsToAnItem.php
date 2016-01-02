<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\Models\MasterFiles\Inventory\Item;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\Inventory\UOM;

/**
 *
 * @author ervinne
 */
trait BelongsToAnItem {

    public function itemType() {
        return $this->belongsTo(ItemType::class, "item_type_code", "code");
    }

    public function item() {
        return $this->belongsTo(Item::class, "item_code");
    }

    public function itemUOM() {
        return $this->belongsTo(UOM::class, "item_uom_code");
    }

}
