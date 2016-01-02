<?php

namespace App\Models\MasterFiles\Accounting;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model {

    public $incrementing  = false;
    protected $table      = "currency";
    protected $primaryKey = "code";

}
