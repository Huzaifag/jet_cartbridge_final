<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInvoice extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'status',
        'invoice_file',
        'accountant_id',
        'customer_id'
    ];

    protected $with = ['accountant.seller', 'customer', 'order'];

    // Relation with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relation with Accountant
    public function accountant()
    {
        return $this->belongsTo(Accountant::class, 'accountant_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
