<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'date_of_birth',
        'gender',
        'bio',
        'profile_picture',
        'cover_photo',
        'country',
        'state',
        'city',
        'address',
        'postal_code',
        'latitude',
        'longitude',
        'job_title',
        'company',
        'industry',
        'professional_summary',
        'skills',
        'website',
        'linkedin_url',
        'social_links',
        'profile_public',
        'show_email',
        'show_phone',
        'show_location',
        'email_verified',
        'phone_verified',
        'identity_verified',
        'verified_at',
        'last_active_at',
        'profile_views',
        'connection_count',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'skills' => 'array',
        'social_links' => 'array',
        'profile_public' => 'boolean',
        'show_email' => 'boolean',
        'show_phone' => 'boolean',
        'show_location' => 'boolean',
        'email_verified' => 'boolean',
        'phone_verified' => 'boolean',
        'identity_verified' => 'boolean',
        'verified_at' => 'datetime',
        'last_active_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getLocationAttribute()
    {
        $location = [];
        if ($this->city) $location[] = $this->city;
        if ($this->state) $location[] = $this->state;
        if ($this->country) $location[] = $this->country;
        
        return implode(', ', $location);
    }

    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        
        // Generate avatar based on initials
        $initials = strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
        return "https://ui-avatars.com/api/?name={$initials}&background=f59e0b&color=0d0d1e&size=200";
    }

    public function getCoverPhotoUrlAttribute()
    {
        if ($this->cover_photo) {
            return asset('storage/' . $this->cover_photo);
        }
        
        return asset('images/default-cover.jpg');
    }

    public function incrementProfileViews()
    {
        $this->increment('profile_views');
    }

    public function updateLastActive()
    {
        $this->update(['last_active_at' => now()]);
    }
}