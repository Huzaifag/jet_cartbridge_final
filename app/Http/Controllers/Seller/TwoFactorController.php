<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\TwoFactorSetting;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'is_enabled' => 'required|boolean',
                'method'     => 'nullable|in:sms,email,authenticator_app',
            ]);

            $sellerId = auth('seller')->user()->id; // assumes sellers use the default auth guard

            $twoFactor = TwoFactorSetting::updateOrCreate(
                ['seller_id' => $sellerId], // find by seller_id
                [
                    'is_enabled' => $request->boolean('is_enabled'),
                    'method'     => $request->method, // "sms" | "email" | "authenticator_app"
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Two-Factor settings saved successfully.',
                'data'    => $twoFactor
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the Two-Factor settings.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
