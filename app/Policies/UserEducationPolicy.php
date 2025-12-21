<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserEducation;

class UserEducationPolicy
{
    /**
     * Determine whether the user can update the education.
     */
    public function update(User $user, UserEducation $education): bool
    {
        return $user->id === $education->user_id;
    }

    /**
     * Determine whether the user can delete the education.
     */
    public function delete(User $user, UserEducation $education): bool
    {
        return $user->id === $education->user_id;
    }
}