<?php

namespace App\Http\Controllers\Modules\MasterFiles;

use App\Http\Controllers\Controller;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\NumberSeries;
use App\Models\MasterFiles\Purchasing\SupplierItemPrice;
use App\Models\MasterFiles\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use function response;
use function view;

class SuppliersController extends Controller {

    protected $viewPath = "pages.master-files.suppliers";

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("{$this->viewPath}.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(Supplier::query())->make(true);
    }

    public function itemPrice($supplierNumber, $itemCode) {
        $itemPrice = SupplierItemPrice::Supplier($supplierNumber)->item($itemCode)->first();

        if ($itemPrice) {
            return $itemPrice->item_unit_cost;
        } else {
            return 0;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData             = $this->getDefaultFormViewData();
        $viewData["mode"]     = "create";
        $viewData["supplier"] = new Supplier();

        $viewData["supplier"]->supplier_number = NumberSeries::getNextNumber(Supplier::MODULE_CODE);

        return view("{$this->viewPath}.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $supplier = $this->saveSupplier(new Supplier(), $request);
            NumberSeries::claimNextNumber(Supplier::MODULE_CODE);
            return $supplier;
        } catch (Exception $e) {
//            throw $e;
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $viewData             = $this->getDefaultFormViewData();
        $viewData["mode"]     = "view";
        $viewData["supplier"] = Supplier::find($id);

        return view("{$this->viewPath}.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData             = $this->getDefaultFormViewData();
        $viewData["mode"]     = "edit";
        $viewData["supplier"] = Supplier::find($id);

        return view("{$this->viewPath}.form", $viewData);
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
            $supplier = Supplier::find($id);
            return $this->saveSupplier($supplier, $request);
        } catch (Exception $e) {
//            throw $e;
            return response($e->getMessage(), 500);
        }
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

    protected function saveSupplier(Supplier $supplier, Request $request) {
        try {
            DB::beginTransaction();

            $supplier->fill($request->toArray());
            $supplier->save();

            SupplierItemPrice::where("supplier_number", $supplier->supplier_number)->delete();

            $details = json_decode($request->details, true);
            for ($i = 0; $i < count($details); $i ++) {
                $details[$i]["supplier_number"] = $supplier->supplier_number;
                unset($details[$i]["rowState"]);
            }

            SupplierItemPrice::insert($details);

            DB::commit();
            return $supplier;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function getDefaultFormViewData() {

        $viewData = $this->getDefaultViewData();

        $viewData["itemTypes"]  = ItemType::all();
        $viewData["moduleCode"] = Supplier::MODULE_CODE;

        return $viewData;
    }

}
