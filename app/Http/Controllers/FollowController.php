<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function followSeller(Request $request, $sellerId)
    {
        $seller = Seller::findOrFail($sellerId);
        $user = auth()->user();

        // Check if already following
        $existingFollow = $user->followedSellers()->where('seller_id', $sellerId)->first();

        if ($existingFollow) {
            // Unfollow
            $existingFollow->delete();
            return back()->with('success', 'You have unfollowed ' . $seller->company_name);
        } else {
            // Follow
            $user->followedSellers()->attach($sellerId);
            return back()->with('success', 'You are now following ' . $seller->company_name);
        }
    }

    public function followManufacturer(Request $request, $manufacturerId)
    {
        $manufacturer = Manufacturer::findOrFail($manufacturerId);
        $user = auth()->user();

        // Check if already following
        $existingFollow = $user->followedManufacturers()->where('manufacturer_id', $manufacturerId)->first();

        if ($existingFollow) {
            // Unfollow
            $existingFollow->delete();
            return back()->with('success', 'You have unfollowed ' . $manufacturer->company_name);
        } else {
            // Follow
            $user->followedManufacturers()->attach($manufacturerId);
            return back()->with('success', 'You are now following ' . $manufacturer->company_name);
        }
    }
}
