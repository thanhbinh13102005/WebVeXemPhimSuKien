<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Booking\Http\Controllers\BookingController;

// NGUOI 3: require file nay trong routes/web.php chinh
Route::middleware("auth")->group(function () {
    Route::get("/booking/{showtime}/seats", [BookingController::class, "selectSeats"])->name("booking.seats");
    Route::post("/booking/{showtime}/hold", [BookingController::class, "hold"])->name("booking.hold");
    Route::post("/booking/{showtime}/confirm", [BookingController::class, "confirm"])->name("booking.confirm");
    Route::get("/booking/history", [BookingController::class, "history"])->name("booking.history");
});
