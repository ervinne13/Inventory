<?php

namespace App\Http\Controllers\Modules\Inventory;

use App\Http\Controllers\Controller;
use App\Models\MasterFiles\Company;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\Location;
use App\Models\MasterFiles\NumberSeries;
use App\Models\Modules\TransferOrder;
use App\Models\Modules\TransferOrderDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class TransferOrdersController extends Controller {

    protected $moduleCode = TransferOrder::MODULE_CODE;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.inventory.transfer-orders.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(TransferOrder::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData = $this->getDefaultFormViewData();

        $viewData["transferOrder"] = new TransferOrder();
        $viewData["mode"]          = "create";

        $viewData["transferOrder"]->doc_no   = NumberSeries::getNextNumber($this->moduleCode);
        $viewData["transferOrder"]->doc_date = Carbon::now();
        $viewData["transferOrder"]->status   = "Open";

        $viewData["documentStatus"] = "Open";

        return view("pages.inventory.transfer-orders.form", $viewData);
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

            $transferOrder = new TransferOrder($request->toArray());
            $transferOrder->save();

            $details = json_decode($request->details, true);
            foreach($details AS $key => $value) {
                unset($details[$key]);
            }
            TransferOrderDetail::insert($details);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
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

        $viewData["itemTypes"] = ItemType::all();
        $viewData["companies"] = Company::all();

        if (Auth::user()->hasRole("ADMIN")) {
            $viewData["locations"] = Location::all();
        } else {
            $viewData["locations"] = Auth::user()->locations;
        }

        return $viewData;
    }

}
