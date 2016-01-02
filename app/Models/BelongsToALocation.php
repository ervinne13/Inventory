<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\Models\MasterFiles\Company;
use App\Models\MasterFiles\Location;

/**
 *
 * @author ervinne
 */
trait BelongsToALocation {

    public function company() {
        return $this->belongsTo(Company::class, "company_code");
    }

    public function location() {
        return $this->belongsTo(Location::class, "location_code");
    }

}
