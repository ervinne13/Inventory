<?php

namespace App\Models\MasterFiles;

use App\Models\MasterFiles\Purchasing\SupplierItemPrice;
use App\Models\Searchable;
use App\Models\SGModel;

class Supplier extends SGModel {

    use Searchable;

    const MODULE_CODE = "S";

    public $incrementing         = false;
    protected $table             = "supplier";
    protected $primaryKey        = "supplier_number";
    protected $fillable          = ['supplier_number', "is_active", "display_name"];
    protected $searchableColumns = ['supplier_number', "display_name"];

    public function prices() {
        return $this->hasMany(SupplierItemPrice::class, "supplier_number");
    }

}
