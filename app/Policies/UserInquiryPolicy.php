<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\Models\UserInquiry;
use Illuminate\Auth\Access\Response;

class UserInquiryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserInquiry $userInquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Product $product): bool
    {

        // Prevent seller from sending inquiry to their own product
        return $product->seller_id !== auth()->user()->seller->id;
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserInquiry $userInquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserInquiry $userInquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserInquiry $userInquiry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserInquiry $userInquiry): bool
    {
        return false;
    }
}
