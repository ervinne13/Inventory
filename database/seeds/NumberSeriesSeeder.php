<?php

use App\Models\MasterFiles\NumberSeries;
use Illuminate\Database\Seeder;

class NumberSeriesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $numberSeries = [
            ["code" => "S-2017", "module_code" => "S"],
            ["code" => "IM-2017", "module_code" => "IM"],
            ["code" => "IR-2017", "module_code" => "IR"],
            ["code" => "TO-2017", "module_code" => "TO"],
            ["code" => "BOM-2017", "module_code" => "BOM"],
            ["code" => "PRO-2017", "module_code" => "PRO"]
        ];

        for ($i = 0; $i < count($numberSeries); $i ++) {
            $numberSeries[$i]["effective_date"]  = "2017-01-01";
            $numberSeries[$i]["starting_number"] = 0;
            $numberSeries[$i]["ending_number"]   = 99999;
        }

        NumberSeries::insert($numberSeries);
    }

}
