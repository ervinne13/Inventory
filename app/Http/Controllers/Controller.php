<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected function getDefaultViewData() {

        $viewData = [
            "pageLayout"  => "sidebar-full-height",
            "viewOptions" => [
                "subTitleBar" => false,
                "footer"      => true
            ]
        ];

        if (isset($this->pageTitle)) {
            $viewData["pageTitle"] = $this->pageTitle;
        }

        return $viewData;
    }

}
