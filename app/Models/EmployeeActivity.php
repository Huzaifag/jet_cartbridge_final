<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'employee_type',
        'employee_id',
        'activity_type',
        'description',
        'reference_type',
        'reference_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    // Polymorphic relation to employee
    public function employee()
    {
        return $this->morphTo('employee', 'employee_type', 'employee_id');
    }

    // Relation to seller
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // Polymorphic relation to reference (Order, Lead, Product, etc.)
    public function reference()
    {
        return $this->morphTo('reference', 'reference_type', 'reference_id');
    }

    // Get employee name
    public function getEmployeeNameAttribute()
    {
        $employeeClass = 'App\\Models\\' . ucfirst($this->employee_type);
        if (class_exists($employeeClass)) {
            $employee = $employeeClass::find($this->employee_id);
            return $employee ? $employee->name : 'Unknown';
        }
        return 'Unknown';
    }
}
