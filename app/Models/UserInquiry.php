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
        'customer_id',
        'quantity',
        'target_price',
        'destination',
        'deadline',
        'message',
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

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
