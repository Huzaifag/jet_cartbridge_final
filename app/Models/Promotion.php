<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'title',
        'type',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function rules()
    {
        return $this->hasMany(PromotionRule::class);
    }

    public function luckyDraw()
    {
        return $this->hasOne(LuckyDraw::class);
    }

    public function entries()
    {
        return $this->hasMany(LuckyDrawEntry::class);
    }

    // Scope for active promotions
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }
}
