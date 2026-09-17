<?php

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Repositories\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(protected AuthRepositoryInterface $authRepo) {}

    public function register(array $data)
    {
        $data["password"] = Hash::make($data["password"]);
        $data["role"] = $data["role"] ?? "user";

        return $this->authRepo->createUser($data);
    }

    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
