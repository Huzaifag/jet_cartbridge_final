<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'connected_user_id',
        'status',
        'message',
        'connection_type',
        'requested_at',
        'responded_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function connectedUser()
    {
        return $this->belongsTo(User::class, 'connected_user_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }

    public function accept()
    {
        $this->update([
            'status' => 'accepted',
            'responded_at' => now(),
        ]);

        // Create reverse connection
        static::firstOrCreate([
            'user_id' => $this->connected_user_id,
            'connected_user_id' => $this->user_id,
        ], [
            'status' => 'accepted',
            'requested_at' => $this->requested_at,
            'responded_at' => now(),
        ]);

        // Update connection counts
        $this->user->profile?->increment('connection_count');
        $this->connectedUser->profile?->increment('connection_count');
    }

    public function decline()
    {
        $this->update([
            'status' => 'declined',
            'responded_at' => now(),
        ]);
    }

    public function block()
    {
        $this->update([
            'status' => 'blocked',
            'responded_at' => now(),
        ]);
    }
}