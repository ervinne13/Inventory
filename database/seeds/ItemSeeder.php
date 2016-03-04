<?php

use App\Models\MasterFiles\Inventory\Item;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\Inventory\ItemUOM;
use App\Models\MasterFiles\Inventory\UOM;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder {

    protected $rawMaterials = [];
    protected $products     = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->insertUOM();
        $this->insertItemTypes();

//        $this->insertFixedAssets();
//        $this->insertServices();
        $this->insertRawMaterials();
        $this->insertProducts();
        $this->insertItemUOM();
    }

    private function insertUOM() {
        $uoms = [
            ["code" => "unit", "name" => "Unit"],
            ["code" => "pc", "name" => "Piece"],
            ["code" => "box12", "name" => "Box of 12"],
            ["code" => "box5", "name" => "Box of 5"],
            ["code" => "g", "name" => "Gram"],
            ["code" => "kg", "name" => "Kilogram"],
            ["code" => "cm", "name" => "Centimeter"],
            ["code" => "m", "name" => "Meter"],
            ["code" => "min", "name" => "Minute"],
            ["code" => "hr", "name" => "Hour"],
            ["code" => "day", "name" => "Day"],
        ];

        UOM::insert($uoms);
    }

    private function insertItemTypes() {
        $itemTypes = [
//            ["code" => "FA", "name" => "Fixed Asset", "inventoriable" => false],
//            ["code" => "SRVC", "name" => "Services", "inventoriable" => false],
            ["code" => "GRM", "name" => "General Raw Materials", "inventoriable" => true],
            ["code" => "BRM", "name" => "Bolts Raw Materials", "inventoriable" => true],
            ["code" => "MRM", "name" => "Metal Raw Materials", "inventoriable" => true],
            ["code" => "PRM", "name" => "Plastic Raw Materials", "inventoriable" => true],
            ["code" => "PROD", "name" => "Products", "inventoriable" => true],
        ];

        ItemType::insert($itemTypes);
    }

    private function insertFixedAssets() {
        $assets = [
            ["code" => "FA_PRESS_001", "item_type_code" => "FA", "name" => "Example Machine Press 01"],
            ["code" => "FA_PRESS_002", "item_type_code" => "FA", "name" => "Example Machine Press 02"],
        ];

        Item::insert($assets);
    }

    private function insertServices() {
        $services = [
            ["code" => "SRVC_HR_Cost", "item_type_code" => "SRVC", "name" => "Human Resource Cost"],
            ["code" => "SRVC_HR_AGNT_Cost", "item_type_code" => "SRVC", "name" => "Manpower Agency HR Cost"],
                //  TODO: other services here
        ];

        Item::insert($services);
    }

    private function insertRawMaterials() {
        $types = ["GRM", "BRM", "MRM", "PRM"];

        foreach ($types AS $type) {

            for ($i = 0; $i < 20; $i ++) {
                $itemNumber = str_pad($i, 5, "0", STR_PAD_LEFT);
                array_push($this->rawMaterials, [
                    "item_type_code" => $type,
                    "code"           => "{$type}_{$itemNumber}",
                    "name"           => "Sample Raw Material - {$type} {$itemNumber}",
                ]);
            }
        }

        Item::insert($this->rawMaterials);
    }

    private function insertProducts() {

        $this->products = [
            ["code" => "PROD_BLTSHLD", "item_type_code" => "PROD", "name" => "HYTORC BoltShield Protection Cap"],
            ["code" => "PROD_WSHR_2015", "item_type_code" => "PROD", "name" => "HYTORC Washer (2015 Model)"],
            ["code" => "PROD_WSHR_2016", "item_type_code" => "PROD", "name" => "HYTORC Washer (2016 Model)"],
            ["code" => "PROD_ARMITELED", "item_type_code" => "PROD", "name" => "HYTORC Armite LED Plate"],
            ["code" => "PROD_JGUNS", "item_type_code" => "PROD", "name" => "HYTORC J-Gun Single Speed"],
            ["code" => "PROD_JGUND", "item_type_code" => "PROD", "name" => "HYTORC J-Gun Dual Speed"],
            ["code" => "PROD_ZGUN", "item_type_code" => "PROD", "name" => "HYTORC Z-Gun"],
            ["code" => "PROD_HYDRAPUMP", "item_type_code" => "PROD", "name" => "HYTORC Hydraulic Pump"],
            ["code" => "PROD_PNEUMAPUMP", "item_type_code" => "PROD", "name" => "HYTORC Pneumatic Pump"],
                //  TODO: other services here
        ];

        Item::insert($this->products);
    }

    private function insertItemUOM() {

        $uom = [];

        foreach ($this->rawMaterials AS $item) {
            array_push($uom, [
                "item_code"   => $item["code"],
                "uom_code"    => "pc",
                "is_base_uom" => true,
            ]);
        }

        foreach ($this->products AS $item) {
            array_push($uom, [
                "item_code"   => $item["code"],
                "uom_code"    => "unit",
                "is_base_uom" => true,
            ]);
        }


        ItemUOM::insert($uom);
    }

}
