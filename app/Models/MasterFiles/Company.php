<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

    public $incrementing  = false;
    protected $table      = "company";
    protected $primaryKey = "code";

}
