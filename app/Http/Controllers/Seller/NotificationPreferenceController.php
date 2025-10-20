<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\NotificationPreference;
use Illuminate\Http\Request;

class NotificationPreferenceController extends Controller
{
    public function store(Request $request)
    {
        $sellerId = auth('seller')->user()->id;

        $preferences = [
            'order_email' => $request->has('order_email'),
            'order_sms'   => $request->has('order_sms'),
            'order_push'  => $request->has('order_push'),

            'inquiry_email' => $request->has('inquiry_email'),
            'inquiry_sms'   => $request->has('inquiry_sms'),
            'inquiry_push'  => $request->has('inquiry_push'),

            'promotions_notifications' => $request->has('promotions_notifications'),
            'promotions_email'         => $request->has('promotions_email'),
            'promotions_sms'           => $request->has('promotions_sms'),

            'payment_email' => $request->has('payment_email'),
            'payment_sms'   => $request->has('payment_sms'),
            'payment_push'  => $request->has('payment_push'),
        ];

        // update or create (so seller has only one record)
        $settings = NotificationPreference::updateOrCreate(
            ['seller_id' => $sellerId],
            $preferences
        );

        return response()->json([
            'message' => 'Notification preferences saved successfully!',
            'data' => $settings
        ]);
    }

    public function show()
    {
        $settings = NotificationPreference::where('seller_id', auth('seller')->user()->id)->first();

        return response()->json($settings);
    }
}
