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
trait HasAuditLogs {

    public static function boot() {
        parent::boot();

        static::updating(function($table) {
            $table->updated_by = Auth::user()->username;
        });

        static::saving(function($table) {
            $table->created_by = Auth::user()->username;
        });
    }

}
