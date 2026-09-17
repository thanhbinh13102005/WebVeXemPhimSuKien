<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Voucher\Http\Controllers\VoucherController;
use App\Modules\Voucher\Http\Controllers\PaymentController;

// NGUOI 4: require file nay trong routes/web.php chinh
Route::middleware("auth")->group(function () {
    Route::post("/voucher/apply", [VoucherController::class, "apply"])->name("voucher.apply");
    Route::post("/payment/{booking}", [PaymentController::class, "pay"])->name("payment.pay");
});
