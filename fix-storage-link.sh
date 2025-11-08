#!/bin/bash

# Laravel Storage Link Fix Script
# Run this on your live server to fix image/video display issues

echo "=========================================="
echo "Laravel Storage Link Fix"
echo "=========================================="
echo ""

# Step 1: Remove existing link if it exists
echo "Step 1: Removing existing storage link (if any)..."
if [ -L "public/storage" ]; then
    rm public/storage
    echo "✓ Existing link removed"
else
    echo "✓ No existing link found"
fi

# Step 2: Create symbolic link
echo ""
echo "Step 2: Creating storage symbolic link..."
php artisan storage:link
if [ $? -eq 0 ]; then
    echo "✓ Storage link created successfully"
else
    echo "✗ Failed to create storage link"
    exit 1
fi

# Step 3: Set permissions
echo ""
echo "Step 3: Setting correct permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
echo "✓ Permissions set"

# Step 4: Create upload directories if they don't exist
echo ""
echo "Step 4: Creating upload directories..."
mkdir -p storage/app/public/dispatch_videos
mkdir -p storage/app/public/delivery-proofs
chmod -R 775 storage/app/public
echo "✓ Upload directories created"

# Step 5: Clear caches
echo ""
echo "Step 5: Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo "✓ Caches cleared"

# Step 6: Verify
echo ""
echo "=========================================="
echo "Verification"
echo "=========================================="
echo ""

if [ -L "public/storage" ]; then
    echo "✓ Symbolic link exists: public/storage -> $(readlink public/storage)"
else
    echo "✗ Symbolic link NOT found!"
fi

if [ -d "storage/app/public/dispatch_videos" ]; then
    echo "✓ Dispatch videos directory exists"
else
    echo "✗ Dispatch videos directory NOT found!"
fi

if [ -d "storage/app/public/delivery-proofs" ]; then
    echo "✓ Delivery proofs directory exists"
else
    echo "✗ Delivery proofs directory NOT found!"
fi

echo ""
echo "=========================================="
echo "Setup Complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Test uploading a file from your application"
echo "2. Check if the file appears in storage/app/public/"
echo "3. Try accessing it via: https://yourdomain.com/storage/filename"
echo ""
echo "If issues persist, check:"
echo "- APP_URL in .env file"
echo "- Web server user permissions"
echo "- .htaccess configuration"
echo ""
