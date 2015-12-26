<?php

namespace App\Models\MasterFiles\Inventory;

use Illuminate\Database\Eloquent\Model;

class UOM extends Model {

    public $incrementing = false;
    public $timestamps   = false;
    protected $table      = "unit_of_measurement";
    protected $primaryKey = "code";
    protected $fillable   = ["code", "name"];

}
