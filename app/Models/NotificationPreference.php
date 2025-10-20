<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',

        // Orders
        'order_email',
        'order_sms',
        'order_push',

        // Inquiry
        'inquiry_email',
        'inquiry_sms',
        'inquiry_push',

        // Promotions
        'promotions_notifications',
        'promotions_email',
        'promotions_sms',

        // Payments
        'payment_email',
        'payment_sms',
        'payment_push',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
