<?php

namespace App\Modules\Report\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Report\Services\ReportService;

class DashboardController extends Controller
{
    public function __construct(protected ReportService $reportService) {}

    public function index()
    {
        $topMovies = $this->reportService->topMovies();
        return view("report-module.admin.dashboard", compact("topMovies"));
    }
}
