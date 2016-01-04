<?php

namespace App\Http\Controllers\Modules\Production;

use App\Exceptions\OutOfStockException;
use App\Http\Controllers\Controller;
use App\Models\Inventory\InventoryStock;
use App\Models\MasterFiles\Company;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\Location;
use App\Models\MasterFiles\NumberSeries;
use App\Models\Modules\BillOfMaterials;
use App\Models\Modules\ProductionOrder;
use App\Models\Modules\ProductionOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class ProductionOrdersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.production.production-orders.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(ProductionOrder::with('location'))->make(true);
    }

    public function productionCostDetails(Request $request) {
        //  TODO: check if this should be done via service instead
        //$BOMCode, $qtyToProduce

        $qtyToProduce = $request->qty_to_produce;

        $bom                    = BillOfMaterials::find($request->BOMCode);
        $requiredMaterials      = $bom->getRequiredInventoriableMaterials();
        $productionOrderDetails = [];
        $stocksPulledOut        = [];
        $outOfStockItems        = [];

        foreach ($requiredMaterials AS $material) {

            $requiredQty = $material->qty * $qtyToProduce / $bom->produced_qty;

            try {
                $stocks = InventoryStock::pullStocks(
                                $request->company_code, $request->location_code, $material->item_code, $material->item_uom_code, $requiredQty
                );

                $stocksPulledOut = array_merge($stocksPulledOut, $stocks);
            } catch (OutOfStockException $oosEx) {
                array_push($outOfStockItems, [
                    "item_code"        => $oosEx->getItemCode(),
                    "item_name"        => $material->item_name,
                    "stocks_remaining" => $oosEx->getStocksRemaining(),
                    "stocks_required"  => $oosEx->getStocksRequired(),
                ]);
            }
        }

        foreach ($stocksPulledOut as $stock) {
            $detail                       = ProductionOrderDetail::createFromStock($stock);
            $detail->actual_incurred_cost = $detail->computed_incurred_cost;
            array_push($productionOrderDetails, $detail);
        }

        return [
            "pulled_out"               => $stocksPulledOut,
            "production_order_details" => $productionOrderDetails,
            "out_of_stock"             => $outOfStockItems,
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData = $this->getDefaultFormViewData();

        $viewData["productionOrder"] = new ProductionOrder();

        $viewData["productionOrder"]->doc_date = date('m/d/Y H:i a');
        $viewData["productionOrder"]->doc_no   = NumberSeries::getNextNumber(ProductionOrder::MODULE_CODE);
        $viewData["productionOrder"]->status   = "Open";
        $viewData["documentStatus"]            = "Open";

        $viewData["mode"] = "create";

        return view("pages.production.production-orders.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $productionOrder = new ProductionOrder($request->toArray());
            $productionOrder->save();

            $details = json_decode($request->details, true);
            for ($i = 0; $i < count($details); $i ++) {
                $details[$i]["doc_no"] = $productionOrder->doc_no;
                unset($details[$i]["rowState"]);
                if (!$details[$i]["line_no"]) {
                    unset($details[$i]["line_no"]);
                }
            }

            ProductionOrderDetail::insert($details);

            if ($productionOrder->status == "Ongoing Production") {
                $productionOrder->postUsage();
            } else if ($productionOrder->status == "Produced") {
                //  requery production order so details will apply
                $productionOrder = ProductionOrder::find($id);
                $productionOrder->postUsage();
                $productionOrder->postOutput();
            }

            NumberSeries::claimNextNumber(ProductionOrder::MODULE_CODE);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            return response($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $viewData = $this->getDefaultFormViewData();

        $viewData["productionOrder"] = ProductionOrder::find($id);
        $viewData["documentStatus"]  = $viewData["productionOrder"]->status;

        $viewData["mode"] = "view";

        //  cannot return to open state again if production is ongoing
        if ($viewData["documentStatus"] == "Ongoing Production") {
            $viewData["statusList"] = ["Ongoing Production", "Produced"];
        }

        return view("pages.production.production-orders.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData = $this->getDefaultFormViewData();

        $viewData["productionOrder"] = ProductionOrder::find($id);
        $viewData["documentStatus"]  = $viewData["productionOrder"]->status;

        $viewData["mode"] = "edit";

        //  cannot return to open state again if production is ongoing
        if ($viewData["documentStatus"] == "Ongoing Production") {
            $viewData["statusList"] = ["Ongoing Production", "Produced"];
        } else if ($viewData["documentStatus"] == "Produced") {
            $viewData["statusList"] = ["Produced"];
        }

        return view("pages.production.production-orders.form", $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            DB::beginTransaction();

            $productionOrder = ProductionOrder::find($id);

            $previousStatus = $productionOrder->status;

            $productionOrder->fill($request->toArray());
            $productionOrder->save();

            ProductionOrderDetail::where("doc_no", $productionOrder->doc_no)->delete();

            $details = json_decode($request->details, true);
            for ($i = 0; $i < count($details); $i ++) {
                $details[$i]["doc_no"] = $productionOrder->doc_no;
                unset($details[$i]["rowState"]);
                if (!$details[$i]["line_no"]) {
                    unset($details[$i]["line_no"]);
                }
            }

            ProductionOrderDetail::insert($details);

            if ($previousStatus == "Open" && $productionOrder->status == "Ongoing Production") {
                $productionOrder->postUsage();
            } else if ($previousStatus == "Ongoing Production" && $productionOrder->status == "Produced") {
                $productionOrder->postOutput();
            } else if ($previousStatus == "Open" && $productionOrder->status == "Produced") {
                $productionOrder->postUsage();
                $productionOrder->postOutput();
            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            return response($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $productionOrder = ProductionOrder::find($id);

            if ($productionOrder->status != "Open") {
                return response("You may only delete production orders that are still open! If you have any mistakes, you may create adjustment entries via item movement.", 500);
            }

            DB::beginTransaction();
            $productionOrder->details()->delete();
            $productionOrder->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

    protected function getDefaultFormViewData() {
        $viewData = $this->getDefaultViewData();

        $viewData["statusList"] = ["Open", "Ongoing Production", "Produced"];

        $viewData["itemTypes"] = ItemType::all();
        $viewData["bomList"]   = BillOfMaterials::all();

        if (Auth::user()->isAdmin()) {
            $viewData["companies"] = Company::all();
            $viewData["locations"] = Location::all();
        } else {
            $viewData["companies"] = Auth::user()->companies;
            $viewData["locations"] = Auth::user()->locations;
        }

        return $viewData;
    }

}
