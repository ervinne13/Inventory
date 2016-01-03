<?php

namespace App\Http\Controllers\Modules\MasterFiles;

use App\Http\Controllers\Controller;
use App\Models\MasterFiles\Location;
use App\Models\Security\Role;
use App\Models\Security\UserLocation;
use App\Models\Security\UserRole;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use function response;
use function view;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $viewData = $this->getDefaultViewData();
        return view("pages.master-files.users.index", $viewData);
    }

    public function datatable() {
        return Datatables::of(User::with('roles')->with('locations'))->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $viewData         = $this->getDefaultFormViewData();
        $viewData["mode"] = "create";
        $viewData["user"] = new User();

        return view("pages.master-files.users.form", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        //  TODO add extra validation here

        try {
            $user           = new User($request->toArray());
            $user->password = \Hash::make($request->password);
            $user->save();

            $roles = [];
            foreach ($request->roles AS $role) {
                array_push($roles, [
                    "user_username" => $user->username,
                    "role_code"     => $role,
                ]);
            }

            UserRole::insert($roles);

            $locations = [];
            foreach ($request->locations AS $location) {
                array_push($locations, [
                    "user_username" => $user->username,
                    "company_code"  => "HYTORC", //  TODO, make this dynamic later
                    "location_code" => $location
                ]);
            }

            UserLocation::insert($locations);
        } catch (\Exception $e) {
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
        $viewData         = $this->getDefaultFormViewData();
        $viewData["mode"] = "view";
        $viewData["user"] = User::find($id);

        return view("pages.master-files.users.form", $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $viewData         = $this->getDefaultFormViewData();
        $viewData["mode"] = "edit";
        $viewData["user"] = User::find($id);

        return view("pages.master-files.users.form", $viewData);
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
            $user = User::find($id);
            $user->fill($request->toArray());

            if ($request->password) {
                $user->password = \Hash::make($request->password);
            }

            $user->save();

            $roles = [];
            foreach ($request->roles AS $role) {
                array_push($roles, [
                    "user_username" => $user->username,
                    "role_code"     => $role,
                ]);
            }

            UserRole::where("user_username", $user->username)->delete();
            UserRole::insert($roles);

            $locations = [];
            foreach ($request->locations AS $location) {
                array_push($locations, [
                    "user_username" => $user->username,
                    "company_code"  => "HYTORC", //  TODO, make this dynamic later
                    "location_code" => $location
                ]);
            }

            UserLocation::where("user_username", $user->username)->delete();
            UserLocation::insert($locations);
        } catch (\Exception $e) {
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
            User::destroy($id);
        } catch (Exception $e) {
            return response("Unable to delete user, it is currently in use by other data!");
        }
    }

    protected function getDefaultFormViewData() {
        $viewData = $this->getDefaultViewData();

        if (Auth::user()->hasRole("ADMIN")) {
            $viewData["roles"] = Role::all();
        } else {
            $viewData["roles"] = Role::NonAdmin()->get();
        }

        $viewData["locations"] = Location::all();

        return $viewData;
    }

}
