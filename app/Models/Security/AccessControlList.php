<?php

namespace App\Models\Security;

use App\Models\Module;
use Illuminate\Database\Eloquent\Model;

class AccessControlList extends Model {

    public $incrementing  = false;
    protected $table      = "access_control_list";
    protected $primaryKey = ["role_code", "module_code", "access_control_code"];

    public function module() {
        return $this->belongsTo(Module::class, "module_code");
    }

    public function accessControl() {
        return $this->belongsTo(AccessControl::class, "access_control_code");
    }

    public function role() {
        return $this->belongsTo(Role::class, "role_code");
    }

}
