<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id', 'product_id', 'quantity', 'price'
    ];

    // Each item belongs to a cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Each item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Subtotal for this item
    public function subtotal()
    {
        return $this->price * $this->quantity;
    }
}
