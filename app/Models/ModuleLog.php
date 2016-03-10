<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleLog extends Model {

    public $timestamps  = false;
    protected $table    = "module_log";
    protected $fillable = [
        "module_code", "record_identifier", "action_date", "action", "action_by_username"
    ];
    protected $dates = ["action_date"];

    public function actionBy() {
        return $this->belongsTo(User::class, "action_by_username");
    }

}
