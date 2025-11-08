#!/bin/bash

# System Verification Script
# Run this to verify all fixes are applied correctly

echo "=========================================="
echo "System Verification Script"
echo "=========================================="
echo ""

ERRORS=0

# Check 1: order_number column
echo "1. Checking order_number column..."
RESULT=$(php artisan tinker --execute="echo Schema::hasColumn('orders', 'order_number') ? 'YES' : 'NO';" 2>/dev/null | grep -o "YES\|NO")
if [ "$RESULT" = "YES" ]; then
    echo "   ✓ order_number column exists"
else
    echo "   ✗ order_number column MISSING!"
    ERRORS=$((ERRORS + 1))
fi

# Check 2: status column
echo "2. Checking status column..."
RESULT=$(php artisan tinker --execute="echo Schema::hasColumn('orders', 'status') ? 'YES' : 'NO';" 2>/dev/null | grep -o "YES\|NO")
if [ "$RESULT" = "YES" ]; then
    echo "   ✓ status column exists"
else
    echo "   ✗ status column MISSING!"
    ERRORS=$((ERRORS + 1))
fi

# Check 3: Storage symbolic link
echo "3. Checking storage symbolic link..."
if [ -L "public/storage" ]; then
    echo "   ✓ Symbolic link exists"
    echo "   → $(readlink public/storage)"
else
    echo "   ✗ Symbolic link MISSING!"
    echo "   Run: php artisan storage:link"
    ERRORS=$((ERRORS + 1))
fi

# Check 4: Storage directories
echo "4. Checking storage directories..."
if [ -d "storage/app/public/dispatch_videos" ]; then
    echo "   ✓ dispatch_videos directory exists"
else
    echo "   ✗ dispatch_videos directory MISSING!"
    ERRORS=$((ERRORS + 1))
fi

if [ -d "storage/app/public/delivery-proofs" ]; then
    echo "   ✓ delivery-proofs directory exists"
else
    echo "   ✗ delivery-proofs directory MISSING!"
    ERRORS=$((ERRORS + 1))
fi

# Check 5: Storage permissions
echo "5. Checking storage permissions..."
if [ -w "storage/app/public" ]; then
    echo "   ✓ storage/app/public is writable"
else
    echo "   ✗ storage/app/public is NOT writable!"
    echo "   Run: chmod -R 775 storage"
    ERRORS=$((ERRORS + 1))
fi

# Check 6: Order statuses ENUM
echo "6. Checking order_statuses stage ENUM..."
ENUM=$(php artisan tinker --execute="echo DB::select('SHOW COLUMNS FROM order_statuses WHERE Field = ?', ['stage'])[0]->Type;" 2>/dev/null | grep -o "salesman_review")
if [ ! -z "$ENUM" ]; then
    echo "   ✓ ENUM includes new stage names"
else
    echo "   ✗ ENUM does NOT include new stage names!"
    echo "   Run: php artisan migrate"
    ERRORS=$((ERRORS + 1))
fi

# Check 7: Migrations
echo "7. Checking migrations..."
PENDING=$(php artisan migrate:status 2>/dev/null | grep -c "Pending")
if [ "$PENDING" -eq 0 ]; then
    echo "   ✓ All migrations are up to date"
else
    echo "   ✗ $PENDING migration(s) pending!"
    echo "   Run: php artisan migrate"
    ERRORS=$((ERRORS + 1))
fi

# Summary
echo ""
echo "=========================================="
echo "Verification Summary"
echo "=========================================="
echo ""

if [ $ERRORS -eq 0 ]; then
    echo "✓ All checks passed! System is ready."
    echo ""
    echo "You can now:"
    echo "  - Place orders successfully"
    echo "  - Upload images and videos"
    echo "  - Use the complete 6-stage order lifecycle"
    echo ""
    exit 0
else
    echo "✗ $ERRORS issue(s) found!"
    echo ""
    echo "Please fix the issues above and run this script again."
    echo ""
    exit 1
fi
