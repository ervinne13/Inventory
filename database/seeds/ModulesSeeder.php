<?php

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $modules = [
            ["code" => "I", "name" => "Item"],
            ["code" => "S", "name" => "Supplier"],
            ["code" => "UOM", "name" => "Unit of Measurement"],
            ["code" => "COM", "name" => "Company"],
            ["code" => "LOC", "name" => "Location"],
            ["code" => "IM", "name" => "Item Movement"],
            ["code" => "IR", "name" => "Item Reclass"],
            ["code" => "TO", "name" => "Transfer Order"],
            ["code" => "BOM", "name" => "Bill of Materials"],
            ["code" => "PRO", "name" => "Production Order"],
            ["code" => "ER", "name" => "Exchange Rate"],
        ];

        Module::insert($modules);
    }

}
