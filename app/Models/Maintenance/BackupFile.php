<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Model;

class BackupFile extends Model {

    protected $connection = 'backup';
    public $timestamps    = false;
    protected $table      = "backup_file";
    protected $fillable   = ['backup_datetime', 'file_path'];

}
