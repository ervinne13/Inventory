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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
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
        return Datatables::of(ProductionOrder::query())->make(true);
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
            array_push($productionOrderDetails, ProductionOrderDetail::createFromStock($stock));
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

        $viewData["productionOrder"]->doc_date = Carbon::now();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
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
