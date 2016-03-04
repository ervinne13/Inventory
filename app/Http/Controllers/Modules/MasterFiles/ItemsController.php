<?php

namespace App\Http\Controllers\Modules\MasterFiles;

use App\Http\Controllers\Controller;
use App\Models\Inventory\LocationItemStockSummary;
use App\Models\MasterFiles\Accounting\Currency;
use App\Models\MasterFiles\Inventory\Item;
use App\Models\MasterFiles\Inventory\ItemImage;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\Inventory\ItemUOM;
use App\Models\MasterFiles\Inventory\UOM;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use function response;
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

    public function itemFiles($itemCode) {
        return ItemImage::where("item_code", $itemCode)->get();
    }

    public function stocksByLocation($locationCode) {
        return LocationItemStockSummary::Location($locationCode)->with('item')->get();
    }

    public function lowStocksByLocation($locationCode) {
        return Item::LowStock($locationCode)->get();
    }

    public function overStocksByLocation($locationCode) {
        return Item::OverStock($locationCode)->get();
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

        try {
            $existingItem = Item::find($request->code);
            if ($existingItem) {
                throw new Exception("This item code is already taken.");
            }

            $existingItemName = Item::where("name", $request->name);
            if ($existingItemName) {
                throw new Exception("This item name is already taken.");
            }

            $this->saveItem(new Item(), $request);
        } catch (Exception $e) {
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
        $viewData = $this->getDefaultFormViewData();

        $viewData["mode"] = "view";
        $viewData["item"] = Item::
                with('images')
                ->with("UOMList")
                ->where("code", $id)
                ->first();

        return view("pages.master-files.items.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData = $this->getDefaultFormViewData();

        $viewData["mode"] = "edit";
        $viewData["item"] = Item::
                with('images')
                ->with("UOMList")
                ->where("code", $id)
                ->first();

        return view("pages.master-files.items.form", $viewData);
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

            $existingItemName = Item::where("name", $request->name);
            if ($existingItemName && $existingItemName->id != $id) {
                throw new Exception("This item name is already taken.");
            }

            $this->saveItem(Item::find($id), $request);
        } catch (Exception $e) {
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

    // </editor-fold>

    /**     * ******************************************************************* */
    // <editor-fold defaultstate="collapsed" desc="Utility Functions">

    protected function getDefaultFormViewData() {
        $viewData = $this->getDefaultViewData();

        $viewData["itemTypes"]          = ItemType::all();
        $viewData["currencies"]         = Currency::all();
        $viewData["unitsOfMeasurement"] = UOM::all();

        return $viewData;
    }

    protected function saveItem(Item $item, Request $request) {

        try {
            DB::beginTransaction();

            $item->fill($request->toArray());
            $item->save();

            if ($request->details) {
                ItemUOM::where("item_code", $item->code)->delete();

                $UOMList = [];
                $details = json_decode($request->details, true);
                foreach ($details AS $UOMDetail) {

                    if ($UOMDetail["is_base_uom"]) {
                        $baseUOM              = new ItemUOM();
                        $baseUOM->item_code   = $item->code;
                        $baseUOM->uom_code    = $UOMDetail["uom_code"];
                        $baseUOM->is_base_uom = true;
                        $baseUOM->save();
                    } else {
                        array_push($UOMList, [
                            "item_code"                => $item->code,
                            "uom_code"                 => $UOMDetail["uom_code"],
                            "is_base_uom"              => $UOMDetail["is_base_uom"],
                            "base_uom_code"            => $UOMDetail["base_uom_code"],
                            "base_uom_conv_multiplier" => $UOMDetail["base_uom_conv_multiplier"] ? $UOMDetail["base_uom_conv_multiplier"] : 1,
                            "base_uom_conv_divider"    => $UOMDetail["base_uom_conv_divider"] ? $UOMDetail["base_uom_conv_divider"] : 1,
                        ]);
                    }
                }

                ItemUOM::insert($UOMList);
            }

            if ($request->images) {

                ItemImage::where("item_code", $item->code)->delete();

                $itemImageList = [];
                foreach ($request->images AS $image) {
                    array_push($itemImageList, [
                        "item_code" => $item->code,
                        "image_url" => "uploads/{$image["server_filename"]}",
                    ]);
                }

                ItemImage::insert($itemImageList);
            }

            DB::commit();
        } catch (Exception $e) {
            //  use the exception for rolling back only, let the controller methods handle
            DB::rollBack();
            throw $e;
        }
    }

    // </editor-fold>
}
