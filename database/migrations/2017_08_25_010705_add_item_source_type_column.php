<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemSourceTypeColumn extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        try {
            DB::beginTransaction();

            Schema::table('item_movement', function ($table) {

                if (!Schema::hasColumn('item_movement', 'item_source')) {
                    $table->string('item_source_type', 32)
                            ->nullable()
                            ->comment("Others / Supplier");
                }
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        try {
            DB::beginTransaction();

            Schema::table('item_movement', function ($table) {

                if (Schema::hasColumn('item_movement', 'item_source')) {
                    $table->dropColumn('item_source_type');
                }
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
