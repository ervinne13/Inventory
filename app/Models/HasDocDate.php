<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Carbon\Carbon;

/**
 *
 * @author ervinne
 */
trait HasDocDate {

    public function setDocDateAttribute($value) {
        $this->attributes['doc_date'] = Carbon::createFromFormat('m/d/Y H:i a', $value);
    }

}
