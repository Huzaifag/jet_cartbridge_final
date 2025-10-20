<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyDrawEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'lucky_draw_id',
        'customer_id',
        'order_id',
        'entry_code',
        'is_winner',
    ];

    protected $casts = [
        'is_winner' => 'boolean',
    ];

    public function luckyDraw()
    {
        return $this->belongsTo(LuckyDraw::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
