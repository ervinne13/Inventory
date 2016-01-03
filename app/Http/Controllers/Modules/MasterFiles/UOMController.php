<?php

namespace App\Http\Controllers\Modules\MasterFiles;

use App\Http\Controllers\Controller;
use App\Models\MasterFiles\Inventory\UOM;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class UOMController extends Controller {

    protected $moduleCode = UOM::MODULE_CODE;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.master-files.uom.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(UOM::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData = $this->getDefaultViewData();

        $viewData["uom"]  = new UOM();
        $viewData["mode"] = "create";

        return view("pages.master-files.uom.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            $uom = new UOM($request->toArray());
            $uom->save();
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
        $viewData = $this->getDefaultViewData();

        $viewData["uom"]  = UOM::find($id);
        $viewData["mode"] = "view";

        return view("pages.master-files.uom.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData = $this->getDefaultViewData();

        $viewData["uom"]  = UOM::find($id);
        $viewData["mode"] = "edit";

        return view("pages.master-files.uom.form", $viewData);
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
            $uom = UOM::find($id);
            $uom->fill($request->toArray());
            $uom->save();
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
        try {
            UOM::destroy($id);
        } catch (Exception $e) {
            return response("Unable to delete uom, it is currently in use by other data!");
        }
    }

}
