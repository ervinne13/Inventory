<?php

namespace App\Models\MasterFiles\Inventory;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model {

    public $incrementing  = false;
    protected $table      = "item_type";
    protected $primarykey = "code";

}
