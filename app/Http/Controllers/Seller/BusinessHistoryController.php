<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use App\Models\UserInquiry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessHistoryController extends Controller
{
    public function index(Request $request)
    {
        $seller = auth()->user()->seller;

        // Get all customers who have interacted with this seller
        $customers = User::where(function ($query) use ($seller) {
            $query
                ->whereHas('orders', function ($q) use ($seller) {
                    $q->where('seller_id', $seller->id);
                })
                ->orWhereHas('userInquiries', function ($q) use ($seller) {
                    $q->where('seller_id', $seller->id);
                })
                ->orWhereHas('sentMeetings', function ($q) use ($seller) {
                    $q->where('receiver_id', auth()->id());
                })
                ->orWhereHas('receivedMeetings', function ($q) use ($seller) {
                    $q->where('sender_id', auth()->id());
                });
        })
            ->withCount([
                'orders' => function ($q) use ($seller) {
                    $q->where('seller_id', $seller->id);
                }
            ])
            ->get()
            ->unique('id');

        return view('seller.business-history.index', compact('customers'));
    }

    public function show(Request $request, $customerId)
    {
        $seller = auth()->user()->seller;
        $customer = User::findOrFail($customerId);

        // Filters
        $timeFilter = $request->get('time', 'all');
        $categoryFilter = $request->get('category', 'all');
        $statusFilter = $request->get('status', 'all');

        // Date range based on time filter
        $startDate = match ($timeFilter) {
            '7days' => Carbon::now()->subDays(7),
            '30days' => Carbon::now()->subDays(30),
            '90days' => Carbon::now()->subDays(90),
            'year' => Carbon::now()->subYear(),
            default => null
        };

        // Get all orders
        $ordersQuery = Order::where('seller_id', $seller->id)
            ->where('customer_id', $customerId)
            ->with(['orderItems.product']);

        if ($startDate) {
            $ordersQuery->where('created_at', '>=', $startDate);
        }

        if ($statusFilter !== 'all') {
            $ordersQuery->where('status', $statusFilter);
        }

        $orders = $ordersQuery->latest()->get();

        // Get all inquiries/quotations
        $inquiriesQuery = UserInquiry::where('seller_id', $seller->id)
            ->where('customer_id', $customerId)
            ->with(['product', 'contact']);

        if ($startDate) {
            $inquiriesQuery->where('created_at', '>=', $startDate);
        }

        if ($statusFilter !== 'all') {
            $inquiriesQuery->where('status', $statusFilter);
        }

        $inquiries = $inquiriesQuery->latest()->get();

        // Get all meetings
        $meetingsQuery = Meeting::where(function ($q) use ($customerId) {
            $q
                ->where(function ($query) use ($customerId) {
                    $query
                        ->where('sender_id', $customerId)
                        ->where('receiver_id', auth()->id());
                })
                ->orWhere(function ($query) use ($customerId) {
                    $query
                        ->where('sender_id', auth()->id())
                        ->where('receiver_id', $customerId);
                });
        });

        if ($startDate) {
            $meetingsQuery->where('created_at', '>=', $startDate);
        }

        if ($statusFilter !== 'all') {
            $meetingsQuery->where('status', $statusFilter);
        }

        $meetings = $meetingsQuery->latest()->get();

        // Get all messages/chats
        $messagesQuery = Message::where('seller_id', $seller->id)
            ->where('customer_id', $customerId);

        if ($startDate) {
            $messagesQuery->where('created_at', '>=', $startDate);
        }

        $messages = $messagesQuery->latest()->take(50)->get();

        // Combine all activities into timeline
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

        // Sort timeline by date
        $timeline = $timeline->sortByDesc('date')->values();

        // Summary stats
        $totalOrders = $orders->count();
        $totalSpent = $orders->sum('total');
        $totalInquiries = $inquiries->count();
        $totalMeetings = $meetings->count();

        return view('seller.business-history.show', compact(
            'customer',
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
