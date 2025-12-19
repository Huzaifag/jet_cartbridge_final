# 🔐 Login Credentials for B2B/B2C E-commerce Platform

## 🎯 Quick Access Information

### Universal Password
**All users in the system use the same password:**
```
Password: password123
```

---

## 👤 Test Accounts

### Default Test User
```
Email: test@example.com
Password: password123
Role: Basic User
```

---

## 🏢 Business Accounts

### Sellers (20 Companies)
The system contains 20 randomly generated seller companies. Since these are generated with fake data, you'll need to check the database for exact email addresses.

**How to find seller emails:**
1. Go to your database
2. Check the `users` table
3. Look for users that have corresponding entries in the `sellers` table
4. All seller passwords are: `password123`

**Sample seller structure:**
- Company names like "Smith & Associates", "Johnson Corp", etc.
- Email addresses like "john.doe@example.com"
- Business types: Manufacturing, Wholesale, Retail, E-commerce, etc.

---

## 👥 Employee Accounts (All belong to Seller #4)

### Sales Team (5 employees)
- **Roles**: Sales Executive, Senior Sales Manager, Sales Representative, Account Manager
- **Password**: password123 (for all)
- **Access**: Sales dashboard, product management, customer management

### Delivery Team (5 employees)
- **Roles**: Delivery Driver, Courier, Logistics Coordinator, Delivery Supervisor
- **Password**: password123 (for all)
- **Access**: Delivery management, order tracking, route planning

### Accounting Team (5 employees)
- **Roles**: Junior Accountant, Senior Accountant, Finance Manager, Accounts Payable Clerk
- **Password**: password123 (for all)
- **Access**: Financial reports, invoice management, payment tracking

### Warehouse Team (5 employees)
- **Roles**: Warehouse Manager, Inventory Supervisor, Stock Controller, Warehouse Coordinator
- **Password**: password123 (for all)
- **Access**: Inventory management, stock control, warehouse operations

---

## 🔍 How to Get Exact Login Details

### Option 1: Database Query (Recommended)
Run this SQL query in your database:

```sql
SELECT 
    u.name as 'Full Name',
    u.email as 'Login Email',
    'password123' as 'Password',
    CASE 
        WHEN s.id IS NOT NULL THEN CONCAT('Seller - ', s.company_name)
        WHEN sm.id IS NOT NULL THEN CONCAT('Salesman - ', sm.designation)
        WHEN dm.id IS NOT NULL THEN CONCAT('Delivery - ', dm.designation)
        WHEN a.id IS NOT NULL THEN CONCAT('Accountant - ', a.designation)
        WHEN w.id IS NOT NULL THEN CONCAT('Warehouse - ', w.designation)
        ELSE 'Basic User'
    END as 'Role'
FROM users u
LEFT JOIN sellers s ON u.id = s.user_id
LEFT JOIN salesmen sm ON u.id = sm.user_id
LEFT JOIN delivery_men dm ON u.id = dm.user_id
LEFT JOIN accountants a ON u.id = a.user_id
LEFT JOIN warehouses w ON u.id = w.user_id
ORDER BY u.id;
```

### Option 2: Laravel Command
Run this in your terminal:

```bash
php artisan tinker
```

Then execute:
```php
// Get all users with their roles
$users = \App\Models\User::all();
foreach($users as $user) {
    $role = 'Basic User';
    if($user->seller) $role = 'Seller - ' . $user->seller->company_name;
    if($user->salesman) $role = 'Salesman - ' . $user->salesman->designation;
    if($user->deliveryMan) $role = 'Delivery - ' . $user->deliveryMan->designation;
    if($user->accountant) $role = 'Accountant - ' . $user->accountant->designation;
    if($user->warehouse) $role = 'Warehouse - ' . $user->warehouse->designation;
    
    echo "Name: {$user->name} | Email: {$user->email} | Role: {$role}\n";
}
```

---

## 🚀 Getting Started

### Step 1: Setup Database
```bash
php artisan migrate
php artisan db:seed
```

### Step 2: Start Testing
1. Use the test account: `test@example.com` / `password123`
2. Or pick any email from the database query above
3. All passwords are: `password123`

### Step 3: Explore Different Roles
- **Sellers**: Can manage products, view orders, manage employees
- **Salesmen**: Can handle sales, customer relations, product listings
- **Delivery**: Can manage deliveries, track orders, update delivery status
- **Accountants**: Can handle finances, invoices, payment tracking
- **Warehouse**: Can manage inventory, stock levels, warehouse operations

---

## ⚠️ Important Notes

### For Testing:
- All accounts are ready to use immediately
- No email verification required for seeded accounts
- Sample data is included (products, categories, etc.)

### For Production:
- **CRITICAL**: Change all passwords before going live
- Enable email verification
- Review user permissions and roles
- Implement proper security measures

---

## 📊 System Overview

- **Total Users**: ~41 accounts
- **Seller Companies**: 20 businesses
- **Employee Accounts**: 20 staff members
- **Product Categories**: 10 categories
- **Sample Products**: Multiple products per category

---

## 🆘 Need Help?

If you can't find the login credentials:

1. **Check Database**: Look in the `users` table for email addresses
2. **Use Test Account**: `test@example.com` / `password123` always works
3. **Run Seeders Again**: `php artisan db:seed --class=DatabaseSeeder`
4. **Contact Support**: Provide database access for specific credential extraction

---

*All credentials are for testing purposes only. Please secure the system before production use.*