<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Http\Controllers\AuthController;

// NGUOI 1: require file nay trong routes/web.php chinh cua du an
Route::get("/register", [AuthController::class, "showRegister"])->name("register");
Route::post("/register", [AuthController::class, "register"]);
Route::get("/login", [AuthController::class, "showLogin"])->name("login");
Route::post("/login", [AuthController::class, "login"]);
Route::post("/logout", [AuthController::class, "logout"])->name("logout")->middleware("auth");
