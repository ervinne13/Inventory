<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        try {

            DB::beginTransaction();

            //  reset first
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            DB::table("company")->truncate();
            DB::table("location")->truncate();

            DB::table("access_control_list")->truncate();
            DB::table("access_control")->truncate();
            DB::table("number_series")->truncate();
            DB::table("module")->truncate();

            DB::table("role")->truncate();
            DB::table("user_role")->truncate();
            DB::table("user_location")->truncate();
            DB::table("user")->truncate();

            DB::table("exchange_rate")->truncate();
            DB::table("exchange_rate_detail")->truncate();
            DB::table("currency")->truncate();

            //  TODO truncate modules here

            DB::table("location_item_stock_summary")->truncate();
            DB::table("inventory_stock_stack")->truncate();
            
            DB::table("raw_material")->truncate();
            DB::table("bill_of_materials")->truncate();
            
            DB::table("production_order_detail")->truncate();
            DB::table("production_order")->truncate();

            DB::table("item_movement_source")->truncate();
            DB::table("item_movement")->truncate();            

            DB::table("supplier")->truncate();
            DB::table("item")->truncate();
            DB::table("item_type")->truncate();
            DB::table("item_image")->truncate();
            DB::table("item_uom")->truncate();
            DB::table("unit_of_measurement")->truncate();

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->call(ModulesSeeder::class);
            $this->call(NumberSeriesSeeder::class);

            $this->call(CompanyAndLocationSeeder::class);
            $this->call(DefaultRolesAndUsersSeeder::class);

            $this->call(DefaultCurrenciesSeeder::class);

            $this->call(ItemMovementSourceSeeder::class);
            
            $this->call(ItemSeeder::class);
//            $this->call(InitialInventorySeeder::class);
            $this->call(SampleBillOfMaterialsSeeder::class);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
