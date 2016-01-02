<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Description of AuditableDataObserver
 *
 * @author ervinne
 */
class AuditableDataObserver {

    public function creating(Model $model) {
        if (Auth::check()) {
            $model->created_by = Auth::user()->username;
        }
    }

    public function updating(Model $model) {
        if (Auth::check()) {
            $model->updated_by = Auth::user()->username;
        }
    }

}
