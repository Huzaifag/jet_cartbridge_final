# Quick Reference Card

## 🚀 Quick Start Commands

```bash
# Run migrations
php artisan migrate

# Seed sample data (optional)
php artisan db:seed --class=EmployeeActivitySeeder

# Check routes
php artisan route:list --name=video
php artisan route:list --name=employee-activities

# Clear cache
php artisan optimize:clear
```

---

## 🔗 URLs

### Employee Activities
```
/seller/employee-activities
```

### Video Reviews
```
/video-reviews                    # All videos
/video-reviews/{product-slug}     # Product-specific
```

---

## 📋 Route Names

### Employee Activities
```php
route('seller.employee-activities.index')
```

### Video Reviews
```php
route('video.reviews')                    // All videos
route('video.reviews', $productSlug)      // Product-specific
route('review.track-view', $reviewId)     // Track view
route('review.toggle-like', $reviewId)    // Like/unlike
route('review.get-comments', $reviewId)   // Get comments
route('review.post-comment', $reviewId)   // Post comment
route('review.track-share', $reviewId)    // Track share
```

---

## 🗄️ Database Tables

```
employee_activities
review_likes
review_comments
review_shares
```

---

## 📁 Key Files

### Employee Activities
```
app/Models/EmployeeActivity.php
app/Http/Controllers/Seller/EmployeeActivityController.php
app/Traits/LogsEmployeeActivity.php
resources/views/seller/employee-activities/index.blade.php
```

### Video Reviews
```
resources/views/frontend/pages/video-reviews.blade.php
app/Http/Controllers/ReviewController.php
app/Models/ReviewLike.php
app/Models/ReviewComment.php
app/Models/ReviewShare.php
```

---

## 🎯 Activity Types

```php
// Salesman
'lead_converted'
'lead_assigned'
'lead_updated'

// Accountant
'invoice_generated'
'payment_processed'

// Warehouse
'product_dispatched'

// Deliveryman
'delivery_completed'
```

---

## 💻 Code Snippets

### Log Activity (in Controller)
```php
use App\Traits\LogsEmployeeActivity;

class YourController extends Controller
{
    use LogsEmployeeActivity;
    
    public function yourMethod()
    {
        // Your code...
        
        $this->logActivity(
            'activity_type',
            'Description of activity',
            $referenceModel,  // optional
            ['key' => 'value'] // optional metadata
        );
    }
}
```

### Log Activity (Helper)
```php
use App\Helpers\ActivityLogger;

// For authenticated employee
ActivityLogger::logForAuth(
    'activity_type',
    'Description',
    $reference,
    $metadata
);

// For specific employee
ActivityLogger::log(
    $sellerId,
    'salesman',
    $employeeId,
    'activity_type',
    'Description',
    $reference,
    $metadata
);
```

### Get Video Reviews
```php
// In controller
$videoReviews = Review::with(['user', 'product'])
    ->where('review_type', 'video')
    ->whereNotNull('media_urls')
    ->orderBy('created_at', 'desc')
    ->get();
```

---

## 🔍 Troubleshooting

### Route not found
```bash
php artisan route:clear
php artisan route:cache
```

### Migration error
```bash
php artisan migrate:rollback
php artisan migrate
```

### Cache issues
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Permission errors
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 📊 Filter Options

### Employee Activities
- **Employee Type:** all, salesman, accountant, warehouse, deliveryman
- **Date Range:** today, yesterday, week, month, quarter, year
- **Activity Type:** order_created, invoice_generated, product_dispatched, etc.

---

## 🎨 CSS Classes

### Video Reviews
```css
.reels-container      /* Main container */
.reel-item           /* Individual video */
.reel-video          /* Video element */
.reel-overlay        /* Overlay controls */
.reel-actions        /* Action buttons */
.reel-action-btn     /* Individual action */
.reel-buy-btn        /* Buy button */
```

---

## 🔐 Permissions

### Employee Activities
- Requires: `auth` middleware
- Role: `seller`

### Video Reviews
- Public: View videos
- Authenticated: Like, comment, share
- Any role: Can interact

---

## 📱 API Endpoints

```
POST /api/reviews/{id}/view
POST /api/reviews/{id}/like
GET  /api/reviews/{id}/comments
POST /api/reviews/{id}/comments
POST /api/reviews/{id}/share
```

---

## 💰 Monetization

### Video Reviews
- Reviewer earns: **100 coins** per purchase
- Tracked via: Unique referral code
- Format: `RVW-U{userId}-{random}`

---

## 🎬 Video Specs

- **Format:** MP4, MOV, AVI
- **Max Size:** 10MB
- **Recommended:** 720p, 30fps, H.264
- **Aspect Ratio:** 9:16 (vertical)

---

## 📈 Analytics

### Employee Activities
```php
$stats = [
    'total_activities',
    'salesman_activities',
    'accountant_activities',
    'warehouse_activities',
    'deliveryman_activities'
];
```

### Video Reviews
```php
$metrics = [
    'video_views',
    'video_likes',
    'comments_count',
    'shares_count'
];
```

---

## 🔄 Status Codes

```
200 - Success
401 - Unauthorized (not logged in)
403 - Forbidden (wrong role)
404 - Not found
422 - Validation error
500 - Server error
```

---

## 📚 Documentation Files

1. `IMPLEMENTATION_SUMMARY.md` - Complete overview
2. `EMPLOYEE_ACTIVITIES_SETUP.md` - Employee activities guide
3. `VIDEO_REVIEWS_SETUP.md` - Video reviews guide
4. `TROUBLESHOOTING.md` - Common issues
5. `QUICK_REFERENCE.md` - This file

---

## ✅ Checklist

### Before Going Live
- [ ] Run all migrations
- [ ] Test all routes
- [ ] Verify file permissions
- [ ] Test video upload
- [ ] Test like/comment
- [ ] Test employee logging
- [ ] Clear all caches
- [ ] Set `APP_DEBUG=false`
- [ ] Backup database

---

## 🆘 Emergency Commands

```bash
# If everything breaks
php artisan down
php artisan optimize:clear
php artisan migrate:fresh --seed
php artisan storage:link
php artisan up

# Check logs
tail -f storage/logs/laravel.log
```

---

**Quick Help:** See `TROUBLESHOOTING.md` for detailed solutions
**Last Updated:** November 19, 2025
