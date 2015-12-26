<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $viewData = $this->getDefaultViewData();
            return view('home', $viewData);
        } else {
            return view("welcome");
        }
    }

}
