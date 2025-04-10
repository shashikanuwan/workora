<?php

namespace App\Models\Queries;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method whereId(int $id)
 */
class UserQueryBuilder extends Builder
{
    public function whereUser(User $user): self
    {
        return $this->whereId($user->id);
    }
}
