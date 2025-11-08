@echo off
REM Laravel Storage Link Fix Script for Windows
REM Run this on your Windows server to fix image/video display issues

echo ==========================================
echo Laravel Storage Link Fix
echo ==========================================
echo.

REM Step 1: Remove existing link if it exists
echo Step 1: Removing existing storage link (if any)...
if exist "public\storage" (
    rmdir "public\storage"
    echo [OK] Existing link removed
) else (
    echo [OK] No existing link found
)

REM Step 2: Create symbolic link
echo.
echo Step 2: Creating storage symbolic link...
php artisan storage:link
if %errorlevel% equ 0 (
    echo [OK] Storage link created successfully
) else (
    echo [ERROR] Failed to create storage link
    pause
    exit /b 1
)

REM Step 3: Create upload directories if they don't exist
echo.
echo Step 3: Creating upload directories...
if not exist "storage\app\public\dispatch_videos" mkdir "storage\app\public\dispatch_videos"
if not exist "storage\app\public\delivery-proofs" mkdir "storage\app\public\delivery-proofs"
echo [OK] Upload directories created

REM Step 4: Clear caches
echo.
echo Step 4: Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo [OK] Caches cleared

REM Step 5: Verify
echo.
echo ==========================================
echo Verification
echo ==========================================
echo.

if exist "public\storage" (
    echo [OK] Symbolic link exists: public\storage
) else (
    echo [ERROR] Symbolic link NOT found!
)

if exist "storage\app\public\dispatch_videos" (
    echo [OK] Dispatch videos directory exists
) else (
    echo [ERROR] Dispatch videos directory NOT found!
)

if exist "storage\app\public\delivery-proofs" (
    echo [OK] Delivery proofs directory exists
) else (
    echo [ERROR] Delivery proofs directory NOT found!
)

echo.
echo ==========================================
echo Setup Complete!
echo ==========================================
echo.
echo Next steps:
echo 1. Test uploading a file from your application
echo 2. Check if the file appears in storage\app\public\
echo 3. Try accessing it via: https://yourdomain.com/storage/filename
echo.
echo If issues persist, check:
echo - APP_URL in .env file
echo - IIS/Apache configuration
echo - File permissions
echo.
pause
