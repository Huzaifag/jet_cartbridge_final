<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'mobile',
        'city',
        'state',
        'address',
        'location_type',
        'status',
    ];

    // Relation with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
