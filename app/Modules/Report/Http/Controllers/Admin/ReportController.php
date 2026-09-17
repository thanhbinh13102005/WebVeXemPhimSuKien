<?php

namespace App\Modules\Report\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Report\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService) {}

    public function revenue(Request $request)
    {
        $from = $request->get("from", now()->startOfMonth()->toDateString());
        $to   = $request->get("to", now()->toDateString());

        $revenue = $this->reportService->revenue($from, $to);

        return view("report-module.admin.revenue", compact("revenue", "from", "to"));
    }
}
