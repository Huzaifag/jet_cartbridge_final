# 🔐 System User Credentials Document

## 📋 Overview
This document contains all user credentials for the B2B/B2C E-commerce Platform. All users have been created through database seeders with predefined credentials for testing and demonstration purposes.

---

## 🔑 Default Password
**All users in the system use the same password for testing purposes:**
```
Password: password123
```

---

## 👤 Test User (Default Laravel User)
| Field | Value |
|-------|-------|
| **Name** | Test User |
| **Email** | test@example.com |
| **Password** | password123 |
| **Role** | Basic User |
| **Created By** | DatabaseSeeder |

---

## 🏢 Sellers (20 Random Companies)
The system contains **20 randomly generated sellers** with associated user accounts. Each seller has:

### Seller Account Structure:
- **User Account**: For login and authentication
- **Seller Profile**: Company information and business details
- **Associated Employees**: Each seller can have multiple employees

### Sample Seller Credentials:
Since sellers are randomly generated using Faker, the exact credentials will vary each time the seeder runs. However, the structure is:

| Field | Format |
|-------|--------|
| **Name** | Random person name (e.g., "John Smith") |
| **Email** | Random email (e.g., "john.smith@example.com") |
| **Password** | password123 |
| **Company Name** | Random company name |
| **Business Type** | Manufacturing, Wholesale, Retail, E-commerce, Distribution, Import/Export, Technology, Services |
| **Status** | pending, approved, or rejected |

### To Find Seller Credentials:
1. Check the `users` table for seller user accounts
2. Match with `sellers` table using `user_id`
3. All sellers use password: `password123`

---

## 👥 Employees (20 Total - Associated with Seller ID 4)
All employees are associated with **Seller ID 4** and have the following structure:

### 🛍️ Salesmen (5 employees)
| Role | Count | Designations |
|------|-------|-------------|
| **Salesmen** | 5 | Sales Executive, Senior Sales Manager, Sales Representative, Account Manager |

### 🚚 Delivery Personnel (5 employees)
| Role | Count | Designations |
|------|-------|-------------|
| **Delivery Men** | 5 | Delivery Driver, Courier, Logistics Coordinator, Delivery Supervisor |

### 💰 Accountants (5 employees)
| Role | Count | Designations |
|------|-------|-------------|
| **Accountants** | 5 | Junior Accountant, Senior Accountant, Finance Manager, Accounts Payable Clerk |

### 📦 Warehouse Staff (5 employees)
| Role | Count | Designations |
|------|-------|-------------|
| **Warehouse Managers** | 5 | Warehouse Manager, Inventory Supervisor, Stock Controller, Warehouse Coordinator |

### Employee Credentials Structure:
| Field | Format |
|-------|--------|
| **Name** | Random person name |
| **Email** | Random email address |
| **Password** | password123 |
| **Phone** | Random phone number |
| **Salary** | Varies by role (25,000 - 80,000) |
| **Status** | active or inactive |
| **Seller ID** | 4 (all employees belong to seller #4) |

---

## 🏭 Manufacturers
**Note**: While the system supports manufacturers (as seen in the database structure), no ManufacturerSeeder was found. Manufacturers may need to be created manually or through a separate seeder.

---

## 📊 Database Tables for User Management

### Primary User Tables:
1. **`users`** - Main authentication table
2. **`sellers`** - Seller company information
3. **`salesmen`** - Sales employee details
4. **`delivery_men`** - Delivery personnel details
5. **`accountants`** - Accounting staff details
6. **`warehouses`** - Warehouse manager details
7. **`manufacturers`** - Manufacturer information (if created)

---

## 🔍 How to Access User Credentials

### Method 1: Database Query
```sql
-- Get all users with their roles
SELECT u.name, u.email, 'Seller' as role 
FROM users u 
INNER JOIN sellers s ON u.id = s.user_id

UNION ALL

SELECT u.name, u.email, 'Salesman' as role 
FROM users u 
INNER JOIN salesmen sm ON u.id = sm.user_id

UNION ALL

SELECT u.name, u.email, 'Delivery Man' as role 
FROM users u 
INNER JOIN delivery_men dm ON u.id = dm.user_id

UNION ALL

SELECT u.name, u.email, 'Accountant' as role 
FROM users u 
INNER JOIN accountants a ON u.id = a.user_id

UNION ALL

SELECT u.name, u.email, 'Warehouse Manager' as role 
FROM users u 
INNER JOIN warehouses w ON u.id = w.user_id;
```

### Method 2: Laravel Tinker
```php
// Get all sellers
$sellers = \App\Models\Seller::with('user')->get();
foreach($sellers as $seller) {
    echo "Email: " . $seller->user->email . " | Company: " . $seller->company_name . "\n";
}

// Get all employees for seller ID 4
$salesmen = \App\Models\Salesman::with('user')->where('seller_id', 4)->get();
$deliveryMen = \App\Models\DeliveryMan::with('user')->where('seller_id', 4)->get();
$accountants = \App\Models\Accountant::with('user')->where('seller_id', 4)->get();
$warehouses = \App\Models\WareHouse::with('user')->where('seller_id', 4)->get();
```

---

## 🚀 Quick Start Guide for Client

### 1. Run Database Seeders
```bash
php artisan db:seed
```

### 2. Login Options
- **Test User**: test@example.com / password123
- **Any Seller**: Check database for email / password123
- **Any Employee**: Check database for email / password123

### 3. Admin Access
If admin functionality exists, you may need to:
1. Create an admin user manually
2. Or check if there's a separate admin seeder
3. Or use the test user with elevated permissions

---

## ⚠️ Security Notes

### For Development/Testing:
- All passwords are set to `password123` for easy testing
- Email verification is randomly set (80% verified)
- User data is generated using Faker library

### For Production:
- **IMPORTANT**: Change all default passwords before going live
- Implement proper password policies
- Enable email verification for all users
- Review and update user permissions
- Consider implementing 2FA for sensitive roles

---

## 📞 Support Information

### Database Structure:
- **Total Users**: ~41 (1 test + 20 sellers + 20 employees)
- **Sellers**: 20 companies with random business data
- **Employees**: 20 total (5 each of 4 types)
- **Products**: Multiple products associated with sellers
- **Categories**: 10 product categories

### Contact for Issues:
- Check database directly for exact credentials
- All users use password: `password123`
- Employee emails are unique and randomly generated
- Seller emails are unique and randomly generated

---

*Document generated on: $(date)*
*System Version: Laravel B2B/B2C E-commerce Platform*