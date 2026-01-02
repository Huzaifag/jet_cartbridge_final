<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_id',
        'order_number',
        'total_amount',
        'status',
        'delivery_address',
        'delivery_date',
        'notes',
        'seller_response',
        'seller_response_date',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'delivery_date' => 'date',
        'seller_response_date' => 'datetime',
    ];

    /**
     * Get the user that owns the bulk order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the seller for this bulk order
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Get the bulk order items
     */
    public function items()
    {
        return $this->hasMany(BulkOrderItem::class);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'accepted' => 'success',
            'rejected' => 'danger',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * Get formatted status
     */
    public function getFormattedStatusAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * Get total items count
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for recent orders
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}