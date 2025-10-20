<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Str;
use App\Models\Product;
use App\Models\Promotion;
class Seller extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    
    protected $guard_name = 'seller';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'company_registration_number',
        'company_address',
        'company_city',
        'company_state',
        'company_country',
        'company_postal_code',
        'company_phone',
        'company_website',
        'contact_person_name',
        'contact_person_position',
        'contact_person_email',
        'contact_person_phone',
        'business_type',
        'main_products',
        'years_in_business',
        'number_of_employees',
        'annual_revenue',
        'email',
        'password',
        'status',
        'business_license',
        'tax_certificate',
        'id_proof',
        'company_profile'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'main_products' => 'array',
    ];

    /**
     * Automatically hash the password when it's set.
     *
     * @param string $value
     * @return void
     */


    protected static function booted()
    {
        static::creating(function ($seller) {
            $seller->slug = \Illuminate\Support\Str::slug($seller->company_name);
        });

        // Optional: also update slug when name changes
        static::updating(function ($seller) {
            $seller->slug = \Illuminate\Support\Str::slug($seller->company_name);
        });
    }

    public function setPasswordAttribute($value)
    {
        // Only hash the password if it hasn't been hashed already
        if ($value && !Hash::isHashed($value)) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    /**
     * Get the employees associated with the seller.
     */
    // public function employees()
    // {
    //     return $this->hasMany(Employee::class);
    // }

    // /**
    //  * Get the products for the seller.
    //  */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function accountants(): HasMany
    {
        return $this->hasMany(Accountant::class);
    }

    public function salesmen(): HasMany
    {
        return $this->hasMany(Salesman::class);
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(WareHouse::class);
    }

    public function deliverymen(): HasMany
    {
        return $this->hasMany(DeliveryMan::class);
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customerInquiries()
    {
        return $this->hasMany(UserInquiry::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }
}
