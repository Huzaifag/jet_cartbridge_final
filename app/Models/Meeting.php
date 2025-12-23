<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Meeting extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'customer_id',
        'seller_id',
        'manufacturer_id',
        'sender_id',
        'receiver_id',
        'room_name',
        'title',
        'description',
        'message',
        'status',
        'meeting_type',
        'type',
        'scheduled_at',
        'duration',
        'location',
        'admin_notes',
        'created_by_admin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'scheduled_at' => 'datetime',
        'created_by_admin' => 'boolean',
        'duration' => 'integer',
    ];

    /**
     * Boot to auto-generate a unique room_name if not provided.
     */
    protected static function booted()
    {
        static::creating(function ($meeting) {
            if (empty($meeting->room_name)) {
                // Use a human-readable prefix + random string
                $meeting->room_name = 'meeting_' . Str::random(12) . '_' . time();
            }
        });
    }

    // -------------------------
    // Relationships
    // -------------------------
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    // -------------------------
    // Scopes
    // -------------------------
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->orWhere('receiver_id', $userId);
        });
    }

    // -------------------------
    // Helpers
    // -------------------------
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isAccepted(): bool
    {
        return $this->status === self::STATUS_ACCEPTED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function accept(): void
    {
        $this->update(['status' => self::STATUS_ACCEPTED]);
    }

    public function reject(): void
    {
        $this->update(['status' => self::STATUS_REJECTED]);
    }

    public function cancel(): void
    {
        $this->update(['status' => self::STATUS_CANCELLED]);
    }
}
