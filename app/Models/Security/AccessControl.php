<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class AccessControl extends Model {

    public $incrementing  = false;
    protected $table      = "access_control";
    protected $primaryKey = "code";

}
