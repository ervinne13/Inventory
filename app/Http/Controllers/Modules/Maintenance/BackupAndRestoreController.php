<?php

namespace App\Http\Controllers\Modules\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\BackupFile;
use Carbon\Carbon;
use Cornford\Backup\Facades\Backup;
use Exception;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class BackupAndRestoreController extends Controller {

    public function index() {
        $viewData = $this->getDefaultViewData();

        return view("pages.maintenance.backup-restore.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(BackupFile::query())->make(true);
    }

    public function backup() {

        try {
            Backup::export();
            $generatedFileName = Backup::getFilename() . ".sql";

            $backupFileEntry = new BackupFile();

            $backupFileEntry->backup_datetime = Carbon::now();
            $backupFileEntry->file_path       = $generatedFileName;

            $backupFileEntry->save();

            return $backupFileEntry;
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function restore($id) {

        try {
            ini_set('max_execution_time', 60 * 4); // 4 minutes
            $backupFileEntry = BackupFile::find($id);
            Backup::restore(Backup::getPath() . "/" . $backupFileEntry->file_path);
            return $backupFileEntry;
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

}
