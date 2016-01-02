<?php

use App\Models\MasterFiles\NumberSeries;
use App\Models\Modules\BillOfMaterials;
use App\Models\Modules\RawMaterial;
use Illuminate\Database\Seeder;

class SampleBillOfMaterialsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $bomData = [
            "produced_item_type"     => "PROD",
            "produced_item_code"     => "PROD_BLTSHLD",
            "produced_item_name"     => "HYTORC BoltShield Protection Cap",
            "produced_item_uom_code" => "UNIT",
        ];

        $number    = NumberSeries::getNextNumber(BillOfMaterials::MODULE_CODE);
        $bom       = new BillOfMaterials($bomData);
        $bom->code = $number;
        $bom->save();

        $details = [
            ["bom_code" => $number, "item_code" => "PRM_00001", "item_type_code" => "PRM", "item_name" => "Sample Raw Material - PRM-00001", "item_uom_code" => "pc", "qty" => 2],
            ["bom_code" => $number, "item_code" => "PRM_00002", "item_type_code" => "PRM", "item_name" => "Sample Raw Material - PRM-00002", "item_uom_code" => "pc", "qty" => 1],
            ["bom_code" => $number, "item_code" => "MRM_00004", "item_type_code" => "MRM", "item_name" => "Sample Raw Material - MRM-00004", "item_uom_code" => "pc", "qty" => 1],
            ["bom_code" => $number, "item_code" => "MRM_00005", "item_type_code" => "MRM", "item_name" => "Sample Raw Material - MRM-00005", "item_uom_code" => "pc", "qty" => 3]
        ];

        RawMaterial::insert($details);

        NumberSeries::claimNextNumber(BillOfMaterials::MODULE_CODE);
    }

}
