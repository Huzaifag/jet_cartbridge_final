<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'status'
    ];

    protected $with = ['items.product.seller'];

    

    // A cart belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A cart has many items
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Calculate total cart amount
    public function total()
    {
        return $this->items->sum(fn ($item) => $item->price * $item->quantity);
    }

    // Add item to cart
    public function addItem($product, $quantity = 1)
    {
        $item = $this->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $this->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'price'      => $product->price,
            ]);
        }
    }

    // Remove item from cart
    public function removeItem($productId)
    {
        $this->items()->where('product_id', $productId)->delete();
    }
}
