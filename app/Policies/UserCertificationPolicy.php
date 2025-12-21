<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCertification;

class UserCertificationPolicy
{
    /**
     * Determine whether the user can update the certification.
     */
    public function update(User $user, UserCertification $certification): bool
    {
        return $user->id === $certification->user_id;
    }

    /**
     * Determine whether the user can delete the certification.
     */
    public function delete(User $user, UserCertification $certification): bool
    {
        return $user->id === $certification->user_id;
    }
}