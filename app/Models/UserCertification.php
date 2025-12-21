<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserCertification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'issuing_organization',
        'organization_logo',
        'credential_id',
        'credential_url',
        'issue_date',
        'expiration_date',
        'does_not_expire',
        'description',
        'skills',
        'verified',
        'verification_document',
        'sort_order',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiration_date' => 'date',
        'does_not_expire' => 'boolean',
        'skills' => 'array',
        'verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getOrganizationLogoUrlAttribute()
    {
        if ($this->organization_logo) {
            return asset('storage/' . $this->organization_logo);
        }
        
        // Generate organization logo placeholder
        $initial = strtoupper(substr($this->issuing_organization, 0, 1));
        return "https://ui-avatars.com/api/?name={$initial}&background=10b981&color=ffffff&size=100";
    }

    public function getIsExpiredAttribute()
    {
        if ($this->does_not_expire || !$this->expiration_date) {
            return false;
        }
        
        return Carbon::now()->isAfter($this->expiration_date);
    }

    public function getExpirationStatusAttribute()
    {
        if ($this->does_not_expire) {
            return 'No expiration date';
        }
        
        if (!$this->expiration_date) {
            return 'No expiration date';
        }
        
        if ($this->is_expired) {
            return 'Expired';
        }
        
        $daysUntilExpiration = Carbon::now()->diffInDays($this->expiration_date, false);
        
        if ($daysUntilExpiration <= 30) {
            return "Expires in {$daysUntilExpiration} days";
        }
        
        return 'Valid';
    }

    public function getFormattedDurationAttribute()
    {
        $issued = $this->issue_date->format('M Y');
        
        if ($this->does_not_expire) {
            return "Issued {$issued} · No expiration date";
        }
        
        if (!$this->expiration_date) {
            return "Issued {$issued}";
        }
        
        $expires = $this->expiration_date->format('M Y');
        return "Issued {$issued} · Expires {$expires}";
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->where('does_not_expire', true)
              ->orWhere('expiration_date', '>', now())
              ->orWhereNull('expiration_date');
        });
    }

    public function scopeExpired($query)
    {
        return $query->where('does_not_expire', false)
                    ->where('expiration_date', '<=', now());
    }

    public function scopeOrderByDate($query)
    {
        return $query->orderBy('issue_date', 'desc');
    }
}