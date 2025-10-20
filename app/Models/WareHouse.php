<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class WareHouse extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $guard_name = 'warehouse';
    protected $table = 'warehouses';

    protected $fillable = [
        'user_id',
        'status',
        'seller_id',
        'name',
        'avatar',
        'email',
        'phone',
        'designation',
        'salary',
        'joining_date',
    ];

    // Relation with Seller
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
