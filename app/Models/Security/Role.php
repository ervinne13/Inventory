<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    public $incrementing  = false;
    protected $table      = "role";
    protected $primaryKey = "code";
    protected $fillable   = ["code", "name"];

    public function accessControlList() {
        return $this->hasMany(AccessControlList::class, "role_code");
    }

    public function scopeNonAdmin($query) {
        return $query->where("code", "!=", "ADMIN");
    }

}
