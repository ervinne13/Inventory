<?php

namespace App\Models\MasterFiles;

use App\Models\Module;
use App\Models\SGModel;
use Carbon\Carbon;

class NumberSeries extends SGModel {

    public $incrementing  = false;
    protected $table      = "number_series";
    protected $primaryKey = "code";
    protected $fillable   = ["code", "module_code", "effective_date", "starting_number", "starting_number", "ending_number", "last_number_used"];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['effective_date'];    
    
    public function module() {
        return $this->belongsTo(Module::class, "module_code");
    }

    // <editor-fold defaultstate="collapsed" desc="Mutators">

    public function setEffectiveDateAttribute($value) {
        $this->attributes['effective_date'] = Carbon::createFromFormat('m/d/Y', $value);
    }

    // </editor-fold>
}
