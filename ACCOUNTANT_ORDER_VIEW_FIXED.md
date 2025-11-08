# Accountant Order View - Fixed for 6-Stage Lifecycle ✅

## Problem
The accountant order view was checking for wrong status and showing incorrect buttons. It was checking `$order['status'] === 'Confirmed'` instead of checking the actual order stage.

## Solution Applied

### 1. Fixed Button Logic

**Before:**
```php
@if ($order['status'] === 'Confirmed')
    <button>Created invoice</button>
@endif
```

**After:**
```php
@php
    $accountantStage = collect($order['statuses'])->firstWhere('stage', 'accountant_billing');
    $canCreateInvoice = $accountantStage && $accountantStage['status'] === 'in_progress';
@endphp

@if ($canCreateInvoice)
    <a href="{{ route('accountant.confirmed-orders.confirm', $order['id']) }}">
        Create Invoice
    </a>
@elseif ($accountantStage && $accountantStage['status'] === 'completed')
    <span class="badge">Invoice Created</span>
    <a href="download-invoice">Download Invoice</a>
@endif
```

### 2. Updated Status Alert

**Now shows:**
- Current stage name (e.g., "Accountant Billing")
- Stage status badge (In Progress / Completed)
- Payment status
- Order number

**Stage-based color coding:**
- `order_placed` → Info (blue)
- `salesman_review` → Info (blue)
- `accountant_billing` → Warning (yellow)
- `warehouse_dispatch` → Primary (blue)
- `out_for_delivery` → Warning (yellow)
- `delivered` → Success (green)

### 3. Added Invoice Information Card

When invoice is created, shows:
- Invoice filename
- Invoice date
- Download button
- View button

### 4. Button States

#### When Order is in Accountant Billing Stage (in_progress)
```html
<a href="create-invoice" class="btn btn-success">
    <i class="fas fa-file-invoice"></i> Create Invoice
</a>
```

#### When Invoice is Already Created (completed)
```html
<span class="badge bg-success">
    <i class="fas fa-check-circle"></i> Invoice Created
</span>
<a href="download" class="btn btn-info">
    <i class="fas fa-download"></i> Download Invoice
</a>
```

#### When Order is Not in Accountant Stage
- No action buttons shown
- Only "Back to Orders" button visible

## Accountant Workflow

### Step 1: Order Arrives at Accountant
- Salesman has confirmed the order
- Order stage: `salesman_review` → `accountant_billing` (in_progress)
- Accountant sees "Create Invoice" button

### Step 2: Accountant Creates Invoice
- Clicks "Create Invoice" button
- Reviews order details
- Clicks "Save & Generate Invoice"
- System generates PDF invoice
- Saves invoice to `storage/app/public/invoices/`

### Step 3: Invoice Created
- Order stage: `accountant_billing` (completed)
- Order moves to: `warehouse_dispatch` (in_progress)
- Accountant sees "Invoice Created" badge
- Can download/view invoice

### Step 4: Order Moves to Warehouse
- Warehouse team takes over
- Accountant can still view order and download invoice
- No more actions needed from accountant

## Controller Logic (Already Correct)

The `AccountantOrderController` already has correct logic:

```php
public function index()
{
    // Get orders in accountant_billing stage
    $orders = Auth::user()
        ->accountant
        ->seller
        ->orders()
        ->whereHas('statuses', function($query) {
            $query->where('stage', 'accountant_billing')
                  ->where('status', 'in_progress');
        })
        ->paginate(10);
}

public function saveInvoice($id)
{
    // Validate stage
    $currentStatus = $order->statuses()
        ->where('stage', 'accountant_billing')
        ->first();
    
    if (!$currentStatus || $currentStatus->status !== 'in_progress') {
        return redirect()->back()
            ->with('error', 'Order is not in accountant billing stage.');
    }
    
    // Generate invoice
    // Mark accountant_billing as completed
    // Move to warehouse_dispatch
}
```

## Files Modified

- `resources/views/accountant/orders/show.blade.php`

## Testing Checklist

- [x] Button shows only when order is in `accountant_billing` stage
- [x] Button shows "Create Invoice" when stage is `in_progress`
- [x] Badge shows "Invoice Created" when stage is `completed`
- [x] Download button appears after invoice is created
- [x] Current stage displays correctly in alert
- [x] Invoice information card shows when invoice exists
- [x] Back button always visible
- [x] No errors when order is in other stages

## Stage Labels Used

```php
$stageLabels = [
    'order_placed' => 'Order Placed',
    'salesman_review' => 'Salesman Review',
    'accountant_billing' => 'Accountant Billing',
    'warehouse_dispatch' => 'Warehouse Dispatch',
    'out_for_delivery' => 'Out for Delivery',
    'delivered' => 'Delivered'
];
```

## Routes Used

- `accountant.confirmed-orders.index` - List orders
- `accountant.confirmed-orders.confirm` - Show invoice creation page
- `accountant.orders.invoice.save` - Save and generate invoice
- Download invoice: `asset('storage/invoices/' . $order['invoice'])`

## Database Fields

- `orders.invoice` - Invoice filename
- `orders.invoice_date` - When invoice was created
- `order_statuses.stage` - Current stage
- `order_statuses.status` - Stage status (pending/in_progress/completed)

## Visual Improvements

1. **Success Card** - Green border when invoice is created
2. **Stage Badge** - Shows if stage is in progress or completed
3. **Action Buttons** - Clear call-to-action based on stage
4. **Invoice Card** - Dedicated section for invoice information
5. **Download/View Buttons** - Easy access to invoice PDF

---

**Status**: Accountant order view now correctly shows buttons based on the 6-stage lifecycle! 🎉
