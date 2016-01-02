<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SGModel extends Model {

    protected $isActiveField = "is_active";

    public function scopeActive($query) {
        return $query->where($this->isActiveField, true);
    }

}
