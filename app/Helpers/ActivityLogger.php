<?php

namespace App\Helpers;

use App\Models\EmployeeActivity;

class ActivityLogger
{
    /**
     * Log employee activity from anywhere in the application
     * 
     * @param int $sellerId
     * @param string $employeeType (salesman, accountant, warehouse, deliveryman)
     * @param int $employeeId
     * @param string $activityType
     * @param string $description
     * @param mixed $reference (optional model instance)
     * @param array $metadata (optional additional data)
     * @return EmployeeActivity|null
     */
    public static function log(
        int $sellerId,
        string $employeeType,
        int $employeeId,
        string $activityType,
        string $description,
        $reference = null,
        array $metadata = []
    ) {
        try {
            return EmployeeActivity::create([
                'seller_id' => $sellerId,
                'employee_type' => $employeeType,
                'employee_id' => $employeeId,
                'activity_type' => $activityType,
                'description' => $description,
                'reference_type' => $reference ? get_class($reference) : null,
                'reference_id' => $reference ? $reference->id : null,
                'metadata' => $metadata,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log employee activity: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Log activity for authenticated employee
     * 
     * @param string $activityType
     * @param string $description
     * @param mixed $reference (optional model instance)
     * @param array $metadata (optional additional data)
     * @return EmployeeActivity|null
     */
    public static function logForAuth(
        string $activityType,
        string $description,
        $reference = null,
        array $metadata = []
    ) {
        $user = auth()->user();
        
        if (!$user) {
            return null;
        }

        // Determine employee type and get IDs
        $employeeType = null;
        $employeeId = null;
        $sellerId = null;

        if ($user->salesman) {
            $employeeType = 'salesman';
            $employeeId = $user->salesman->id;
            $sellerId = $user->salesman->seller_id;
        } elseif ($user->accountant) {
            $employeeType = 'accountant';
            $employeeId = $user->accountant->id;
            $sellerId = $user->accountant->seller_id;
        } elseif ($user->warehouse) {
            $employeeType = 'warehouse';
            $employeeId = $user->warehouse->id;
            $sellerId = $user->warehouse->seller_id;
        } elseif ($user->deliveryman) {
            $employeeType = 'deliveryman';
            $employeeId = $user->deliveryman->id;
            $sellerId = $user->deliveryman->seller_id ?? null;
        }

        if (!$employeeType || !$employeeId || !$sellerId) {
            return null;
        }

        return self::log(
            $sellerId,
            $employeeType,
            $employeeId,
            $activityType,
            $description,
            $reference,
            $metadata
        );
    }

    /**
     * Get recent activities for a seller
     * 
     * @param int $sellerId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getRecentActivities(int $sellerId, int $limit = 10)
    {
        return EmployeeActivity::where('seller_id', $sellerId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get activities for a specific employee
     * 
     * @param string $employeeType
     * @param int $employeeId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getEmployeeActivities(string $employeeType, int $employeeId, int $limit = 10)
    {
        return EmployeeActivity::where('employee_type', $employeeType)
            ->where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
