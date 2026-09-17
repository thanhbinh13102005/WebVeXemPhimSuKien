<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Movie\Http\Controllers\MovieController;
use App\Modules\Movie\Http\Controllers\Admin\MovieAdminController;

// NGUOI 2: require file nay trong routes/web.php chinh
Route::get("/movies", [MovieController::class, "index"])->name("movies.index");
Route::get("/movies/{id}", [MovieController::class, "show"])->name("movies.show");

Route::middleware(["auth", "role:admin"])->prefix("admin")->name("admin.")->group(function () {
    Route::get("/movies", [MovieAdminController::class, "index"])->name("movies.index");
    Route::get("/movies/create", [MovieAdminController::class, "create"])->name("movies.create");
    Route::post("/movies", [MovieAdminController::class, "store"])->name("movies.store");
});
