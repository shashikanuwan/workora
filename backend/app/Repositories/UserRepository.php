<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUser(User $user): User
    {
        return User::query()
            ->whereUser($user)
            ->first();
    }
}
