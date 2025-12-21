<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserConnection;

class UserConnectionPolicy
{
    /**
     * Determine whether the user can update the connection.
     */
    public function update(User $user, UserConnection $connection): bool
    {
        return $user->id === $connection->connected_user_id;
    }
}