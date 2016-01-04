<?php

namespace App\Models\Modules;

use App\Models\BelongsToAnItem;
use App\Models\Inventory\InventoryStock;
use Illuminate\Database\Eloquent\Model;

class ProductionOrderDetail extends Model {

    use BelongsToAnItem;

    protected $table      = "production_order_detail";
    protected $primaryKey = "line_no";
    protected $fillable   = ["doc_no", "item_type_code", "item_code", "item_name", "item_uom_code", "item_unit_cost", "qty_consumed", "computed_incurred_cost", "actual_incurred_cost"];

    public static function createFromStock(InventoryStock $stock) {

        $detail = new ProductionOrderDetail();

        $detail->item_type_code         = $stock->item_type_code;
        $detail->item_code              = $stock->item_code;
        $detail->item_name              = $stock->item->name;
        $detail->item_uom_code          = $stock->item_uom_code;
        $detail->item_unit_cost         = $stock->unit_cost;
        $detail->qty_consumed           = $stock->qty;
        $detail->computed_incurred_cost = $detail->item_unit_cost * $detail->qty_consumed;
        $detail->actual_incurred_cost   = 0;

        return $detail;
    }

    /**
     * @return ItemMovement The generated item movement
     */
    public function createItemMovement(ProductionOrder $header) {

        $im = new ItemMovement();

        $im->ref_doc_type   = "PROU"; //  Production Usage
        $im->ref_doc_no     = $this->doc_no;
        $im->movement_date  = date("m/d/y H:i a");
        $im->company_code   = $header->company_code;
        $im->location_code  = $header->location_code;
        $im->item_type_code = $this->item_type_code;
        $im->item_code      = $this->item_code;
        $im->item_name      = $this->item_name;
        $im->item_uom_code  = $this->item_uom_code;
        $im->qty            = $this->qty_consumed;
        $im->unit_cost      = $this->item_unit_cost;
        $im->remarks        = $header->remarks;
        $im->status         = "Open";

        return $im;
    }

}
