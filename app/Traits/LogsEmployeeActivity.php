<?php

namespace App\Traits;

use App\Models\EmployeeActivity;

trait LogsEmployeeActivity
{
    /**
     * Log employee activity
     */
    protected function logActivity(
        string $activityType,
        string $description,
        $reference = null,
        array $metadata = []
    ) {
        $employeeType = $this->getEmployeeType();
        $employeeId = $this->getEmployeeId();
        $sellerId = $this->getSellerId();

        if (!$employeeType || !$employeeId || !$sellerId) {
            return;
        }

        EmployeeActivity::create([
            'seller_id' => $sellerId,
            'employee_type' => $employeeType,
            'employee_id' => $employeeId,
            'activity_type' => $activityType,
            'description' => $description,
            'reference_type' => $reference ? get_class($reference) : null,
            'reference_id' => $reference ? $reference->id : null,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Get employee type from authenticated user
     */
    private function getEmployeeType()
    {
        $user = auth()->user();
        
        if ($user->salesman) return 'salesman';
        if ($user->accountant) return 'accountant';
        if ($user->warehouse) return 'warehouse';
        if ($user->deliveryman) return 'deliveryman';
        
        return null;
    }

    /**
     * Get employee ID from authenticated user
     */
    private function getEmployeeId()
    {
        $user = auth()->user();
        
        if ($user->salesman) return $user->salesman->id;
        if ($user->accountant) return $user->accountant->id;
        if ($user->warehouse) return $user->warehouse->id;
        if ($user->deliveryman) return $user->deliveryman->id;
        
        return null;
    }

    /**
     * Get seller ID from authenticated user
     */
    private function getSellerId()
    {
        $user = auth()->user();
        
        if ($user->salesman && $user->salesman->seller_id) return $user->salesman->seller_id;
        if ($user->accountant && $user->accountant->seller_id) return $user->accountant->seller_id;
        if ($user->warehouse && $user->warehouse->seller_id) return $user->warehouse->seller_id;
        
        // For deliveryman, try to get seller_id from their assigned orders
        if ($user->deliveryman) {
            $deliveryman = $user->deliveryman;
            if (isset($deliveryman->seller_id)) {
                return $deliveryman->seller_id;
            }
            // Fallback: get from most recent order
            $order = \App\Models\Order::where('delivery_person_id', $deliveryman->id)->first();
            return $order ? $order->seller_id : null;
        }
        
        return null;
    }
}
