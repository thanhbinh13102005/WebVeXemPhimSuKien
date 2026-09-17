<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Report\Http\Controllers\Admin\DashboardController;
use App\Modules\Report\Http\Controllers\Admin\ReportController;

// NGUOI 5: require file nay trong routes/web.php chinh
Route::middleware(["auth", "role:admin"])->prefix("admin")->name("admin.")->group(function () {
    Route::get("/", [DashboardController::class, "index"])->name("dashboard");
    Route::get("/reports/revenue", [ReportController::class, "revenue"])->name("reports.revenue");
});
