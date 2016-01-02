<?php

namespace App\Models\MasterFiles;

use App\Models\Module;
use App\Models\SGModel;
use Carbon\Carbon;
use Exception;

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

    //
    // <editor-fold defaultstate="collapsed" desc="Functions">

    public static function getNextNumber($moduleCode) {

        $numberSeries   = NumberSeries::LatestEffectiveNumberSeries()
                ->moduleCode($moduleCode)
                ->first();
        $code           = $numberSeries->code;
        $numberLength   = strlen($numberSeries->ending_number);
        $lastNumberUsed = $numberSeries->last_number_used ? $numberSeries->last_number_used : $numberSeries->starting_number;

        $nextNumberInt = $lastNumberUsed + 1;
        if (intval($nextNumberInt) > intval($numberSeries->ending_number)) {
            throw new Exception("Cannot generate number series, the ending number is alread reached!");
        }

        $nextNumber = str_pad($nextNumberInt, $numberLength, "0", STR_PAD_LEFT);

        return "{$code}-{$nextNumber}";
    }

    public static function claimNextNumber($moduleCode) {
        $numberSeries   = NumberSeries::LatestEffectiveNumberSeries()
                ->moduleCode($moduleCode)
                ->first();
        $code           = $numberSeries->code;
        $numberLength   = strlen($numberSeries->ending_number);
        $lastNumberUsed = $numberSeries->last_number_used ? $numberSeries->last_number_used : $numberSeries->starting_number;

        $nextNumberInt = $lastNumberUsed + 1;
        if (intval($nextNumberInt) > intval($numberSeries->ending_number)) {
            throw new Exception("Cannot generate number series, the ending number is alread reached!");
        }

        $nextNumber = str_pad($nextNumberInt, $numberLength, "0", STR_PAD_LEFT);

        $numberSeries->last_number_used = $nextNumber;
        $numberSeries->save();
    }

    // </editor-fold>

    /**     * ***************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="Scopes">

    public function scopeLatestEffectiveNumberSeries($query) {
        return $query
                        ->where("effective_date", "<", Carbon::now())
                        ->orderBy("effective_date", "DESC");
    }

    public function scopeModuleCode($query, $moduleCode) {
        return $query->where("module_code", $moduleCode);
    }

    // </editor-fold>

    /**     * ***************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="Mutators">

    public function setEffectiveDateAttribute($value) {
        $this->attributes['effective_date'] = Carbon::createFromFormat('m/d/Y', $value);
    }

    // </editor-fold>
}
