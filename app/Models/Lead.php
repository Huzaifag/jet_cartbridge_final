<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
   protected $fillable = [
        'seller_id',
        'buyer_id',
        'salesman_id',
        'email',
        'product_id',
        'message',
        'status',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function salesman()
    {
        return $this->belongsTo(Salesman::class);
    }
}
