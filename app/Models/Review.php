<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review_text',
        'review_type',
        'media_urls',
        'is_verified_purchase',
        'referral_code'
    ];

    protected $casts = [
        'media_urls' => 'array',
        'is_verified_purchase' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
