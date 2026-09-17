<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function showRegister()
    {
        return view("auth-module.register");
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            "name"     => "required|string|max:255",
            "email"    => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
        ]);

        $this->authService->register($data);

        return redirect()->route("login")->with("success", "Dang ky thanh cong, vui long dang nhap.");
    }

    public function showLogin()
    {
        return view("auth-module.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email"    => "required|email",
            "password" => "required",
        ]);

        if ($this->authService->login($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(auth()->user()->role === "admin" ? "/admin" : "/");
        }

        return back()->withErrors(["email" => "Sai email hoac mat khau."]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout();
        $request->session()->invalidate();
        return redirect("/login");
    }
}
