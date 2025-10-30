<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'customer_id',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'shipping_address',
        'billing_address',
        'notes',
        'is_bulk',
        'invoice',
        'invoice_date',
        'dispatch_video',
        'dispatch_details',
        'courier_name',
        'tracking_number',
        'dispatched_at'
    ];
    

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
    ];

    protected $with = [
        'seller',
        'customer',
        'products',
        'orderItems',
        'statuses'
        
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderInvoice()
    {
        return $this->hasOne(OrderInvoice::class);
    }
    public function orderItemSplit()
    {
        return $this->hasOne(OrderItemSplit::class);
    }

    public function deliveryPerson()
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_person_id');
    }
    public function orderDelivery()
    {
        return $this->hasOne(OrderDelivery::class);
    }
    public function statuses()
    {
        return $this->hasMany(OrderStatus::class);
    }
}
