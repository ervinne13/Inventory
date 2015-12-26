<?php

namespace App\Models\MasterFiles;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

    public $incrementing  = false;
    protected $table      = "location";
    protected $primaryKey = "code";
    protected $fillable = ["code", "name", "company_code"];

    public function company() {
        return $this->belongsTo(Company::class, "company_code");
    }

}
