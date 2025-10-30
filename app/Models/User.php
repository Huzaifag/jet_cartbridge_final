<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cart()
    {
        return $this->hasOne(Cart::class)->where('status', 'active');
    }

    public function invoices()
    {
        return $this->hasMany(OrderInvoice::class, 'customer_id');
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function manufacturer()
    {
        return $this->hasOne(Manufacturer::class);
    }

    public function contacts()
    {
        return $this->hasMany(UserContact::class);
    }

    public function userInquiries()
    {
        return $this->hasMany(UserInquiry::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function salesman()
    {
        return $this->hasOne(Salesman::class);
    }

    public function accountant()
    {
        return $this->hasOne(Accountant::class);
    }

    public function warehouse()
    {
        return $this->hasOne(WareHouse::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'customer_id');
    }

    public function sentMeetings()
    {
        return $this->hasMany(Meeting::class, 'sender_id');
    }

    public function receivedMeetings()
    {
        return $this->hasMany(Meeting::class, 'receiver_id');
    }

    public function allMeetings()
    {
        return Meeting::where(function ($q) {
            $q->where('sender_id', $this->id)
                ->orWhere('receiver_id', $this->id);
        });
    }



}
