<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManufacturerEmployeeActivityController extends Controller
{
    public function index(Request $request)
    {
        $manufacturer = Auth::user();
        
        // Sample employee statistics
        $employeeStats = [
            'total_employees' => 25,
            'active_employees' => 22,
            'todays_activities' => 47,
            'active_now' => 8,
            'orders_processed' => 156,
            'orders_today' => 12,
            'avg_performance' => 87,
            'performance_change' => 5.2
        ];

        // Sample employee activities
        $activities = [
            [
                'id' => 1,
                'employee_name' => 'John Smith',
                'employee_type' => 'salesman',
                'employee_avatar' => null,
                'description' => 'Processed order #ORD-2024-001 for ABC Electronics',
                'type' => 'order',
                'status' => 'completed',
                'time' => now()->subMinutes(15)->diffForHumans()
            ],
            [
                'id' => 2,
                'employee_name' => 'Sarah Johnson',
                'employee_type' => 'accountant',
                'employee_avatar' => null,
                'description' => 'Updated financial records for Q4 2024',
                'type' => 'finance',
                'status' => 'completed',
                'time' => now()->subMinutes(30)->diffForHumans()
            ],
            [
                'id' => 3,
                'employee_name' => 'Mike Wilson',
                'employee_type' => 'warehouse',
                'employee_avatar' => null,
                'description' => 'Restocked inventory for Wireless Headphones',
                'type' => 'inventory',
                'status' => 'completed',
                'time' => now()->subHour()->diffForHumans()
            ],
            [
                'id' => 4,
                'employee_name' => 'Emily Davis',
                'employee_type' => 'delivery',
                'employee_avatar' => null,
                'description' => 'Delivered order #ORD-2024-002 to customer',
                'type' => 'delivery',
                'status' => 'completed',
                'time' => now()->subHours(2)->diffForHumans()
            ],
            [
                'id' => 5,
                'employee_name' => 'Robert Brown',
                'employee_type' => 'salesman',
                'employee_avatar' => null,
                'description' => 'Responded to inquiry from Tech Solutions Inc',
                'type' => 'inquiry',
                'status' => 'pending',
                'time' => now()->subHours(3)->diffForHumans()
            ],
            [
                'id' => 6,
                'employee_name' => 'Lisa Anderson',
                'employee_type' => 'accountant',
                'employee_avatar' => null,
                'description' => 'Generated monthly sales report',
                'type' => 'report',
                'status' => 'completed',
                'time' => now()->subHours(4)->diffForHumans()
            ]
        ];

        // Apply employee type filter
        if ($request->has('employee_type') && $request->employee_type) {
            $activities = array_filter($activities, function($activity) use ($request) {
                return $activity['employee_type'] === $request->employee_type;
            });
        }

        return view('manufacturer.employee-activities.index', compact('employeeStats', 'activities'));
    }

    public function getEmployeePerformance(Request $request)
    {
        $period = $request->get('period', '30');
        $employeeType = $request->get('employee_type', 'all');

        // Generate performance data
        $performance = [
            'overall_performance' => rand(75, 95),
            'productivity_score' => rand(80, 100),
            'efficiency_rating' => rand(70, 90),
            'employee_breakdown' => [
                'salesman' => [
                    'count' => 8,
                    'avg_performance' => rand(80, 95),
                    'top_performer' => 'John Smith'
                ],
                'accountant' => [
                    'count' => 4,
                    'avg_performance' => rand(85, 98),
                    'top_performer' => 'Sarah Johnson'
                ],
                'warehouse' => [
                    'count' => 6,
                    'avg_performance' => rand(75, 90),
                    'top_performer' => 'Mike Wilson'
                ],
                'delivery' => [
                    'count' => 7,
                    'avg_performance' => rand(78, 92),
                    'top_performer' => 'Emily Davis'
                ]
            ],
            'daily_activities' => $this->generateDailyActivities($period)
        ];

        return response()->json($performance);
    }

    private function generateDailyActivities($period)
    {
        $activities = [];
        $days = min($period, 30);

        for ($i = $days; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $activities[] = [
                'date' => $date->format('M d'),
                'total_activities' => rand(20, 80),
                'orders_processed' => rand(5, 25),
                'inquiries_handled' => rand(2, 15),
                'deliveries_made' => rand(3, 20)
            ];
        }

        return $activities;
    }

    public function getEmployeeDetails($employeeId)
    {
        // Sample employee details
        $employee = [
            'id' => $employeeId,
            'name' => 'John Smith',
            'type' => 'salesman',
            'email' => 'john.smith@company.com',
            'phone' => '+1-555-0123',
            'avatar' => null,
            'hire_date' => '2023-01-15',
            'performance_score' => 92,
            'total_activities' => 234,
            'recent_activities' => [
                [
                    'description' => 'Processed order #ORD-2024-001',
                    'type' => 'order',
                    'time' => now()->subMinutes(15)->diffForHumans()
                ],
                [
                    'description' => 'Responded to customer inquiry',
                    'type' => 'inquiry',
                    'time' => now()->subHour()->diffForHumans()
                ]
            ],
            'monthly_stats' => [
                'orders_processed' => 45,
                'inquiries_handled' => 23,
                'customer_satisfaction' => 4.8,
                'response_time' => '2.3 hours'
            ]
        ];

        return response()->json($employee);
    }

    public function exportActivities(Request $request)
    {
        $format = $request->get('format', 'excel');
        $period = $request->get('period', '30');
        $employeeType = $request->get('employee_type', 'all');

        // Here you would generate and return the activities report
        return response()->json([
            'success' => true,
            'message' => 'Employee activities exported successfully',
            'download_url' => '#',
            'filters' => [
                'format' => $format,
                'period' => $period,
                'employee_type' => $employeeType
            ]
        ]);
    }

    public function getActivitySummary(Request $request)
    {
        $period = $request->get('period', '7');

        $summary = [
            'total_activities' => rand(100, 500),
            'avg_daily_activities' => rand(15, 50),
            'most_productive_day' => Carbon::now()->subDays(rand(1, 7))->format('l'),
            'least_productive_day' => Carbon::now()->subDays(rand(1, 7))->format('l'),
            'activity_types' => [
                'orders' => rand(30, 60),
                'inquiries' => rand(20, 40),
                'deliveries' => rand(15, 35),
                'reports' => rand(5, 15),
                'inventory' => rand(10, 25)
            ],
            'employee_performance' => [
                'top_performers' => [
                    ['name' => 'John Smith', 'score' => 95],
                    ['name' => 'Sarah Johnson', 'score' => 92],
                    ['name' => 'Mike Wilson', 'score' => 89]
                ],
                'improvement_needed' => [
                    ['name' => 'Robert Brown', 'score' => 72],
                    ['name' => 'Lisa Anderson', 'score' => 75]
                ]
            ]
        ];

        return response()->json($summary);
    }
}