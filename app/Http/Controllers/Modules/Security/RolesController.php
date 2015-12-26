<?php

namespace App\Http\Controllers\Modules\Security;

use App\Http\Controllers\Controller;
use App\Models\Security\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class RolesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.security.roles.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(Role::query())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData         = $this->getDefaultViewData();
        $viewData["mode"] = "create";
        $viewData["role"] = new Role();

        return view("pages.security.roles.form", $viewData);
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
        $viewData         = $this->getDefaultViewData();
        $viewData["mode"] = "view";
        $viewData["role"] = Role::find($id);

        return view("pages.security.roles.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData         = $this->getDefaultViewData();
        $viewData["mode"] = "edit";
        $viewData["role"] = Role::find($id);

        return view("pages.security.roles.form", $viewData);
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

            $role = Role::find($id);

            if (!$role) {
                return response("Role not found", 404);
            }

            $role->fill($request->toArray());
            $role->save();
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
            Role::destroy($id);
        } catch (Exception $e) {
            return response("Unable to delete role, it is currently in use. Once a role is in use, it cannot be deleted anymore!");
        }
    }

}
