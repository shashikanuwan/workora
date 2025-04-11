<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUser(User $user): User
    {
        return User::query()
            ->with('roles')
            ->whereUser($user)
            ->first();
    }
}
