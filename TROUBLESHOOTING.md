# Troubleshooting Guide

## Common Issues and Solutions

### 1. Route [product.details] not defined
**Error:** `Route [product.details] not defined.`

**Solution:** ✅ FIXED
- The correct route name is `product.show`, not `product.details`
- Updated in `resources/views/frontend/pages/video-reviews.blade.php`

**Verify routes:**
```bash
php artisan route:list --name=product
php artisan route:list --name=video
```

---

### 2. Migration Errors

#### Error: "Column already exists"
**Example:** `SQLSTATE[42S21]: Column already exists: 1060 Duplicate column name 'promotion_id'`

**Solution:** ✅ FIXED
- Added column existence check in migration
- Updated `2025_10_07_175916_add_columns_to_lucky_draw_entries_table.php`

**Run migrations:**
```bash
php artisan migrate
```

#### Error: "Foreign key constraint is incorrectly formed"
**Example:** `Can't create table (errno: 150 "Foreign key constraint is incorrectly formed")`

**Possible causes:**
1. Referenced table doesn't exist yet
2. Column types don't match
3. Referenced column doesn't have an index

**Solution:**
- Ensure migrations run in correct order
- Check that foreign key references existing tables
- Verify column types match (both should be `bigint unsigned`)

---

### 3. Video Reviews Not Showing

**Issue:** Video reviews page is blank or shows "No video reviews yet"

**Checklist:**
1. ✅ Check if reviews table exists:
   ```bash
   php artisan migrate
   ```

2. ✅ Verify video reviews exist in database:
   - Reviews must have `review_type = 'video'`
   - Must have `media_urls` with video file path

3. ✅ Check video file paths:
   - Videos should be in `storage/app/public/reviews/`
   - Run: `php artisan storage:link`

4. ✅ Verify route is accessible:
   ```bash
   php artisan route:list --name=video.reviews
   ```

---

### 4. Videos Not Playing

**Issue:** Videos show but don't play

**Solutions:**

1. **Check video format:**
   - Supported: MP4, MOV, AVI
   - Recommended: MP4 with H.264 codec
   - Max size: 10MB

2. **Check file permissions:**
   ```bash
   chmod -R 755 storage/app/public/reviews
   ```

3. **Verify storage link:**
   ```bash
   php artisan storage:link
   ```

4. **Check browser console:**
   - Open Developer Tools (F12)
   - Look for errors in Console tab
   - Check Network tab for failed requests

---

### 5. Like/Comment Not Working

**Issue:** Clicking like or comment does nothing

**Solutions:**

1. **Check if user is logged in:**
   - Like and comment require authentication
   - Redirect to login if not authenticated

2. **Verify CSRF token:**
   - Check if `<meta name="csrf-token">` exists in layout
   - Should be in `<head>` section

3. **Check API routes:**
   ```bash
   php artisan route:list --name=review
   ```

4. **Check browser console for errors:**
   - 401 = Not authenticated
   - 403 = Not authorized
   - 422 = Validation error
   - 500 = Server error

---

### 6. Share Not Working

**Issue:** Share buttons don't work

**Solutions:**

1. **Check if share tracking route exists:**
   ```bash
   php artisan route:list --name=review.track-share
   ```

2. **Test share platforms:**
   - WhatsApp: Requires mobile or WhatsApp Web
   - Facebook: May be blocked by popup blockers
   - Twitter: Check if X.com is accessible
   - Copy Link: Check clipboard permissions

3. **Check browser console:**
   - Look for blocked popups
   - Check for CORS errors

---

### 7. Employee Activities Not Showing

**Issue:** Employee activities page is blank

**Solutions:**

1. **Run migration:**
   ```bash
   php artisan migrate
   ```

2. **Seed sample data (optional):**
   ```bash
   php artisan db:seed --class=EmployeeActivitySeeder
   ```

3. **Verify route:**
   ```bash
   php artisan route:list --name=employee-activities
   ```

4. **Check if seller has employees:**
   - Must have at least one employee (salesman, accountant, warehouse, or deliveryman)
   - Employees must be active (`status = 'active'`)

---

### 8. Database Connection Issues

**Issue:** `SQLSTATE[HY000] [2002] Connection refused`

**Solutions:**

1. **Check .env file:**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=jet_cartridge
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

2. **Start MySQL:**
   - Windows: Start MySQL service
   - Mac: `brew services start mysql`
   - Linux: `sudo service mysql start`

3. **Test connection:**
   ```bash
   php artisan tinker
   DB::connection()->getPdo();
   ```

---

### 9. Cache Issues

**Issue:** Changes not reflecting

**Solutions:**

1. **Clear all caches:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

2. **Restart server:**
   - If using `php artisan serve`, restart it
   - If using Apache/Nginx, restart the service

---

### 10. Permission Errors

**Issue:** `Permission denied` errors

**Solutions:**

1. **Fix storage permissions:**
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

2. **Fix ownership (Linux/Mac):**
   ```bash
   chown -R www-data:www-data storage
   chown -R www-data:www-data bootstrap/cache
   ```

---

## Quick Diagnostics

Run these commands to check system status:

```bash
# Check PHP version (requires 8.1+)
php -v

# Check Laravel version
php artisan --version

# Check database connection
php artisan migrate:status

# Check routes
php artisan route:list

# Check for errors
php artisan optimize:clear
```

---

## Getting Help

If issues persist:

1. **Check Laravel logs:**
   - `storage/logs/laravel.log`

2. **Enable debug mode:**
   - Set `APP_DEBUG=true` in `.env`
   - **Remember to disable in production!**

3. **Check browser console:**
   - Press F12
   - Look for JavaScript errors

4. **Check network requests:**
   - F12 → Network tab
   - Look for failed requests (red)

---

## Status Check

✅ **All Systems Operational:**
- Employee Activities: Working
- Video Reviews: Working
- Routes: Registered
- Migrations: Fixed
- Documentation: Complete

**Last Updated:** November 19, 2025
