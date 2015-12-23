<?php

use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $modules = [
            "code" => "IM", "name" => "Item",
            "code" => "COM", "name" => "Company",
            "code" => "LOC", "name" => "Location",
            "code" => "IMov", "name" => "Item Movement",
            "code" => "TI", "name" => "Transfer Item",
            "code" => "MI", "name" => "Manufacture Item"
        ];
        
        
        
    }

}
