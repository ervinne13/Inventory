<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Module extends Model {

    public $incrementing  = false;
    protected $table      = "module";
    protected $primaryKey = "code";

    public function scopeAccessibleByCurrentUser($query) {
        return $this->scopeAccessibleBy($query, Auth::user()->getKey());
    }

    public function scopeAccessibleBy($query, $username) {
        
    }

}
