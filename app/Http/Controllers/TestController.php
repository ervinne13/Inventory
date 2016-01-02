<?php

namespace App\Http\Controllers;

use App\Models\MasterFiles\NumberSeries;
use App\Models\Modules\BillOfMaterials;

class TestController extends Controller {

    public function test() {
        $numberSeries = NumberSeries::getNextNumber(BillOfMaterials::MODULE_CODE);
        return $numberSeries;
    }

}
