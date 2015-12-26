<?php

use App\Models\MasterFiles\Company;
use App\Models\MasterFiles\Location;
use Illuminate\Database\Seeder;

class CompanyAndLocationSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $companies = [
            [
                "code"                 => "HYTORC",
                "name"                 => "HYTORC",
                "cost_flow_assumption" => "FIFO"
            ]
        ];

        Company::insert($companies);

        $locations = [
            [
                "company_code" => "HYTORC",
                "code"         => "B_HSQC",
                "name"         => "Holy Spirit Quezon City Branch"
            ],
            [
                "company_code" => "HYTORC",
                "code"         => "W_QC1",
                "name"         => "Quezon City Warehouse 1",
            ],
            [
                "company_code" => "HYTORC",
                "code"         => "W_QC2",
                "name"         => "Quezon City Warehouse 2",
            ],
            [
                "company_code" => "HYTORC",
                "code"         => "W_QC3",
                "name"         => "Quezon City Warehouse 3",
            ], [
                "company_code" => "HYTORC",
                "code"         => "W_QC4",
                "name"         => "Quezon City Warehouse 4",
            ],
        ];

        Location::insert($locations);
    }

}
