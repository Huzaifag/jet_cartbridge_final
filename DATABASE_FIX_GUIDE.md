# Database Fix Guide - Product Ownership Issue

## Problem
The application is encountering a database error: `Column not found: 1054 Unknown column 'owner_type' in 'WHERE'`. This occurs because the Product model expects polymorphic relationship columns (`owner_type` and `owner_id`) that don't exist in the current database schema.

## Root Cause
The Product model has been designed to use polymorphic relationships to support multiple owner types (Seller, Manufacturer, Salesman), but the database migration to add these columns hasn't been run yet.

## Solution

### Step 1: Run the Migration
Execute the following command to add the missing columns:

```bash
php artisan migrate --path=database/migrations/2025_01_01_000001_add_polymorphic_owner_to_products_table.php
```

If you prefer to run all pending migrations:
```bash
php artisan migrate
```

### Step 2: Migrate Existing Data
After the migration, run the custom command to populate the new polymorphic columns:

```bash
php artisan products:migrate-ownership
```

### Step 3: Verify the Fix
Check that the columns were added successfully:

```sql
DESCRIBE products;
```

You should see `owner_type` and `owner_id` columns in the products table.

## What the Migration Does

1. **Adds Polymorphic Columns**: 
   - `owner_type` (string, nullable) - stores the model class name
   - `owner_id` (unsigned big integer, nullable) - stores the model ID

2. **Creates Database Index**: 
   - Adds a composite index on `(owner_type, owner_id)` for better query performance

3. **Migrates Existing Data**:
   - Products with `seller_id` → `owner_type = 'App\Models\Seller'`, `owner_id = seller_id`
   - Products with `manufacturer_id` → `owner_type = 'App\Models\Manufacturer'`, `owner_id = manufacturer_id`

## Backward Compatibility

The Product model has been updated to handle both scenarios:

- **With Polymorphic Columns**: Uses the new `owner_type`/`owner_id` system
- **Without Polymorphic Columns**: Falls back to legacy `seller_id`/`manufacturer_id` columns

This ensures the application continues to work even if the migration hasn't been run yet.

## Files Created/Modified

### New Files:
1. `database/migrations/2025_01_01_000001_add_polymorphic_owner_to_products_table.php` - Migration file
2. `app/Console/Commands/MigrateProductOwnership.php` - Data migration command

### Modified Files:
1. `app/Models/Product.php` - Added backward compatibility methods

## Testing the Fix

After running the migration and data migration:

1. **Check Database Structure**:
   ```sql
   SHOW COLUMNS FROM products LIKE 'owner_%';
   ```

2. **Verify Data Migration**:
   ```sql
   SELECT COUNT(*) FROM products WHERE owner_type IS NOT NULL;
   SELECT COUNT(*) FROM products WHERE owner_type IS NULL;
   ```

3. **Test Application**:
   - Navigate to manufacturer dashboard
   - Check that products are displayed correctly
   - Verify no database errors occur

## Alternative Quick Fix (Temporary)

If you cannot run migrations immediately, you can temporarily modify the Product model to use only legacy columns by commenting out the polymorphic relationship methods. However, this is not recommended for production use.

## Prevention

To prevent similar issues in the future:

1. Always run `php artisan migrate` after pulling new code
2. Check for new migration files in `database/migrations/`
3. Test database-dependent features after schema changes
4. Use database seeders to populate test data consistently

## Support

If you encounter issues with this fix:

1. Check database connection settings in `.env`
2. Ensure database user has proper permissions
3. Verify that the products table exists
4. Check Laravel logs for detailed error messages

The migration is designed to be safe and reversible. If needed, you can rollback using:

```bash
php artisan migrate:rollback --step=1
```