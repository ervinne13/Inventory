<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Modules\ItemMovement;
use Carbon\Carbon;
use function view;

class ReportsController extends Controller {

    public function salesReport(ReportRequest $request) {

        $dateFrom = Carbon::createFromFormat("m/d/Y", $request->date_from);
        $dateTo   = Carbon::createFromFormat("m/d/Y", $request->date_to);

        $totalSales   = ItemMovement::getTotalSales($dateFrom, $dateTo);
        $soldItems    = ItemMovement::getSoldItems($dateFrom, $dateTo);
        $invoiceCount = ItemMovement::Sales()
                ->dateFrom($dateFrom)
                ->dateTo($dateTo)
                ->count();

        return view("pages.reports.sales.form", [
            "from"         => $dateFrom,
            "to"           => $dateTo,
            "invoiceCount" => $invoiceCount,
            "totalSales"   => $totalSales,
            "soldItems"    => $soldItems,
        ]);
    }

    public function availableStocks(ReportRequest $request) {
        
    }

}
