<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model {

    public $incrementing  = false;
    public $timestamps    = false;
    protected $table      = "user_location";
    protected $primaryKey = ["user_username", "company_code", "location_code"];

}
