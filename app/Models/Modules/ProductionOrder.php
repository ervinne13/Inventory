<?php

namespace App\Models\Modules;

use App\Models\BelongsToALocation;
use App\Models\HasAuditLogs;
use App\Models\HasDocDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductionOrder extends Model {

    const MODULE_CODE = "PRO";

    use BelongsToALocation;
    use HasAuditLogs;
    use HasDocDate;

    public $incrementing  = false;
    protected $table      = "production_order";
    protected $primaryKey = "doc_no";
    protected $fillable   = ["doc_no", "doc_date", "company_code", "location_code", "bom_code", "qty_to_produce", "status", "remarks", "total_computed_cost", "total_actual_cost"];
    protected $dates      = ["doc_date"];

    public function billOfMaterials() {
        return $this->belongsTo(BillOfMaterials::class, "bom_code");
    }

    public function details() {
        return $this->hasMany(ProductionOrderDetail::class, "doc_no");
    }

    public function postUsage() {

        foreach ($this->details AS $detail) {
            $itemMovement = $detail->createItemMovement($this);
            $itemMovement->save();
            $itemMovement->post();
        }
    }

    public function postOutput() {
        $itemMovement = $this->createItemMovement();
        $itemMovement->save();
        $itemMovement->post();
    }

    /**
     * @return ItemMovement The generated item movement
     */
    public function createItemMovement() {

        $im = new ItemMovement();

        $im->ref_doc_type   = "PROO"; //  Production Output
        $im->ref_doc_no     = $this->doc_no;
        $im->movement_date  = date("m/d/y H:i a");
        $im->company_code   = $this->company_code;
        $im->location_code  = $this->location_code;
        $im->item_type_code = $this->billOfMaterials->produced_item_type;
        $im->item_code      = $this->billOfMaterials->produced_item_code;
        $im->item_name      = $this->billOfMaterials->produced_item_name;
        $im->item_uom_code  = $this->billOfMaterials->produced_item_uom_code;
        $im->qty            = $this->qty_to_produce;
        $im->unit_cost      = 0;
        $im->remarks        = $this->remarks;
        $im->status         = "Open";

        return $im;
    }

}
