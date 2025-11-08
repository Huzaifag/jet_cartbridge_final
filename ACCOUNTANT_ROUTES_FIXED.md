# Accountant Routes - Fixed ✅

## Problem
Route `accountant.confirmed-orders.confirm` was not defined. The existing route had wrong method and name.

## Solution

### Before
```php
Route::put('/confirmed-orders/{id}/confirm', [AccountantOrderController::class, 'confirm'])
    ->name('confirmed-orders.invoincing');
```

**Issues:**
- Used PUT method (should be GET for viewing invoice page)
- Named `invoincing` (typo, should be `confirm`)

### After
```php
Route::get('/confirmed-orders/{id}/confirm', [AccountantOrderController::class, 'confirm'])
    ->name('confirmed-orders.confirm');
```

**Fixed:**
- ✅ Changed to GET method (for viewing invoice creation page)
- ✅ Renamed to `confirm` (matches the view usage)
- ✅ Matches controller method name

## Complete Accountant Routes

```php
Route::prefix('accountant')
    ->name('accountant.')
    ->middleware(['auth', 'role:accountant'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AccountantDashboardController::class, 'index'])
            ->name('dashboard.index');

        // Orders List
        Route::get('/confirmed-orders', [AccountantOrderController::class, 'index'])
            ->name('confirmed-orders.index');

        // View Order Details
        Route::get('/confirmed-orders/{id}', [AccountantOrderController::class, 'show'])
            ->name('confirmed-orders.show');

        // View Invoice Creation Page
        Route::get('/confirmed-orders/{id}/confirm', [AccountantOrderController::class, 'confirm'])
            ->name('confirmed-orders.confirm');

        // Save & Generate Invoice
        Route::post('/orders/{id}/invoice/save', [AccountantOrderController::class, 'saveInvoice'])
            ->name('orders.invoice.save');
    });
```

## Route Usage

### 1. List Orders (Accountant Dashboard)
```php
route('accountant.confirmed-orders.index')
// GET /accountant/confirmed-orders
```

### 2. View Order Details
```php
route('accountant.confirmed-orders.show', $orderId)
// GET /accountant/confirmed-orders/{id}
```

### 3. View Invoice Creation Page
```php
route('accountant.confirmed-orders.confirm', $orderId)
// GET /accountant/confirmed-orders/{id}/confirm
```

### 4. Save & Generate Invoice
```php
route('accountant.orders.invoice.save', $orderId)
// POST /accountant/orders/{id}/invoice/save
```

## Controller Methods

### AccountantOrderController

```php
// List orders in accountant_billing stage
public function index()

// Show order details
public function show(int $id)

// Show invoice creation page
public function confirm($id)

// Generate and save invoice
public function saveInvoice($id)
```

## Workflow

1. **Accountant Dashboard** → Lists orders in `accountant_billing` stage
2. **Click Order** → View order details (`show`)
3. **Click "Create Invoice"** → Go to invoice creation page (`confirm`)
4. **Click "Save & Generate Invoice"** → Generate PDF and move to next stage (`saveInvoice`)

## Files Modified

- `routes/web.php` - Fixed accountant route

---

**Status**: Accountant routes now correctly defined and working! ✅
