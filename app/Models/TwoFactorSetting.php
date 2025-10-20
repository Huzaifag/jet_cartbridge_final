<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactorSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'is_enabled',
        'method',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
