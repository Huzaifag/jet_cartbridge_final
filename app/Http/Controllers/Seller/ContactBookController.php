<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class ContactBookController extends Controller
{
    public function index(Request $request)
    {
        $seller = auth()->user()->seller;
        
        // Get unique buyers (customers who have placed orders or sent inquiries)
        $buyers = User::where(function($query) use ($seller) {
            $query->whereHas('orders', function($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })
            ->orWhereHas('userInquiries', function($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            });
        })
        ->with([
            'orders' => function($query) use ($seller) {
                $query->where('seller_id', $seller->id)->latest()->take(1);
            },
            'contacts' => function($query) {
                $query->where('status', 'active')->orderBy('created_at', 'desc');
            }
        ])
        ->get()
        ->unique('id');

        // Get team members
        $salesmen = $seller->salesmen()->with('user')->get();
        $accountants = $seller->accountants()->with('user')->get();
        $warehouse = $seller->warehouses()->with('user')->get();
        $delivery = $seller->deliverymen()->with('user')->get();

        // Filter by search
        if ($request->search) {
            $search = $request->search;
            $buyers = $buyers->filter(function($buyer) use ($search) {
                return stripos($buyer->name, $search) !== false || 
                       stripos($buyer->email, $search) !== false ||
                       stripos($buyer->phone, $search) !== false;
            });
        }

        // Filter by type
        $activeTab = $request->get('tab', 'buyers');

        return view('seller.contact-book.index', compact(
            'buyers',
            'salesmen',
            'accountants',
            'warehouse',
            'delivery',
            'activeTab'
        ));
    }
}
