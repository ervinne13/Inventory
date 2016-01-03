<?php

namespace App\Http\Controllers\Modules\MasterFiles;

use App\Http\Controllers\Controller;
use App\Models\MasterFiles\Accounting\Currency;
use App\Models\MasterFiles\Inventory\Item;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\Inventory\ItemUOM;
use App\Models\MasterFiles\Inventory\UOM;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use function view;

class ItemsController extends Controller {

    protected $moduleCode = Item::MODULE_CODE;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.master-files.items.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(Item::with("itemType")->select('item.*'))->make(true);
    }

    //
    /**     * ****************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="API">

    public function searchableItemsByNameJsonAPI(Request $request) {
        $itemType   = $request->itemType;
        $filterTerm = trim($request->q);

        $items = Item::ItemTypeCode($itemType)
                ->search($filterTerm)
                ->paginate(15);

        return \Response::json($items);
    }

    public function searchableUOMByItemCodeJSONAPI(Request $request) {
        $itemCode = $request->itemCode;

        if ($itemCode) {

            $filterTerm = trim($request->q);
            $uom        = ItemUOM::ItemCode($itemCode)
                    ->with('uom')
                    ->search($filterTerm)
                    ->paginate(15);

            return \Response::json($uom);
        } else {
            return [];
        }
    }

    // </editor-fold>

    /**     * ****************************************************************** */
    // <editor-fold defaultstate="collapsed" desc="REST">

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData = $this->getDefaultFormViewData();

        $viewData["mode"] = "create";
        $viewData["item"] = new Item();

        return view("pages.master-files.items.form", $viewData);
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

        $viewData["itemTypes"]          = ItemType::all();
        $viewData["currencies"]         = Currency::all();
        $viewData["unitsOfMeasurement"] = UOM::all();

        return $viewData;
    }

    // </editor-fold>
}
