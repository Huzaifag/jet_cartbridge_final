<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkExperience;

class WorkExperiencePolicy
{
    /**
     * Determine whether the user can update the work experience.
     */
    public function update(User $user, WorkExperience $workExperience): bool
    {
        return $user->id === $workExperience->user_id;
    }

    /**
     * Determine whether the user can delete the work experience.
     */
    public function delete(User $user, WorkExperience $workExperience): bool
    {
        return $user->id === $workExperience->user_id;
    }
}