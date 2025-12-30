<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManufacturerBusinessHistoryController extends Controller
{
    public function index(Request $request)
    {
        $manufacturer = Auth::user();
        
        // Sample activities data - replace with actual database queries
        $activities = [
            [
                'id' => 1,
                'type' => 'order',
                'title' => 'New Order Received',
                'description' => 'Order #ORD-2024-001 received from ABC Electronics for 50 units of Product A',
                'date' => now()->subHours(2)->format('M d, Y H:i'),
                'details' => [
                    'Order ID' => 'ORD-2024-001',
                    'Customer' => 'ABC Electronics',
                    'Amount' => '$2,500.00'
                ]
            ],
            [
                'id' => 2,
                'type' => 'product',
                'title' => 'Product Updated',
                'description' => 'Product "Wireless Headphones" inventory updated to 150 units',
                'date' => now()->subHours(5)->format('M d, Y H:i'),
                'details' => [
                    'Product' => 'Wireless Headphones',
                    'Previous Stock' => '75 units',
                    'New Stock' => '150 units'
                ]
            ],
            [
                'id' => 3,
                'type' => 'inquiry',
                'title' => 'New Inquiry Received',
                'description' => 'Bulk inquiry received from Tech Solutions Inc for 200 units',
                'date' => now()->subHours(8)->format('M d, Y H:i'),
                'details' => [
                    'Company' => 'Tech Solutions Inc',
                    'Quantity' => '200 units',
                    'Status' => 'Pending Response'
                ]
            ],
            [
                'id' => 4,
                'type' => 'customer',
                'title' => 'New Customer Registration',
                'description' => 'Global Partners registered as a new customer',
                'date' => now()->subDay()->format('M d, Y H:i'),
                'details' => [
                    'Customer' => 'Global Partners',
                    'Type' => 'Business',
                    'Location' => 'Texas, USA'
                ]
            ],
            [
                'id' => 5,
                'type' => 'order',
                'title' => 'Order Shipped',
                'description' => 'Order #ORD-2024-002 has been shipped to Future Innovations',
                'date' => now()->subDays(2)->format('M d, Y H:i'),
                'details' => [
                    'Order ID' => 'ORD-2024-002',
                    'Customer' => 'Future Innovations',
                    'Tracking' => 'TRK123456789'
                ]
            ],
            [
                'id' => 6,
                'type' => 'product',
                'title' => 'New Product Added',
                'description' => 'Added "Smart Watch Pro" to product catalog',
                'date' => now()->subDays(3)->format('M d, Y H:i'),
                'details' => [
                    'Product' => 'Smart Watch Pro',
                    'Category' => 'Electronics',
                    'Price' => '$299.99'
                ]
            ]
        ];

        // Apply filters
        if ($request->has('activity_type') && $request->activity_type) {
            $activities = array_filter($activities, function($activity) use ($request) {
                return $activity['type'] === $request->activity_type;
            });
        }

        if ($request->has('date_range') && $request->date_range && $request->date_range !== 'all') {
            $days = (int) $request->date_range;
            $cutoffDate = Carbon::now()->subDays($days);
            
            $activities = array_filter($activities, function($activity) use ($cutoffDate) {
                $activityDate = Carbon::parse($activity['date']);
                return $activityDate->gte($cutoffDate);
            });
        }

        // Summary statistics
        $summary = [
            'total_orders' => 156,
            'total_products' => 89,
            'total_customers' => 234,
            'total_revenue' => 125678.90
        ];

        return view('manufacturer.business-history.index', compact('activities', 'summary'));
    }

    public function getActivityData(Request $request)
    {
        $type = $request->get('type', 'all');
        $period = $request->get('period', '30');

        // Generate activity data based on filters
        $data = $this->generateActivityData($type, $period);

        return response()->json($data);
    }

    private function generateActivityData($type, $period)
    {
        $activities = [];
        $startDate = Carbon::now()->subDays($period);

        // Generate sample activities for the period
        for ($i = 0; $i < $period; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dayActivities = rand(0, 5);

            for ($j = 0; $j < $dayActivities; $j++) {
                $activityTypes = ['order', 'product', 'inquiry', 'customer'];
                $selectedType = $type === 'all' ? $activityTypes[array_rand($activityTypes)] : $type;

                $activities[] = [
                    'type' => $selectedType,
                    'date' => $date->format('Y-m-d'),
                    'count' => 1
                ];
            }
        }

        return $activities;
    }

    public function exportHistory(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $dateRange = $request->get('date_range', '30');
        $activityType = $request->get('activity_type', 'all');

        // Here you would generate and return the history report
        return response()->json([
            'success' => true,
            'message' => 'Business history exported successfully',
            'download_url' => '#',
            'filters' => [
                'format' => $format,
                'date_range' => $dateRange,
                'activity_type' => $activityType
            ]
        ]);
    }

    public function getStatistics(Request $request)
    {
        $period = $request->get('period', '30');

        // Generate statistics for the period
        $stats = [
            'total_activities' => rand(50, 200),
            'orders_count' => rand(20, 80),
            'products_count' => rand(5, 25),
            'inquiries_count' => rand(10, 40),
            'customers_count' => rand(5, 20),
            'growth_percentage' => rand(-10, 25),
            'most_active_day' => Carbon::now()->subDays(rand(1, 7))->format('l'),
            'activity_trend' => $this->generateTrendData($period)
        ];

        return response()->json($stats);
    }

    private function generateTrendData($period)
    {
        $trend = [];
        $days = min($period, 30); // Limit to 30 days for trend

        for ($i = $days; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trend[] = [
                'date' => $date->format('M d'),
                'activities' => rand(0, 10)
            ];
        }

        return $trend;
    }
}