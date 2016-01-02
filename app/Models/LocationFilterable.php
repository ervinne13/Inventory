<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 *
 * @author ervinne
 */
trait LocationFilterable {

    protected $companyField  = "company_code";
    protected $locationField = "location_code";

    public function scopeWithinUserLocation($query) {
        $user = Auth::user();

        if ($user->location_full_access) {
            return $query;
        } else {
            return $query
                            ->where($this->companyField, array_column($user->locations->toArray(), "company_code"))
                            ->where($this->locationField, array_column($user->locations->toArray(), "location_code"))
            ;
        }
    }

}
