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
        return $this->hasMany(UserContact::class, 'user_id');
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

    public function deliveryman()
    {
        return $this->hasOne(DeliveryMan::class);
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

    public function followedSellers()
    {
        return $this->belongsToMany(Seller::class, 'user_follows_sellers');
    }

    public function followedManufacturers()
    {
        return $this->belongsToMany(Manufacturer::class, 'user_follows_manufacturers');
    }

    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    // Enhanced Profile Relationships
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class)->orderByDate();
    }

    public function educations()
    {
        return $this->hasMany(UserEducation::class)->orderByDate();
    }

    public function certifications()
    {
        return $this->hasMany(UserCertification::class)->orderByDate();
    }

    public function connections()
    {
        return $this->hasMany(UserConnection::class)->accepted();
    }

    public function pendingConnections()
    {
        return $this->hasMany(UserConnection::class, 'connected_user_id')->pending();
    }

    public function sentConnectionRequests()
    {
        return $this->hasMany(UserConnection::class)->pending();
    }

    // Helper methods for profile
    public function getFullNameAttribute()
    {
        if ($this->profile) {
            return $this->profile->full_name;
        }
        return $this->name;
    }

    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile) {
            return $this->profile->profile_picture_url;
        }
        
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        $initials = strtoupper(substr($this->name, 0, 2));
        return "https://ui-avatars.com/api/?name={$initials}&background=f59e0b&color=0d0d1e&size=200";
    }

    public function isConnectedWith($userId)
    {
        return $this->connections()->where('connected_user_id', $userId)->exists();
    }

    public function hasPendingConnectionWith($userId)
    {
        return $this->sentConnectionRequests()->where('connected_user_id', $userId)->exists();
    }

    public function getCurrentJobAttribute()
    {
        return $this->workExperiences()->current()->first();
    }

    public function getConnectionCountAttribute()
    {
        return $this->connections()->count();
    }

}
