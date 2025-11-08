# Storage Fix for Images and Videos - Complete Solution

## Problem Summary
Images and videos uploaded on the live server are not displaying, but work fine locally.

## Root Cause
Laravel stores files in `storage/app/public/` but serves them from `public/storage/`. The symbolic link connecting these directories is missing on the live server.

## Quick Fix (Run on Live Server)

### Option 1: Single Command
```bash
php artisan storage:link && chmod -R 775 storage && php artisan config:clear
```

### Option 2: Use Provided Scripts

**For Linux/Mac:**
```bash
chmod +x fix-storage-link.sh
./fix-storage-link.sh
```

**For Windows:**
```cmd
fix-storage-link.bat
```

### Option 3: Diagnose First
```bash
php artisan storage:diagnose
```
This will check your storage configuration and tell you exactly what's wrong.

## Files Affected

Your application uploads files to these locations:

1. **Dispatch Videos** (from Warehouse)
   - Storage: `storage/app/public/dispatch_videos/`
   - Public URL: `https://yourdomain.com/storage/dispatch_videos/filename.mp4`
   - Controller: `WarehouseOrdersController::dispatch()`

2. **Delivery Proofs** (from Deliveryman)
   - Storage: `storage/app/public/delivery-proofs/`
   - Public URL: `https://yourdomain.com/storage/delivery-proofs/filename.jpg`
   - Controller: `DeliveryManController::deliver()`

3. **Product Images**
   - Storage: `storage/app/public/` (or wherever products store images)
   - Public URL: `https://yourdomain.com/storage/filename.jpg`
   - Used in: Order views to display product thumbnails

## Manual Fix Steps

If the scripts don't work, follow these steps manually:

### Step 1: SSH into Your Live Server
```bash
ssh user@your-server.com
cd /path/to/your/laravel/app
```

### Step 2: Create Symbolic Link
```bash
php artisan storage:link
```

### Step 3: Set Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

If you have sudo access:
```bash
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
```

### Step 4: Create Upload Directories
```bash
mkdir -p storage/app/public/dispatch_videos
mkdir -p storage/app/public/delivery-proofs
chmod -R 775 storage/app/public
```

### Step 5: Clear Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Step 6: Verify .env
Make sure your `.env` file has the correct APP_URL:
```env
APP_URL=https://yourdomain.com
```

## Verification

### Check Symbolic Link
```bash
ls -la public/storage
```
Should show: `storage -> /path/to/storage/app/public`

### Test File Access
Try accessing a file directly:
```
https://yourdomain.com/storage/dispatch_videos/test.mp4
```

### Check Permissions
```bash
ls -la storage/app/public/
```
Should show `drwxrwxr-x` or similar (775 permissions)

## Troubleshooting

### Issue: "The link already exists"
```bash
rm public/storage
php artisan storage:link
```

### Issue: Permission Denied
```bash
sudo chown -R $USER:www-data storage
sudo chmod -R 775 storage
```

### Issue: Symbolic Links Not Supported (Shared Hosting)

If your hosting doesn't support symbolic links, you need to modify the upload code.

**Update WarehouseOrdersController.php:**
```php
// Find this line (around line 67):
$videoPath = $request->file('dispatch_video')->store('dispatch_videos', 'public');

// Replace with:
$video = $request->file('dispatch_video');
$videoName = time() . '_' . $video->getClientOriginalName();
$video->move(public_path('dispatch_videos'), $videoName);
$videoPath = 'dispatch_videos/' . $videoName;
```

**Update DeliveryManController.php:**
```php
// Find this line (around line 95):
$proofPath = $request->file('proof_of_delivery')->store('delivery-proofs', 'public');

// Replace with:
$proof = $request->file('proof_of_delivery');
$proofName = time() . '_' . $proof->getClientOriginalName();
$proof->move(public_path('delivery-proofs'), $proofName);
$proofPath = 'delivery-proofs/' . $proofName;
```

Then create the directories:
```bash
mkdir public/dispatch_videos
mkdir public/delivery-proofs
chmod 775 public/dispatch_videos
chmod 775 public/delivery-proofs
```

## Tools Provided

1. **fix-storage-link.sh** - Automated fix script for Linux/Mac
2. **fix-storage-link.bat** - Automated fix script for Windows
3. **DiagnoseStorage.php** - Artisan command to diagnose storage issues
4. **FIX_IMAGE_VIDEO_DISPLAY.md** - Detailed documentation

## Testing After Fix

1. **Upload Test**
   - Go to warehouse panel
   - Dispatch an order with a video
   - Check if video appears in order details

2. **Delivery Test**
   - Go to deliveryman panel
   - Mark order as delivered with proof image
   - Check if image displays

3. **Product Images Test**
   - View any order
   - Check if product thumbnails display

4. **Direct Access Test**
   - Try accessing: `https://yourdomain.com/storage/test.jpg`
   - Should not get 404 error

## Common Hosting Providers

### cPanel/Shared Hosting
- Use File Manager to create symbolic link
- Or use the "no symbolic link" solution above

### VPS/Dedicated Server
- Full SSH access - use the scripts provided
- Make sure to set correct permissions

### Laravel Forge/Vapor
- Symbolic link is usually created automatically
- Check deployment script

### Heroku
- Use S3 or cloud storage instead
- Heroku's filesystem is ephemeral

## Production Checklist

Before deploying to production:
- [ ] Run `php artisan storage:link`
- [ ] Set correct permissions (775 for directories)
- [ ] Verify APP_URL in .env
- [ ] Create upload directories
- [ ] Test file upload and display
- [ ] Check error logs
- [ ] Verify .htaccess allows storage access

## Need Help?

If you're still having issues:

1. Run the diagnostic command:
   ```bash
   php artisan storage:diagnose
   ```

2. Check Laravel logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. Check web server error logs:
   ```bash
   # Apache
   tail -f /var/log/apache2/error.log
   
   # Nginx
   tail -f /var/log/nginx/error.log
   ```

4. Verify file was actually uploaded:
   ```bash
   ls -la storage/app/public/dispatch_videos/
   ls -la storage/app/public/delivery-proofs/
   ```

---

**Status**: Complete solution provided with multiple fix options! 🎉
