<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemThreshold extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        try {
            DB::beginTransaction();

            Schema::table('item', function ($table) {

                if (!Schema::hasColumn('item', 'threshold_low')) {
                    $table->integer('threshold_low')
                            ->default(0);
                }

                if (!Schema::hasColumn('item', 'threshold_high')) {
                    $table->integer('threshold_high')
                            ->default(0);
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

            Schema::table('item', function ($table) {

                if (Schema::hasColumn('item', 'threshold')) {
                    $table->dropColumn('threshold');
                }

                if (Schema::hasColumn('item', 'threshold_high')) {
                    $table->dropColumn('threshold_high');
                }
            });

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
