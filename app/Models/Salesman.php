<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Salesman extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $guard_name = 'salesman';

    protected $fillable = [
        'seller_id',
        'user_id',
        'name',
        'avatar',
        'email',
        'phone',
        'designation',
        'salary',
        'joining_date',
        'status'
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
