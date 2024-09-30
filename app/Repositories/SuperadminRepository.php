<?php

namespace App\Repositories;

use App\Interfaces\Repositories\SuperadminRepositoryInterface;
use App\Models\User;

class SuperadminRepository implements SuperadminRepositoryInterface
{
    public function findByUsername(string $username)
    {
        return User::where('username', $username)->first();
    }
}
