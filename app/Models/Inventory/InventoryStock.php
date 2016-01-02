<?php

namespace App\Models\Inventory;

use App\Exceptions\OutOfStockException;
use App\Models\BelongsToAnItem;
use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model {

    use BelongsToAnItem;

    public $incrementing  = false;
    public $timestamps    = false;
    protected $table      = "inventory_stock_stack";
    protected $primaryKey = [
        "entry_date_time", "item_code", "item_uom_code", "company_code", "location_code", "unit_cost"
    ];
    protected $fillable   = [
        "entry_date_time", "item_code", "item_uom_code", "company_code", "location_code", "unit_cost", "qty", "item_type_code"
    ];

    public static function pullStocks($company, $location, $itemCode, $UOMCode, $qty) {

        $stocks       = [];
        $satisfiedQty = 0;

        while ($satisfiedQty < $qty) {
            $partialStock = InventoryStock::with('item')
                    ->where("company_code", $company)
                    ->where("location_code", $location)
                    ->where("item_code", $itemCode)
                    ->where("item_uom_code", $UOMCode)
                    ->orderBy("entry_date_time")
                    ->first()
            ;

//            echo json_encode($partialStock);

            if ($partialStock) {
                $satisfiedQty += $partialStock->qty;

                //  if there are too many stocks for this batch, use only what's needed
                if ($satisfiedQty > $qty) {
                    $partialStock->qty = $qty;
                }

                array_push($stocks, $partialStock);
            } else {
                throw new OutOfStockException($itemCode, $satisfiedQty, $qty);
            }
        }

        return $stocks;
    }

}
