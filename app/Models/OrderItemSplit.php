<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemSplit extends Model
{
    protected $fillable = [
        'order_id',
        'order_item_ids',
    ];

    protected $casts = [
        'order_item_ids' => 'array', // store JSON as array
    ];

    /**
     * Relation: Split belongs to one order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relation: Split belongs to many order items
     * (we’re fetching items by IDs stored in JSON)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id')
                    ->whereIn('id', $this->order_item_ids ?? []);
    }
}
