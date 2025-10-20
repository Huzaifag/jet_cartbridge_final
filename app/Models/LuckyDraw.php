<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyDraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'promotion_id',
        'minimum_purchase',
        'prize_description',
        'draw_date',
        'is_winner_announced',
    ];

    protected $casts = [
        'minimum_purchase' => 'decimal:2',
        'draw_date' => 'datetime',
        'is_winner_announced' => 'boolean',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function entries()
    {
        return $this->hasMany(LuckyDrawEntry::class);
    }

    // Get active draws
    public function scopeActive($query)
    {
        return $query->where('is_winner_announced', false)
                     ->whereDate('draw_date', '>=', now());
    }
}
