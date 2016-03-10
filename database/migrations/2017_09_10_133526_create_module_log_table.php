<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleLogTable extends Migration {

    const TABLE_NAME = 'module_log';

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

        Schema::create(self::TABLE_NAME, function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('module_code', 30);
            $table->string('record_identifier', 30);
            $table->timestamp('action_date');
            $table->string('action', 200);
            $table->string('action_by_username', 30);
//            $table->text('updates_json');
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

        Schema::drop(self::TABLE_NAME);
    }

}
