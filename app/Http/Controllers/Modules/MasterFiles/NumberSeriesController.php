<?php

namespace App\Http\Controllers\Modules\MasterFiles;

use App\Http\Controllers\Controller;
use App\Models\MasterFiles\NumberSeries;
use App\Models\Module;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SebastianBergmann\RecursionContext\Exception;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class NumberSeriesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.master-files.number-series.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(NumberSeries::with('module')->select('number_series.*'))->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData = $this->getDefaultFormViewData();
        
        $viewData["mode"]                         = "create";
        $viewData["numberSeries"]                 = new NumberSeries();
        $viewData["numberSeries"]->effective_date = date("m/d/Y");

        return view("pages.master-files.number-series.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        try {
            $numberSeries = new NumberSeries($request->toArray());
            $numberSeries->save();
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

        $viewData["numberSeries"] = NumberSeries::find($id);
        $viewData["mode"]         = "view";

        return view("pages.master-files.number-series.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData = $this->getDefaultFormViewData();

        $viewData["numberSeries"] = NumberSeries::find($id);
        $viewData["mode"]         = "edit";

        return view("pages.master-files.number-series.form", $viewData);
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
            $numberSeries = NumberSeries::find($id);
            $numberSeries->fill($request->toArray());
            $numberSeries->save();
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
            NumberSeries::destroy($id);
        } catch (Exception $e) {
            return response("Unable to delete numberSeries, it is currently in use by other data!");
        }
    }

    protected function getDefaultFormViewData() {
        $viewData = $this->getDefaultViewData();

        $viewData["modules"] = Module::all();

        return $viewData;
    }

}
