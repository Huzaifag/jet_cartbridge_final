<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'company_name',
        'company_logo',
        'employment_type',
        'location',
        'is_remote',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'responsibilities',
        'achievements',
        'skills_used',
        'company_website',
        'industry',
        'company_size',
        'verified',
        'verification_document',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_remote' => 'boolean',
        'is_current' => 'boolean',
        'responsibilities' => 'array',
        'achievements' => 'array',
        'skills_used' => 'array',
        'verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDurationAttribute()
    {
        $start = Carbon::parse($this->start_date);
        $end = $this->is_current ? Carbon::now() : Carbon::parse($this->end_date);
        
        $years = $start->diffInYears($end);
        $months = $start->copy()->addYears($years)->diffInMonths($end);
        
        $duration = [];
        if ($years > 0) {
            $duration[] = $years . ' ' . ($years == 1 ? 'year' : 'years');
        }
        if ($months > 0) {
            $duration[] = $months . ' ' . ($months == 1 ? 'month' : 'months');
        }
        
        return implode(' ', $duration) ?: 'Less than a month';
    }

    public function getFormattedDurationAttribute()
    {
        $start = $this->start_date->format('M Y');
        $end = $this->is_current ? 'Present' : $this->end_date->format('M Y');
        
        return "{$start} - {$end} · {$this->duration}";
    }

    public function getCompanyLogoUrlAttribute()
    {
        if ($this->company_logo) {
            return asset('storage/' . $this->company_logo);
        }
        
        // Generate company logo placeholder
        $initial = strtoupper(substr($this->company_name, 0, 1));
        return "https://ui-avatars.com/api/?name={$initial}&background=6b7280&color=ffffff&size=100";
    }

    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    public function scopeOrderByDate($query)
    {
        return $query->orderBy('is_current', 'desc')
                    ->orderBy('start_date', 'desc');
    }
}