<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class DeliveryMan extends Authenticatable
{
    use HasFactory, HasRoles;
    protected $guard_name = 'deliveryman';
    protected $table = 'delivery_men';

    protected $fillable = [
        'user_id',
        'seller_id',
        'name',
        'avatar',
        'email',
        'phone',
        'designation',
        'salary',
        'joining_date',
        'status',
    ];

    // Relation with Seller
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
