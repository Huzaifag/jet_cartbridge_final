<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserEducation extends Model
{
    use HasFactory;

    protected $table = 'user_educations';

    protected $fillable = [
        'user_id',
        'institution_name',
        'institution_logo',
        'degree',
        'field_of_study',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'grade',
        'grade_scale',
        'description',
        'activities',
        'achievements',
        'verified',
        'verification_document',
        'sort_order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'grade' => 'decimal:2',
        'activities' => 'array',
        'achievements' => 'array',
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
        
        return $start->format('Y') . ' - ' . ($this->is_current ? 'Present' : $end->format('Y'));
    }

    public function getInstitutionLogoUrlAttribute()
    {
        if ($this->institution_logo) {
            return asset('storage/' . $this->institution_logo);
        }
        
        // Generate institution logo placeholder
        $initial = strtoupper(substr($this->institution_name, 0, 1));
        return "https://ui-avatars.com/api/?name={$initial}&background=3b82f6&color=ffffff&size=100";
    }

    public function getFormattedGradeAttribute()
    {
        if (!$this->grade) {
            return null;
        }
        
        return $this->grade . ($this->grade_scale ? '/' . $this->grade_scale : '');
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