<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'product_id',
        'seller_id',
        'manufacturer_id',
        'customer_id',
        'quantity',
        'target_price',
        'destination',
        'deadline',
        'message',
        'status',
        'priority',
        'inquiry_type',
        'admin_notes',
        'follow_up_date',
        'assigned_to',
        'responded_at',
        'response',
    ];

    protected $casts = [
        'deadline' => 'date',
        'follow_up_date' => 'datetime',
        'responded_at' => 'datetime',
        'target_price' => 'decimal:2',
    ];

    // Relationships
    public function contact()
    {
        return $this->belongsTo(UserContact::class, 'contact_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function lead()
    {
        return $this->hasOne(Lead::class, 'inquiry_id');
    }
}
