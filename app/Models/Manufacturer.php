<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [
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
        'user_id',
        'business_license',
        'tax_certificate',
        'id_proof',
        'company_profile'
    ];

    protected $casts = [
        'main_products' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
