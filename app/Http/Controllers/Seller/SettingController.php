<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use App\Models\TwoFactorSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{

    public function index()
    {
        $sellerId = auth('seller')->user()->id;

        $paymentSetting = PaymentSetting::firstOrCreate(
            ['seller_id' => $sellerId],
            ['default_payout_method' => 'bank'] // set a default if needed
        );

        $twoFactorSetting = TwoFactorSetting::firstOrCreate(
            ['seller_id' => $sellerId]
        );

        return view('seller.settings.index', compact('paymentSetting', 'twoFactorSetting'));
    }


    public function update(Request $request)
    {
        // TODO: Implement settings update logic
        return redirect()->route('seller.settings')->with('success', 'Settings updated successfully');
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user = auth('seller')->user();

            // Check if current password is correct
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['success' => false, 'message' => 'Current password is incorrect.'], 422);
            }

            // Update new password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(['success' => true, 'message' => 'Password updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the password.' . $e->getMessage()], 500);
        }
    }
}
