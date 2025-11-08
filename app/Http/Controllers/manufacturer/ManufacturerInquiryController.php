<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use App\Models\UserInquiry;
use App\Models\BulkOrder;
use Illuminate\Http\Request;

class ManufacturerInquiryController extends Controller
{
    public function index()
    {
        $manufacturer = auth()->user()->manufacturer;

        $inquiries = UserInquiry::whereHas('product', function ($query) use ($manufacturer) {
            $query->where('manufacturer_id', $manufacturer->id);
        })
            ->with(['product', 'user'])
            ->latest()
            ->paginate(15);

        return view('manufacturer.inquiries.index', compact('inquiries'));
    }

    public function createBulkOrder(UserInquiry $inquiry)
    {
        return view('manufacturer.inquiries.bulk-order-create', compact('inquiry'));
    }

    public function storeBulkOrder(Request $request)
    {
        $validated = $request->validate([
            'inquiry_id' => 'required|exists:user_inquiries,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'delivery_date' => 'required|date',
            'terms' => 'nullable|string'
        ]);

        $manufacturer = auth()->user()->manufacturer;
        $validated['status'] = 'pending';

        BulkOrder::create($validated);

        return redirect()->route('manufacturer.inquiries.index')
            ->with('success', 'Bulk order created successfully');
    }

    public function bulkIndex()
    {
        $manufacturer = auth()->user()->manufacturer;

        $bulkOrders = BulkOrder::whereHas('inquiry.product', function ($query) use ($manufacturer) {
            $query->where('manufacturer_id', $manufacturer->id);
        })
            ->with(['inquiry.product', 'inquiry.user'])
            ->latest()
            ->paginate(15);

        return view('manufacturer.bulk-orders.index', compact('bulkOrders'));
    }

    public function bulkShow(BulkOrder $bulkOrder)
    {
        $bulkOrder->load(['inquiry.product', 'inquiry.user']);

        return view('manufacturer.bulk-orders.show', compact('bulkOrder'));
    }

    public function createResponse(UserInquiry $inquiry)
    {
        return view('manufacturer.inquiries.response', compact('inquiry'));
    }
}
