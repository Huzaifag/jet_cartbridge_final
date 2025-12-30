<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ManufacturerNotificationController extends Controller
{
    public function index(Request $request)
    {
        $manufacturer = Auth::user();
        
        // Sample notifications data
        $notifications = [
            [
                'id' => 1,
                'type' => 'order',
                'title' => 'New Order Received',
                'message' => 'You have received a new order #ORD-2024-001 from ABC Electronics worth $2,500.00',
                'data' => [
                    'order_id' => 'ORD-2024-001',
                    'customer' => 'ABC Electronics',
                    'amount' => 2500.00
                ],
                'read_at' => null,
                'created_at' => now()->subMinutes(15),
                'priority' => 'high',
                'action_url' => '/manufacturer/orders/1'
            ],
            [
                'id' => 2,
                'type' => 'inquiry',
                'title' => 'New Bulk Inquiry',
                'message' => 'Tech Solutions Inc has sent a bulk inquiry for 200 units of Wireless Headphones',
                'data' => [
                    'inquiry_id' => 'INQ-2024-001',
                    'company' => 'Tech Solutions Inc',
                    'quantity' => 200,
                    'product' => 'Wireless Headphones'
                ],
                'read_at' => null,
                'created_at' => now()->subHour(),
                'priority' => 'medium',
                'action_url' => '/manufacturer/inquiries/1'
            ],
            [
                'id' => 3,
                'type' => 'inventory',
                'title' => 'Low Stock Alert',
                'message' => 'Smart Watch Pro is running low on stock. Only 5 units remaining.',
                'data' => [
                    'product' => 'Smart Watch Pro',
                    'current_stock' => 5,
                    'threshold' => 10
                ],
                'read_at' => now()->subMinutes(30),
                'created_at' => now()->subHours(2),
                'priority' => 'medium',
                'action_url' => '/manufacturer/products/3'
            ],
            [
                'id' => 4,
                'type' => 'promotion',
                'title' => 'Promotion Performance',
                'message' => 'Your "Summer Electronics Sale" promotion has reached 80% usage limit',
                'data' => [
                    'promotion' => 'Summer Electronics Sale',
                    'usage_percentage' => 80,
                    'remaining_uses' => 20
                ],
                'read_at' => now()->subHours(1),
                'created_at' => now()->subHours(3),
                'priority' => 'low',
                'action_url' => '/manufacturer/promotions/1'
            ],
            [
                'id' => 5,
                'type' => 'payment',
                'title' => 'Payment Received',
                'message' => 'Payment of $1,250.00 received for order #ORD-2024-002',
                'data' => [
                    'order_id' => 'ORD-2024-002',
                    'amount' => 1250.00,
                    'payment_method' => 'Bank Transfer'
                ],
                'read_at' => now()->subHours(2),
                'created_at' => now()->subHours(4),
                'priority' => 'medium',
                'action_url' => '/manufacturer/orders/2'
            ],
            [
                'id' => 6,
                'type' => 'system',
                'title' => 'System Maintenance',
                'message' => 'Scheduled system maintenance will occur tonight from 2:00 AM to 4:00 AM',
                'data' => [
                    'maintenance_start' => '2024-01-15 02:00:00',
                    'maintenance_end' => '2024-01-15 04:00:00'
                ],
                'read_at' => now()->subHours(3),
                'created_at' => now()->subHours(6),
                'priority' => 'low',
                'action_url' => null
            ]
        ];

        // Apply filters
        if ($request->has('type') && $request->type) {
            $notifications = array_filter($notifications, function($notification) use ($request) {
                return $notification['type'] === $request->type;
            });
        }

        if ($request->has('read_status') && $request->read_status !== '') {
            $isRead = $request->read_status === 'read';
            $notifications = array_filter($notifications, function($notification) use ($isRead) {
                return $isRead ? $notification['read_at'] !== null : $notification['read_at'] === null;
            });
        }

        if ($request->has('priority') && $request->priority) {
            $notifications = array_filter($notifications, function($notification) use ($request) {
                return $notification['priority'] === $request->priority;
            });
        }

        // Notification statistics
        $notificationStats = [
            'total_notifications' => count($notifications),
            'unread_count' => count(array_filter($notifications, fn($n) => $n['read_at'] === null)),
            'high_priority' => count(array_filter($notifications, fn($n) => $n['priority'] === 'high')),
            'today_count' => count(array_filter($notifications, fn($n) => Carbon::parse($n['created_at'])->isToday()))
        ];

        return view('manufacturer.notifications.index', compact('notifications', 'notificationStats'));
    }

    public function markAsRead($id)
    {
        // Here you would mark the notification as read in database
        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    public function markAllAsRead()
    {
        // Here you would mark all notifications as read in database
        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    public function delete($id)
    {
        // Here you would delete the notification from database
        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }

    public function deleteAll()
    {
        // Here you would delete all notifications from database
        return response()->json([
            'success' => true,
            'message' => 'All notifications deleted successfully'
        ]);
    }

    public function getUnreadCount()
    {
        // Sample unread count
        $unreadCount = rand(0, 15);

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount
        ]);
    }

    public function getRecentNotifications(Request $request)
    {
        $limit = $request->get('limit', 5);

        // Sample recent notifications
        $notifications = [
            [
                'id' => 1,
                'type' => 'order',
                'title' => 'New Order Received',
                'message' => 'Order #ORD-2024-001 from ABC Electronics',
                'created_at' => now()->subMinutes(5)->diffForHumans(),
                'read_at' => null,
                'priority' => 'high'
            ],
            [
                'id' => 2,
                'type' => 'inquiry',
                'title' => 'New Bulk Inquiry',
                'message' => 'Inquiry from Tech Solutions Inc',
                'created_at' => now()->subMinutes(15)->diffForHumans(),
                'read_at' => null,
                'priority' => 'medium'
            ]
        ];

        return response()->json([
            'success' => true,
            'notifications' => array_slice($notifications, 0, $limit)
        ]);
    }

    public function updatePreferences(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'notification_types' => 'array',
            'notification_types.*' => 'in:order,inquiry,inventory,promotion,payment,system',
            'quiet_hours_start' => 'nullable|date_format:H:i',
            'quiet_hours_end' => 'nullable|date_format:H:i'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would save preferences to database
        return response()->json([
            'success' => true,
            'message' => 'Notification preferences updated successfully'
        ]);
    }

    public function getPreferences()
    {
        // Sample preferences
        $preferences = [
            'email_notifications' => true,
            'sms_notifications' => false,
            'push_notifications' => true,
            'notification_types' => ['order', 'inquiry', 'inventory', 'payment'],
            'quiet_hours_start' => '22:00',
            'quiet_hours_end' => '08:00',
            'frequency' => 'immediate'
        ];

        return response()->json([
            'success' => true,
            'preferences' => $preferences
        ]);
    }

    public function sendTestNotification(Request $request)
    {
        $type = $request->get('type', 'test');

        // Here you would send a test notification
        return response()->json([
            'success' => true,
            'message' => 'Test notification sent successfully'
        ]);
    }

    public function getNotificationStats(Request $request)
    {
        $period = $request->get('period', '30');

        $stats = [
            'total_sent' => rand(100, 500),
            'total_read' => rand(80, 400),
            'read_rate' => rand(70, 95),
            'avg_response_time' => rand(5, 30) . ' minutes',
            'notification_breakdown' => [
                'order' => rand(30, 60),
                'inquiry' => rand(20, 40),
                'inventory' => rand(10, 25),
                'promotion' => rand(5, 15),
                'payment' => rand(15, 30),
                'system' => rand(5, 10)
            ],
            'daily_trend' => $this->generateDailyTrend($period)
        ];

        return response()->json($stats);
    }

    private function generateDailyTrend($period)
    {
        $trend = [];
        $days = min($period, 30);

        for ($i = $days; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trend[] = [
                'date' => $date->format('M d'),
                'sent' => rand(5, 25),
                'read' => rand(3, 20),
                'clicked' => rand(1, 15)
            ];
        }

        return $trend;
    }

    public function exportNotifications(Request $request)
    {
        $format = $request->get('format', 'excel');
        $dateRange = $request->get('date_range', '30');
        $type = $request->get('type', 'all');

        return response()->json([
            'success' => true,
            'message' => 'Notifications exported successfully',
            'download_url' => '#',
            'filters' => [
                'format' => $format,
                'date_range' => $dateRange,
                'type' => $type
            ]
        ]);
    }
}