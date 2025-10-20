<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'default_payout_method' => 'required|string|max:100',
            'account_holder_name'   => 'nullable|string|max:150',
            'bank_name'             => 'nullable|string|max:150',
            'account_number'        => 'nullable|string|max:50',
            'ifsc_code'             => 'nullable|string|max:50',
            'upi_id'                => 'nullable|string|max:100',
            'paypal_email'          => 'nullable|email|max:150',
        ]);

        // Assuming seller is logged in
        $validated['seller_id'] = auth('seller')->user()->id;

        $paymentSetting = PaymentSetting::firstOrCreate([
            'seller_id' => $validated['seller_id']
        ], $validated);

        if ($paymentSetting->exists) {
            $paymentSetting->update($validated);
        }

        return back()->with('success', 'Payment Settings updated successfully');
    }
}
