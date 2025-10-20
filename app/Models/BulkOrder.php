<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BulkOrder extends Model
{
    protected $fillable = [
        'inquiry_id',
        'product_id',
        'customer_id',
        'seller_id',
        'quantity',
        'unit_price',
        'shipping_cost',
        'total',
        'destination',
        'delivery_date',
        'payment_terms',
        'order_notes',
        'status',
    ];

    protected $with = [
        'inquiry',
        'product',
        'customer',
        'seller',
    ];


    // Relationships
    public function inquiry()
    {
        return $this->belongsTo(UserInquiry::class, 'inquiry_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
