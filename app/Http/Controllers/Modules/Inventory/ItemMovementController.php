<?php

namespace App\Http\Controllers\Modules\Inventory;

use App\Http\Controllers\Controller;
use App\Models\MasterFiles\Accounting\ItemMovementSource;
use App\Models\MasterFiles\Company;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\Location;
use App\Models\MasterFiles\Supplier;
use App\Models\Modules\ItemMovement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class ItemMovementController extends Controller {

    protected $moduleCode = "IM";

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.inventory.item-movements.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(ItemMovement::query())->make(true);
    }

    public function postDocument(Request $request, $id) {
        try {
            DB::beginTransaction();

            if ($id && $id != 0) {
                $itemMovement = ItemMovement::find($id);
            } else {
                $itemMovement = new ItemMovement();
            }

            $itemMovement->fill($request->toArray());
            $itemMovement->save();

            $itemMovement->post();
            DB::commit();

            return $itemMovement;
        } catch (Exception $e) {
            DB::rollBack();
//            throw $e;
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData = $this->getDefaultFormViewData();

        $viewData["mode"]                        = "create";
        $viewData["itemMovement"]                = new ItemMovement();
        $viewData["itemMovement"]->status        = "Open";
        $viewData["itemMovement"]->movement_date = date("m/d/Y H:i a", time());

        $viewData["documentStatus"] = "Open";

        return view("pages.inventory.item-movements.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            $itemMovement = new ItemMovement($request->toArray());
            $itemMovement->save();

            return $itemMovement;
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
        $viewData = $this->getDefaultFormViewData();

        $viewData["mode"]         = "view";
        $viewData["itemMovement"] = ItemMovement::find($id);

        return view("pages.inventory.item-movements.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData = $this->getDefaultFormViewData();

        $viewData["mode"]         = "edit";
        $viewData["itemMovement"] = ItemMovement::find($id);

        $viewData["documentStatus"] = $viewData["itemMovement"]->status;

        return view("pages.inventory.item-movements.form", $viewData);
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
            $itemMovement = ItemMovement::find($id);
            $itemMovement->fill($request->toArray());
            $itemMovement->save();

            return $itemMovement;
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
        try {
            DB::beginTransaction();

            ItemMovement::where("id", $id)->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
//            return response($e->getMessage(), 500);
            return response("Unable to delete item movement, it's possible that it's already used in another module. To protect data integrity, this item cannot be deleted anymore.", 500);
        }
    }

    protected function getDefaultFormViewData() {
        $viewData = $this->getDefaultViewData();

        $viewData["itemSourceTypes"] = ["Other/Ext. Document", "Supplier"];
        $viewData["suppliers"]       = Supplier::all();

        $viewData["itemMovementSources"] = ItemMovementSource::all();
        $viewData["itemTypes"]           = ItemType::all();
//        $viewData["items"]               = Item::Active()->get();
        $viewData["companies"]           = Company::all();
        $viewData["locations"]           = Location::all();

        return $viewData;
    }

}
