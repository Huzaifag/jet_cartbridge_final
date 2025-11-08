# Fix Images and Videos Not Displaying on Live Server

## Problem
Images and videos uploaded on the live server are not displaying, even though they work fine locally.

## Root Cause
Laravel stores uploaded files in `storage/app/public/` but serves them from `public/storage/`. A symbolic link is required to connect these two directories. This link exists on your local machine but is missing on the live server.

## Solution Steps

### Step 1: Create Storage Symbolic Link on Live Server

Run this command on your live server:

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` → `storage/app/public`

**Expected Output:**
```
The [public/storage] link has been connected to [storage/app/public].
The links have been created.
```

### Step 2: Set Correct Permissions on Live Server

Ensure the storage directories have correct permissions:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

**Note:** Replace `www-data` with your web server user (might be `nginx`, `apache`, or your username on shared hosting)

### Step 3: Verify .env Configuration

Check your live server's `.env` file has the correct APP_URL:

```env
APP_URL=https://yourdomain.com
```

This is important because the file URLs are generated using this value.

### Step 4: Clear Configuration Cache

After making changes, clear the cache:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Verification

### Check if Symbolic Link Exists

On your live server, run:

```bash
ls -la public/storage
```

You should see something like:
```
lrwxrwxrwx 1 user user 35 Nov 9 12:00 storage -> /path/to/your/app/storage/app/public
```

The `->` indicates it's a symbolic link.

### Test File Access

Try accessing a file directly in your browser:
```
https://yourdomain.com/storage/dispatch_videos/filename.mp4
https://yourdomain.com/storage/delivery-proofs/filename.jpg
```

## Current File Upload Locations

Based on your code, files are stored in:

1. **Dispatch Videos**: `storage/app/public/dispatch_videos/`
   - Accessed via: `asset('storage/dispatch_videos/filename.mp4')`
   - Controller: `WarehouseOrdersController::dispatch()`

2. **Delivery Proofs**: `storage/app/public/delivery-proofs/`
   - Accessed via: `asset('storage/delivery-proofs/filename.jpg')`
   - Controller: `DeliveryManController::deliver()`

## Alternative Solution (If Symbolic Link Doesn't Work)

If your hosting provider doesn't support symbolic links, you have two options:

### Option A: Store Files Directly in Public Directory

Update the controllers to store files in `public/` instead of `storage/app/public/`:

**In WarehouseOrdersController.php:**
```php
// Change from:
$videoPath = $request->file('dispatch_video')->store('dispatch_videos', 'public');

// To:
$video = $request->file('dispatch_video');
$videoName = time() . '_' . $video->getClientOriginalName();
$video->move(public_path('dispatch_videos'), $videoName);
$videoPath = 'dispatch_videos/' . $videoName;
```

**In DeliveryManController.php:**
```php
// Change from:
$proofPath = $request->file('proof_of_delivery')->store('delivery-proofs', 'public');

// To:
$proof = $request->file('proof_of_delivery');
$proofName = time() . '_' . $proof->getClientOriginalName();
$proof->move(public_path('delivery-proofs'), $proofName);
$proofPath = 'delivery-proofs/' . $proofName;
```

Then in views, use:
```php
{{ asset($order->dispatch_video) }}
{{ asset($delivery->proof_of_delivery) }}
```

### Option B: Use Full URL in Database

Store the full URL instead of just the path:

```php
$videoPath = $request->file('dispatch_video')->store('dispatch_videos', 'public');
$validated['dispatch_video'] = asset('storage/' . $videoPath);
```

## Common Issues and Solutions

### Issue 1: "The link already exists"
If you get this error when running `storage:link`:

```bash
# Remove the existing link
rm public/storage

# Create it again
php artisan storage:link
```

### Issue 2: Permission Denied
If you get permission errors:

```bash
# Give ownership to web server user
sudo chown -R www-data:www-data storage
sudo chmod -R 775 storage
```

### Issue 3: 404 Not Found for Files
Check:
1. File actually exists in `storage/app/public/`
2. Symbolic link exists in `public/storage`
3. Web server has read permissions
4. .htaccess allows access to storage directory

### Issue 4: Shared Hosting Limitations
Some shared hosting providers don't allow symbolic links. In this case:
- Use Option A above (store directly in public)
- Or use cloud storage (S3, DigitalOcean Spaces, etc.)

## Production Deployment Checklist

When deploying to production, always:

- [ ] Run `php artisan storage:link`
- [ ] Set correct file permissions (775 for directories, 664 for files)
- [ ] Verify APP_URL in .env
- [ ] Clear all caches
- [ ] Test file upload and display
- [ ] Check error logs if issues persist

## Testing

After applying the fix, test:

1. **Upload a dispatch video** from warehouse panel
2. **View the order** and verify video plays
3. **Upload delivery proof** from deliveryman panel
4. **View the order** and verify image displays
5. **Check browser console** for any 404 errors

## Need More Help?

If images still don't display after following these steps:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check web server error logs
3. Verify file paths in database match actual file locations
4. Test with a simple test upload to isolate the issue

---

**Quick Fix Command (Run on Live Server):**
```bash
php artisan storage:link && chmod -R 775 storage && php artisan config:clear
```
