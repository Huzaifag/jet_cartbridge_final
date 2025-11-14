<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Order;
use App\Models\Meeting;
use App\Models\UserInquiry;
use App\Models\Message;
use Carbon\Carbon;

class BusinessHistoryController extends Controller
{
    public function index(Request $request)
    {
        $customer = auth()->user();
        
        // Get all sellers the customer has interacted with
        $sellers = Seller::where(function($query) use ($customer) {
            $query->whereHas('orders', function($q) use ($customer) {
                $q->where('customer_id', $customer->id);
            })
            ->orWhereHas('userInquiries', function($q) use ($customer) {
                $q->where('customer_id', $customer->id);
            });
        })
        ->with('user')
        ->withCount([
            'orders' => function($q) use ($customer) {
                $q->where('customer_id', $customer->id);
            }
        ])
        ->get();

        return view('buyer.business-history.index', compact('sellers'));
    }

    public function show(Request $request, $sellerId)
    {
        $customer = auth()->user();
        $seller = Seller::with('user')->findOrFail($sellerId);
        
        // Filters
        $timeFilter = $request->get('time', 'all');
        $categoryFilter = $request->get('category', 'all');
        $statusFilter = $request->get('status', 'all');
        
        // Date range
        $startDate = match($timeFilter) {
            '7days' => Carbon::now()->subDays(7),
            '30days' => Carbon::now()->subDays(30),
            '90days' => Carbon::now()->subDays(90),
            'year' => Carbon::now()->subYear(),
            default => null
        };

        // Get all orders
        $ordersQuery = Order::where('seller_id', $seller->id)
            ->where('customer_id', $customer->id)
            ->with(['orderItems.product']);
        
        if ($startDate) {
            $ordersQuery->where('created_at', '>=', $startDate);
        }
        
        if ($statusFilter !== 'all') {
            $ordersQuery->where('status', $statusFilter);
        }
        
        $orders = $ordersQuery->latest()->get();

        // Get all inquiries
        $inquiriesQuery = UserInquiry::where('seller_id', $seller->id)
            ->where('customer_id', $customer->id)
            ->with(['product', 'contact']);
        
        if ($startDate) {
            $inquiriesQuery->where('created_at', '>=', $startDate);
        }
        
        if ($statusFilter !== 'all') {
            $inquiriesQuery->where('status', $statusFilter);
        }
        
        $inquiries = $inquiriesQuery->latest()->get();

        // Get all meetings
        $meetingsQuery = Meeting::where(function($q) use ($seller) {
            $q->where(function($query) use ($seller) {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $seller->user_id);
            })
            ->orWhere(function($query) use ($seller) {
                $query->where('sender_id', $seller->user_id)
                      ->where('receiver_id', auth()->id());
            });
        });
        
        if ($startDate) {
            $meetingsQuery->where('created_at', '>=', $startDate);
        }
        
        $meetings = $meetingsQuery->latest()->get();

        // Get messages
        $messagesQuery = Message::where('seller_id', $seller->id)
            ->where('customer_id', $customer->id);
        
        if ($startDate) {
            $messagesQuery->where('created_at', '>=', $startDate);
        }
        
        $messages = $messagesQuery->latest()->take(50)->get();

        // Combine timeline
        $timeline = collect();
        
        foreach ($orders as $order) {
            if ($categoryFilter === 'all' || $categoryFilter === 'orders') {
                $timeline->push([
                    'type' => 'order',
                    'date' => $order->created_at,
                    'data' => $order
                ]);
            }
        }
        
        foreach ($inquiries as $inquiry) {
            if ($categoryFilter === 'all' || $categoryFilter === 'inquiries') {
                $timeline->push([
                    'type' => 'inquiry',
                    'date' => $inquiry->created_at,
                    'data' => $inquiry
                ]);
            }
        }
        
        foreach ($meetings as $meeting) {
            if ($categoryFilter === 'all' || $categoryFilter === 'meetings') {
                $timeline->push([
                    'type' => 'meeting',
                    'date' => $meeting->created_at,
                    'data' => $meeting
                ]);
            }
        }
        
        foreach ($messages as $message) {
            if ($categoryFilter === 'all' || $categoryFilter === 'messages') {
                $timeline->push([
                    'type' => 'message',
                    'date' => $message->created_at,
                    'data' => $message
                ]);
            }
        }
        
        $timeline = $timeline->sortByDesc('date')->values();

        // Summary stats
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum('total');
        $totalInquiries = $inquiries->count();
        $totalMeetings = $meetings->count();

        return view('buyer.business-history.show', compact(
            'seller',
            'timeline',
            'totalOrders',
            'totalSpent',
            'totalInquiries',
            'totalMeetings',
            'timeFilter',
            'categoryFilter',
            'statusFilter'
        ));
    }
}
