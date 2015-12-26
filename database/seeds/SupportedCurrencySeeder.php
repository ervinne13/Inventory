<?php

use App\Models\Accounting\Currency;
use Illuminate\Database\Seeder;

class SupportedCurrencySeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $currencies = [
            ["code" => "PHP", "name" => "Philippine Peso"],
            ["code" => "USD", "name" => "US Dollar"],
            ["code" => "KRW", "name" => "Korean Won"],
            ["code" => "JPY", "name" => "Japanese Yen"]
        ];

        Currency::insert($currencies);
    }

}
