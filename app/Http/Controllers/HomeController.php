<?php

namespace App\Http\Controllers;

use App\Models\MasterFiles\Inventory\Item;
use App\Models\MasterFiles\Location;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use function view;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('query-debug');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index() {


        if (Auth::check()) {
            $viewData            = $this->getDefaultViewData();
            $viewData["reports"] = $this->getAvailableReports();

            if (Auth::user()->hasRole("ADMIN")) {
                $viewData["locations"] = Location::all();
            } else {
                $viewData["locations"] = Auth::user()->locations;
            }

            return view('pages.home.index', $viewData);
        } else {
            return view("welcome");
        }
    }

    private function getAvailableReports() {

        return [
            "sales-report"            => "Sales Report",
            "stocks-available-report" => "Stocks Available"
        ];
    }

}
