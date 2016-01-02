<?php

namespace App\Models\MasterFiles\Accounting;

use Illuminate\Database\Eloquent\Model;

class ItemMovementSource extends Model {

    public $incrementing  = false;
    protected $table      = "item_movement_source";
    protected $primaryKey = "code";

}
