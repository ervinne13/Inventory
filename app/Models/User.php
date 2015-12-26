<?php

namespace App\Models;

use App\Models\Security\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

    use Notifiable;

    public $incrementing  = false;
    protected $table      = "user";
    protected $primaryKey = "username";
    //  Custom Stateful Properties
    public $accessibleModuleOrder;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Eager loaded relationships
     * @var array 
     */
    protected $with = [
        "roles", "roles.accessControlList", "roles.accessControlList.module"
    ];

    public function roles() {
        return $this->belongsToMany(Role::class, "user_role", "user_username", "role_code");
    }

    //
    /**     * ******************************************************************* */
    // <editor-fold defaultstate="collapsed" desc="Functions">

    public function getAccessibleModuleList() {
        $moduleCodeList = [];

        foreach ($this->roles AS $role) {
            $moduleCodeList = array_merge($moduleCodeList, array_column($role->accessControlList->toArray(), "module_code"));
        }

        return $moduleCodeList;
    }

    public function getSerializedRoleNames() {
        $roles     = $this->roles;
        $roleNames = array_column($roles->toArray(), "name");

        return implode(", ", $roleNames);
    }

    public function hasRole($roleCode) {
        $roleCodes = array_column($this->roles->toArray(), "code");
        return in_array($roleCode, $roleCodes);
    }

    public function setAccessibleModuleOrder(array $moduleOrder) {
        $this->accessibleModuleOrder = $moduleOrder;
    }

    // </editor-fold>
}
