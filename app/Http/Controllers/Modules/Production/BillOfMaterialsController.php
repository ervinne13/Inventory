<?php

namespace App\Http\Controllers\Modules\Production;

use App\Http\Controllers\Controller;
use App\Models\MasterFiles\Inventory\ItemType;
use App\Models\MasterFiles\NumberSeries;
use App\Models\Modules\BillOfMaterials;
use App\Models\Modules\RawMaterial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class BillOfMaterialsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.production.bom.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(BillOfMaterials::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData = $this->getDefaultFormViewData();

        $viewData["bom"]       = new BillOfMaterials();
        $viewData["bom"]->code = NumberSeries::getNextNumber(BillOfMaterials::MODULE_CODE);
        $viewData["mode"]      = "create";

        return view("pages.production.bom.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $bom = new BillOfMaterials($request->toArray());
        return $this->saveBOM($bom, json_decode($request->details, true), "store");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $viewData = $this->getDefaultFormViewData();

        $viewData["bom"]  = BillOfMaterials::find($id);
        $viewData["mode"] = "view";

        return view("pages.production.bom.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData = $this->getDefaultFormViewData();

        $viewData["bom"]  = BillOfMaterials::find($id);
        $viewData["mode"] = "edit";

        return view("pages.production.bom.form", $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $bom = BillOfMaterials::find($id);
        $bom->fill($request->toArray());                       
        return $this->saveBOM($bom, json_decode($request->details, true), "update");
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
            RawMaterial::where("bom_code", $id)->delete();
            BillOfMaterials::destroy($id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
    }

    protected function getDefaultFormViewData() {
        $viewData              = $this->getDefaultViewData();
        $viewData["itemTypes"] = ItemType::all();
        return $viewData;
    }

    protected function saveBOM(BillOfMaterials $bom, $detailsJSON, $mode) {
        try {
            DB::beginTransaction();
            $bom->save();

            $details = [];
            foreach ($detailsJSON AS $detail) {
                
                if ($detail["rowState"] == "deleted") {
                    RawMaterial::
                            where("bom_code", $detail["bom_code"])
                            ->where("item_code", $detail["item_code"])
                            ->delete();
                } else if ($detail["rowState"] == "created") {
                    $rawMaterial = new RawMaterial($detail);
                    $rawMaterial->save();
                } else if ($detail["rowState"] == "updated") {
                    $rawMaterial = RawMaterial::firstOrNew([
                                "bom_code"  => $detail["bom_code"],
                                "item_code" => $detail["item_code"],
                    ]);
                    $rawMaterial->fill($detail);
                    $rawMaterial->save();
                }
            }

            if ($mode == "store") {
                NumberSeries::claimNextNumber(BillOfMaterials::MODULE_CODE);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
            return response($e->getMessage(), 500);
        }
    }

}
