<?php

namespace App\Http\Controllers\Modules\Security;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Security\AccessControl;
use App\Models\Security\AccessControlList;
use App\Models\Security\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as Response2;
use Yajra\Datatables\Facades\Datatables;
use function view;

class ACLController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response2
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.security.acl.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(AccessControlList::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
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
     * @param  string  $code
     * @return Response
     */
    public function show($code) {
        $viewData = $this->getDefaultFormViewData();

        $viewData["mode"] = "view";
        $viewData["role"] = Role::find($code);

        return view("pages.security.acl.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $code the code of this ACL's role
     * @return Response
     */
    public function edit($code) {
        $viewData = $this->getDefaultFormViewData();

        $viewData["mode"] = "edit";
        $viewData["role"] = Role::find($code);

        return view("pages.security.acl.form", $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        
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

        $viewData["accessControls"] = AccessControl::all();
        $viewData["modules"]        = Module::all();

        return $viewData;
    }

}
