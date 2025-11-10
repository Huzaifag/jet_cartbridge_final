<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
   protected $fillable = [
        'inquiry_id',
        'seller_id',
        'buyer_id',
        'buyer_name',
        'buyer_phone',
        'salesman_id',
        'assigned_to_salesman_id',
        'split_from_salesman_id',
        'email',
        'product_id',
        'message',
        'quantity',
        'target_price',
        'status',
        'priority',
        'assigned_at',
        'split_notes',
        'followed_up_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'followed_up_at' => 'datetime',
    ];

    // Relationships
    public function inquiry()
    {
        return $this->belongsTo(UserInquiry::class, 'inquiry_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function salesman()
    {
        return $this->belongsTo(Salesman::class);
    }

    public function assignedToSalesman()
    {
        return $this->belongsTo(Salesman::class, 'assigned_to_salesman_id');
    }

    public function splitFromSalesman()
    {
        return $this->belongsTo(Salesman::class, 'split_from_salesman_id');
    }

    // Scopes
    public function scopeMyLeads($query, $salesmanId)
    {
        return $query->where(function($q) use ($salesmanId) {
            $q->where('salesman_id', $salesmanId)
              ->orWhere('assigned_to_salesman_id', $salesmanId);
        });
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
}
