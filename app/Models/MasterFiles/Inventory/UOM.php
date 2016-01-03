<?php

namespace App\Models\MasterFiles\Inventory;

use Illuminate\Database\Eloquent\Model;

class UOM extends Model {

    const MODULE_CODE = "UOM";

    public $incrementing  = false;
    public $timestamps    = false;
    protected $table      = "unit_of_measurement";
    protected $primaryKey = "code";
    protected $fillable   = ["code", "name"];

}
