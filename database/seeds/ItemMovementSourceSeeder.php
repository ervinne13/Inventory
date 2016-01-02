<?php

use App\Models\MasterFiles\Accounting\ItemMovementSource;
use Illuminate\Database\Seeder;

class ItemMovementSourceSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $sources = [
            ["code" => "PO", "name" => "Purchase Order", "nature" => "Gain"],
            ["code" => "SI", "name" => "Sales Invoice", "nature" => "Loss"],
            ["code" => "PCO", "name" => "Physical Count Overage", "nature" => "Gain"],
            ["code" => "PCS", "name" => "Physical Count Shortage", "nature" => "Loss"],
            ["code" => "TOI", "name" => "Transfer Order In", "nature" => "Gain"],
            ["code" => "TOO", "name" => "Transfer Order Out", "nature" => "Loss"],
            ["code" => "PROO", "name" => "Production Output", "nature" => "Gain"],
            ["code" => "PROU", "name" => "Production Usage", "nature" => "Loss"],
            ["code" => "IRO", "name" => "Item Reclass Output", "nature" => "Gain"],
            ["code" => "IRU", "name" => "Item Reclass Usage", "nature" => "Loss"],
            ["code" => "IAAG", "name" => "Item Accounting Adjustment (Gain)", "nature" => "Gain"],
            ["code" => "IAAL", "name" => "Item Accounting Adjustment (Loss)", "nature" => "Loss"],
        ];

        ItemMovementSource::insert($sources);
    }

}
