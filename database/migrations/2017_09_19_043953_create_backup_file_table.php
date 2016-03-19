<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackupFileTable extends Migration {

    const TABLE_NAME = 'backup_file';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // <editor-fold defaultstate="collapsed" desc="Pessimistic Validation">
        if (Schema::hasTable(self::TABLE_NAME)) {
            return;
        }
        // </editor-fold>

        Schema::connection('backup')->create(self::TABLE_NAME, function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('backup_datetime');
            $table->string('file_path', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        // <editor-fold defaultstate="collapsed" desc="Pessimistic Validation">
        if (!Schema::hasTable(self::TABLE_NAME)) {
            return;
        }
        // </editor-fold>

        Schema::connection('backup')->drop(self::TABLE_NAME);
    }

}
