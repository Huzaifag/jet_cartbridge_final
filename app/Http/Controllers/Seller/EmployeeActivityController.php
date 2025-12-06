<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\EmployeeActivity;
use App\Models\Salesman;
use App\Models\Accountant;
use App\Models\WareHouse;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeActivityController extends Controller
{
    public function index(Request $request)
    {
        $seller = auth()->user()->seller;

        // Get filter parameters
        $employeeType = $request->get('employee_type', 'all');
        $employeeId = $request->get('employee_id');
        $dateRange = $request->get('date_range', 'today');
        $activityType = $request->get('activity_type');

        // Date range calculation
        $startDate = $this->getStartDate($dateRange);
        $endDate = Carbon::now();

        // Build query
        $query = EmployeeActivity::where('seller_id', $seller->id)
            ->whereBetween('created_at', [$startDate, $endDate]);

        // Filter by employee type
        if ($employeeType !== 'all') {
            $query->where('employee_type', $employeeType);
        }

        // Filter by specific employee
        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        // Filter by activity type
        if ($activityType) {
            $query->where('activity_type', $activityType);
        }

        // Get activities with pagination
        $activities = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get employees for filters
        $salesmen = Salesman::where('seller_id', $seller->id)->where('status', 'active')->get();
        $accountants = Accountant::where('seller_id', $seller->id)->where('status', 'active')->get();
        $warehouses = WareHouse::where('seller_id', $seller->id)->where('status', 'active')->get();
        $deliverymen = DeliveryMan::where('seller_id', $seller->id)->where('status', 'active')->get();

        // Get statistics
        $stats = $this->getStatistics($seller->id, $startDate, $endDate);

        // Get activity summary by employee type
        $activitySummary = $this->getActivitySummary($seller->id, $startDate, $endDate);

        return view('seller.employee-activities.index', compact(
            'activities',
            'salesmen',
            'accountants',
            'warehouses',
            'deliverymen',
            'stats',
            'activitySummary',
            'employeeType',
            'employeeId',
            'dateRange',
            'activityType'
        ));
    }

    private function getStartDate($range)
    {
        switch ($range) {
            case 'today':
                return Carbon::today();
            case 'yesterday':
                return Carbon::yesterday();
            case 'week':
                return Carbon::now()->startOfWeek();
            case 'month':
                return Carbon::now()->startOfMonth();
            case 'quarter':
                return Carbon::now()->startOfQuarter();
            case 'year':
                return Carbon::now()->startOfYear();
            default:
                return Carbon::today();
        }
    }

    private function getStatistics($sellerId, $startDate, $endDate)
    {
        return [
            'total_activities' => EmployeeActivity::where('seller_id', $sellerId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            
            'salesman_activities' => EmployeeActivity::where('seller_id', $sellerId)
                ->where('employee_type', 'salesman')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            
            'accountant_activities' => EmployeeActivity::where('seller_id', $sellerId)
                ->where('employee_type', 'accountant')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            
            'warehouse_activities' => EmployeeActivity::where('seller_id', $sellerId)
                ->where('employee_type', 'warehouse')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            
            'deliveryman_activities' => EmployeeActivity::where('seller_id', $sellerId)
                ->where('employee_type', 'deliveryman')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
        ];
    }

    private function getActivitySummary($sellerId, $startDate, $endDate)
    {
        $summary = [];

        // Salesman summary
        $salesmen = Salesman::where('seller_id', $sellerId)->where('status', 'active')->get();
        foreach ($salesmen as $salesman) {
            $summary['salesman'][$salesman->id] = [
                'name' => $salesman->name,
                'avatar' => $salesman->avatar,
                'activities' => EmployeeActivity::where('seller_id', $sellerId)
                    ->where('employee_type', 'salesman')
                    ->where('employee_id', $salesman->id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count(),
                'recent_activity' => EmployeeActivity::where('seller_id', $sellerId)
                    ->where('employee_type', 'salesman')
                    ->where('employee_id', $salesman->id)
                    ->latest()
                    ->first(),
            ];
        }

        // Accountant summary
        $accountants = Accountant::where('seller_id', $sellerId)->where('status', 'active')->get();
        foreach ($accountants as $accountant) {
            $summary['accountant'][$accountant->id] = [
                'name' => $accountant->name,
                'avatar' => $accountant->avatar,
                'activities' => EmployeeActivity::where('seller_id', $sellerId)
                    ->where('employee_type', 'accountant')
                    ->where('employee_id', $accountant->id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count(),
                'recent_activity' => EmployeeActivity::where('seller_id', $sellerId)
                    ->where('employee_type', 'accountant')
                    ->where('employee_id', $accountant->id)
                    ->latest()
                    ->first(),
            ];
        }

        // Warehouse summary
        $warehouses = WareHouse::where('seller_id', $sellerId)->where('status', 'active')->get();
        foreach ($warehouses as $warehouse) {
            $summary['warehouse'][$warehouse->id] = [
                'name' => $warehouse->name,
                'avatar' => $warehouse->avatar,
                'activities' => EmployeeActivity::where('seller_id', $sellerId)
                    ->where('employee_type', 'warehouse')
                    ->where('employee_id', $warehouse->id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count(),
                'recent_activity' => EmployeeActivity::where('seller_id', $sellerId)
                    ->where('employee_type', 'warehouse')
                    ->where('employee_id', $warehouse->id)
                    ->latest()
                    ->first(),
            ];
        }

        // Deliveryman summary
        $deliverymen = DeliveryMan::where('seller_id', $sellerId)->where('status', 'active')->get();
        foreach ($deliverymen as $deliveryman) {
            $summary['deliveryman'][$deliveryman->id] = [
                'name' => $deliveryman->name,
                'avatar' => $deliveryman->avatar,
                'activities' => EmployeeActivity::where('seller_id', $sellerId)
                    ->where('employee_type', 'deliveryman')
                    ->where('employee_id', $deliveryman->id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count(),
                'recent_activity' => EmployeeActivity::where('seller_id', $sellerId)
                    ->where('employee_type', 'deliveryman')
                    ->where('employee_id', $deliveryman->id)
                    ->latest()
                    ->first(),
            ];
        }

        return $summary;
    }
}
