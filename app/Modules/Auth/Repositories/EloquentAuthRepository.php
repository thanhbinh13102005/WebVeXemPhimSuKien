<?php

namespace App\Modules\Auth\Repositories;

use App\Models\User;

/**
 * NGUOI 1 phu trach.
 * Doi sang NoSQL (VD MongoDB): chi can viet lai class nay bang model Mongo,
 * KHONG can sua AuthService hay AuthController.
 */
class EloquentAuthRepository implements AuthRepositoryInterface
{
    public function findByEmail(string $email)
    {
        return User::where("email", $email)->first();
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }
}
