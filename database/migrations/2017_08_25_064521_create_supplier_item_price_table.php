<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierItemPriceTable extends Migration {

    const TABLE_NAME = 'supplier_item_price';

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
            $table->string('supplier_number', 30);
            $table->string('item_type_code', 30);
            $table->string('item_code', 30);
            $table->string('item_name', 100);
            $table->decimal('item_unit_cost', 7, 2);
            $table->timestamps();

            $table->primary(['supplier_number', 'item_code']);
            $table->foreign('item_code')
                    ->references('code')->on('item');
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
