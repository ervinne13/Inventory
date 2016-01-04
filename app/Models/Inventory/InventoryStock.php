<?php

namespace App\Models\Inventory;

use App\Exceptions\OutOfStockException;
use App\Models\BelongsToAnItem;
use App\Models\CompositeKeys;
use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model {

    use CompositeKeys;
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

    public static function commitStocks($company, $location, $itemCode, $UOMCode, $qtyToCommit) {
        $stocks                    = [];
        $accumulatedStocksTocommit = 0;

        while ($accumulatedStocksTocommit < $qtyToCommit) {
            $partialStock = InventoryStock::with('item')
                    ->where("company_code", $company)
                    ->where("location_code", $location)
                    ->where("item_code", $itemCode)
                    ->where("item_uom_code", $UOMCode)
                    ->orderBy("entry_date_time")
                    ->first()
            ;            

            if ($partialStock) {

                $stockToCommmit = new InventoryStock($partialStock->toArray());

                //  previously commited stocks is useful for determining the real stock
                //  to commit when multiple lines of partial stocks are taken and
                //  possibly only a portion of the last partial stock is to be taken.
                $previousAccumulatedStock  = $accumulatedStocksTocommit;
                $accumulatedStocksTocommit += $partialStock->qty;

                //  if there are too many stocks for this batch, subtract the needed stock,
                //  otherwise, pull out the whole stock
                if ($accumulatedStocksTocommit > $qtyToCommit) {
                    //  only the remaining needed stock will be subtracted to 
                    //  the partial stock.
                    //  Ex. only 5 stocks are needed and this partial stock has 50,
                    //  this partial stock's qty will now be 45
                    $partialStock->qty = $accumulatedStocksTocommit - $qtyToCommit;
                    $partialStock->save();

                    //  record the difference of the partial stock to the stock to commit
                    //  use the previously commited stock.
                    $stockToCommmit->qty -= $previousAccumulatedStock;

                    array_push($stocks, $partialStock);
                } else {
                    //  delete the partial stock as it's now all used up.
                    //  the stock to commit remains the same as all qty is used
                    //
                    //  also, to avoid composite key issues, destroy is ran via
                    //  the where clauses
                    InventoryStock::
                            where('entry_date_time', $partialStock->entry_date_time)
                            ->where("company_code", $company)
                            ->where("location_code", $location)
                            ->where("item_code", $itemCode)
                            ->where("item_uom_code", $UOMCode)
                            ->delete();
                }

                array_push($stocks, $stockToCommmit);
            } else {
                throw new OutOfStockException($itemCode, $accumulatedStocksTocommit, $qtyToCommit);
            }
        }

        return $stocks;
    }

    public static function pullStocks($company, $location, $itemCode, $UOMCode, $qty) {

        $stocks         = [];
        $satisfiedQty   = 0;
        $accumulatedQty = 0;

        $previousPartialStock = null;

        $commonQuery = InventoryStock::with('item')
                ->where("company_code", $company)
                ->where("location_code", $location)
                ->where("item_code", $itemCode)
                ->where("item_uom_code", $UOMCode)
                ->orderBy("entry_date_time");

        while ($satisfiedQty < $qty) {
            if ($previousPartialStock) {
                //  get next partial stock of the same item, but entered later
                $partialStock = $commonQuery
                        ->where("entry_date_time", ">", $previousPartialStock->entry_date_time)
                        ->first();
            } else {
                $partialStock = $commonQuery->first();
            }

//            echo json_encode($partialStock);

            if ($partialStock) {
                $satisfiedQty += $partialStock->qty;

                //  if there are too many stocks for this batch, use only what's needed
                if ($satisfiedQty > $qty) {
                    $partialStock->qty = $qty - $accumulatedQty;
                }

                array_push($stocks, $partialStock);
                $previousPartialStock = $partialStock;

                $accumulatedQty += $partialStock->qty;
            } else {
                throw new OutOfStockException($itemCode, $satisfiedQty, $qty);
            }
        }

        return $stocks;
    }

}
