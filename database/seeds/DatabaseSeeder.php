<?php

use Illuminate\Database\Seeder;

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
            DB::table("module")->truncate();

            DB::table("role")->truncate();
            DB::table("user")->truncate();

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->call(ModulesSeeder::class);
            $this->call(DefaultRolesAndUsersSeeder::class);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
