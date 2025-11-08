<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManufacturerSettingController extends Controller
{
    public function index()
    {
        $manufacturer = auth()->user()->manufacturer;
        $user = auth()->user();

        // Get or create payment settings
        $paymentSetting = \App\Models\PaymentSetting::firstOrCreate(
            ['manufacturer_id' => $manufacturer->id],
            [
                'default_payout_method' => 'bank',
                'account_holder_name' => null,
                'bank_name' => null,
                'account_number' => null,
                'ifsc_code' => null,
                'upi_id' => null,
                'paypal_email' => null,
            ]
        );

        // Get or create two-factor settings
        $twoFactorSetting = \App\Models\TwoFactorSetting::firstOrCreate(
            ['manufacturer_id' => $manufacturer->id],
            [
                'is_enabled' => false,
                'method' => null,
            ]
        );

        return view('manufacturer.settings.index', compact('manufacturer', 'user', 'paymentSetting', 'twoFactorSetting'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $manufacturer = $user->manufacturer;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'company_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('manufacturers', 'public');
        }

        $manufacturer->update([
            'company_name' => $validated['company_name'],
            'phone' => $validated['phone'] ?? $manufacturer->phone,
            'address' => $validated['address'] ?? $manufacturer->address,
            'logo' => $validated['logo'] ?? $manufacturer->logo
        ]);

        return back()->with('success', 'Profile updated successfully');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password changed successfully');
    }
}
