@echo off
REM System Verification Script for Windows
REM Run this to verify all fixes are applied correctly

echo ==========================================
echo System Verification Script
echo ==========================================
echo.

set ERRORS=0

REM Check 1: order_number column
echo 1. Checking order_number column...
php artisan tinker --execute="echo Schema::hasColumn('orders', 'order_number') ? 'YES' : 'NO';" 2>nul | findstr /C:"YES" >nul
if %errorlevel% equ 0 (
    echo    [OK] order_number column exists
) else (
    echo    [ERROR] order_number column MISSING!
    set /a ERRORS+=1
)

REM Check 2: status column
echo 2. Checking status column...
php artisan tinker --execute="echo Schema::hasColumn('orders', 'status') ? 'YES' : 'NO';" 2>nul | findstr /C:"YES" >nul
if %errorlevel% equ 0 (
    echo    [OK] status column exists
) else (
    echo    [ERROR] status column MISSING!
    set /a ERRORS+=1
)

REM Check 3: Storage symbolic link
echo 3. Checking storage symbolic link...
if exist "public\storage" (
    echo    [OK] Symbolic link exists
) else (
    echo    [ERROR] Symbolic link MISSING!
    echo    Run: php artisan storage:link
    set /a ERRORS+=1
)

REM Check 4: Storage directories
echo 4. Checking storage directories...
if exist "storage\app\public\dispatch_videos" (
    echo    [OK] dispatch_videos directory exists
) else (
    echo    [ERROR] dispatch_videos directory MISSING!
    set /a ERRORS+=1
)

if exist "storage\app\public\delivery-proofs" (
    echo    [OK] delivery-proofs directory exists
) else (
    echo    [ERROR] delivery-proofs directory MISSING!
    set /a ERRORS+=1
)

REM Check 5: Order statuses ENUM
echo 5. Checking order_statuses stage ENUM...
php artisan tinker --execute="echo DB::select('SHOW COLUMNS FROM order_statuses WHERE Field = ?', ['stage'])[0]->Type;" 2>nul | findstr /C:"salesman_review" >nul
if %errorlevel% equ 0 (
    echo    [OK] ENUM includes new stage names
) else (
    echo    [ERROR] ENUM does NOT include new stage names!
    echo    Run: php artisan migrate
    set /a ERRORS+=1
)

REM Check 6: Migrations
echo 6. Checking migrations...
php artisan migrate:status 2>nul | findstr /C:"Pending" >nul
if %errorlevel% neq 0 (
    echo    [OK] All migrations are up to date
) else (
    echo    [ERROR] Some migrations are pending!
    echo    Run: php artisan migrate
    set /a ERRORS+=1
)

REM Summary
echo.
echo ==========================================
echo Verification Summary
echo ==========================================
echo.

if %ERRORS% equ 0 (
    echo [OK] All checks passed! System is ready.
    echo.
    echo You can now:
    echo   - Place orders successfully
    echo   - Upload images and videos
    echo   - Use the complete 6-stage order lifecycle
    echo.
    exit /b 0
) else (
    echo [ERROR] %ERRORS% issue(s) found!
    echo.
    echo Please fix the issues above and run this script again.
    echo.
    exit /b 1
)
