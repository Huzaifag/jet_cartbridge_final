<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Accountant extends Authenticatable
{
    use HasFactory, HasRoles;
    protected $guard_name = 'accountant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relation with Seller
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // Relation with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
