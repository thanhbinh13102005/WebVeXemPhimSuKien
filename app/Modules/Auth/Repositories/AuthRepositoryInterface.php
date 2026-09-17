<?php

namespace App\Modules\Auth\Repositories;

interface AuthRepositoryInterface
{
    public function findByEmail(string $email);
    public function createUser(array $data);
}
