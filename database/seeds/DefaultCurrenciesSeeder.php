<?php

use App\Models\MasterFiles\Accounting\Currency;
use Illuminate\Database\Seeder;

class DefaultCurrenciesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $currencies = [
            ["code" => "PHP", "name" => "Philippine Peso"],
            ["code" => "USD", "name" => "US Dollar"],
            ["code" => "JPY", "name" => "Japanese Yen"],
            ["code" => "KRW", "name" => "Korean Won"],
        ];

        Currency::insert($currencies);
    }

}
