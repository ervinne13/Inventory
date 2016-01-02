<?php

namespace App\Models\Modules;

use App\Models\BelongsToALocation;
use App\Models\HasDocDate;
use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model {

    const MODULE_CODE = "PRO";

    use BelongsToALocation;
    use HasDocDate;

    public $incrementing  = false;
    protected $table      = "production_order";
    protected $primaryKey = "doc_no";
    protected $fillable   = ["doc_no", "doc_date", "bom_code", "status", "remarks", "total_computed_cost", "total_actual_cost"];

    public function details() {
        return $this->hasMany(ProductionOrderDetail::class, "doc_no");
    }

}
