# Employee Activities Tracking System

## Overview
This feature allows sellers to track all activities performed by their employees (Salesman, Accountant, Warehouse Manager, and Delivery Man) in one centralized dashboard.

## Installation Steps

### 1. Run Migration
```bash
php artisan migrate
```

This will create the `employee_activities` table.

### 2. (Optional) Seed Sample Data
```bash
php artisan db:seed --class=EmployeeActivitySeeder
```

This will create sample activity records for testing.

## Features

### 1. Activity Tracking Dashboard
- **Location**: Seller Dashboard → Employee Activities
- **Route**: `/seller/employee-activities`
- **Features**:
  - View all employee activities in one place
  - Filter by employee type (Salesman, Accountant, Warehouse, Deliveryman)
  - Filter by specific employee
  - Filter by date range (Today, Yesterday, Week, Month, Quarter, Year)
  - Filter by activity type
  - Statistics cards showing activity counts
  - Employee performance summary

### 2. Automatic Activity Logging
Activities are automatically logged when employees perform actions:

#### Salesman Activities:
- `lead_converted` - When a lead is converted to customer
- `lead_assigned` - When a lead is assigned to another salesman
- `lead_updated` - When lead status is updated

#### Accountant Activities:
- `invoice_generated` - When an invoice is generated for an order
- `payment_processed` - When payment is processed

#### Warehouse Manager Activities:
- `product_dispatched` - When products are dispatched for delivery

#### Delivery Man Activities:
- `delivery_completed` - When an order is delivered to customer

### 3. Activity Types
The system tracks various activity types:
- `order_created`
- `invoice_generated`
- `product_dispatched`
- `delivery_completed`
- `lead_converted`
- `lead_assigned`
- `lead_updated`
- `payment_processed`

## Usage

### For Sellers
1. Navigate to **Employee Activities** from the sidebar
2. Use filters to view specific activities:
   - Select employee type
   - Choose specific employee
   - Set date range
   - Filter by activity type
3. View detailed activity log with timestamps
4. Check employee performance summary at the bottom

### For Developers - Adding Activity Logging

To log activities in your controllers:

1. **Add the trait to your controller:**
```php
use App\Traits\LogsEmployeeActivity;

class YourController extends Controller
{
    use LogsEmployeeActivity;
    
    // Your methods...
}
```

2. **Log an activity:**
```php
$this->logActivity(
    'activity_type',           // e.g., 'order_created'
    'Description of activity', // Human-readable description
    $referenceModel,          // Optional: Related model (Order, Lead, etc.)
    ['key' => 'value']        // Optional: Additional metadata
);
```

### Example Implementation:
```php
public function createOrder(Request $request)
{
    $order = Order::create($request->all());
    
    // Log the activity
    $this->logActivity(
        'order_created',
        "Created order #{$order->id}",
        $order,
        ['total_amount' => $order->total]
    );
    
    return redirect()->route('orders.show', $order);
}
```

## Database Schema

### employee_activities table:
- `id` - Primary key
- `seller_id` - Foreign key to sellers table
- `employee_type` - Type of employee (salesman, accountant, warehouse, deliveryman)
- `employee_id` - ID of the employee
- `activity_type` - Type of activity performed
- `description` - Human-readable description
- `reference_type` - Model class name (polymorphic)
- `reference_id` - Model ID (polymorphic)
- `metadata` - JSON field for additional data
- `created_at` - Timestamp
- `updated_at` - Timestamp

## Files Created/Modified

### New Files:
1. `app/Models/EmployeeActivity.php` - Model for employee activities
2. `app/Http/Controllers/Seller/EmployeeActivityController.php` - Controller
3. `app/Traits/LogsEmployeeActivity.php` - Trait for logging activities
4. `database/migrations/2025_11_19_000000_create_employee_activities_table.php` - Migration
5. `database/seeders/EmployeeActivitySeeder.php` - Seeder
6. `resources/views/seller/employee-activities/index.blade.php` - View

### Modified Files:
1. `routes/web.php` - Added route for employee activities
2. `resources/views/seller/component/sidebar.blade.php` - Added navigation link
3. `app/Http/Controllers/Deliveryman/DeliverymanController.php` - Added activity logging
4. `app/Http/Controllers/Salesman/LeadController.php` - Added activity logging
5. `app/Http/Controllers/Warehouse/WarehouseOrdersController.php` - Added activity logging
6. `app/Http/Controllers/Accountant/AccountantOrderController.php` - Added activity logging

## Benefits

1. **Complete Visibility**: Sellers can see all employee activities in one place
2. **Performance Tracking**: Monitor employee productivity and activity levels
3. **Accountability**: Track who did what and when
4. **Audit Trail**: Maintain a complete history of all actions
5. **Easy Filtering**: Quickly find specific activities or employee actions
6. **Real-time Updates**: Activities are logged as they happen

## Future Enhancements

Potential improvements:
- Export activities to CSV/PDF
- Activity notifications
- Performance analytics and reports
- Activity comparison between employees
- Time-based productivity charts
- Activity goals and targets
