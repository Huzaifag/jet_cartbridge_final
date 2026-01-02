# Video Playback Troubleshooting Guide

## Common Issues and Solutions

### 1. Videos Not Playing at All

**Possible Causes:**
- Incorrect video file paths
- Missing video files
- Browser autoplay restrictions
- Video format compatibility issues
- CORS (Cross-Origin Resource Sharing) issues

**Solutions:**

#### A. Check Video File Paths
```php
// In your controller, ensure video URLs are correct
$videoReviews = Review::with(['user', 'product'])
    ->whereNotNull('media_urls')
    ->where('media_urls', '!=', '[]')
    ->get()
    ->map(function($review) {
        // Ensure media_urls is properly decoded
        if (is_string($review->media_urls)) {
            $review->media_urls = json_decode($review->media_urls, true);
        }
        return $review;
    });
```

#### B. Verify Video Files Exist
```bash
# Check if video files exist in storage
ls -la storage/app/public/videos/
# or
ls -la public/storage/videos/
```

#### C. Create Storage Link (if not exists)
```bash
php artisan storage:link
```

### 2. Browser Autoplay Restrictions

**Modern browsers block autoplay without user interaction.**

**Solutions Implemented:**
- Videos are muted by default (required for autoplay)
- Added `playsinline` attribute for mobile
- Fallback to manual play on user interaction
- Clear play button when autoplay fails

### 3. Video Format Issues

**Ensure videos are in web-compatible formats:**
- **Recommended:** MP4 with H.264 codec
- **Alternative:** WebM, OGG

**Convert videos if needed:**
```bash
# Using FFmpeg to convert to web-compatible format
ffmpeg -i input.mov -c:v libx264 -c:a aac -movflags +faststart output.mp4
```

### 4. CORS Issues

**If videos are served from external domains:**

Add to your `.htaccess` or server config:
```apache
# Allow CORS for video files
<FilesMatch "\.(mp4|webm|ogg)$">
    Header set Access-Control-Allow-Origin "*"
    Header set Access-Control-Allow-Methods "GET, OPTIONS"
    Header set Access-Control-Allow-Headers "Content-Type"
</FilesMatch>
```

### 5. Mobile-Specific Issues

**iOS Safari and Chrome mobile have specific requirements:**

**Solutions Implemented:**
- Added `playsinline` attribute
- Proper touch event handling
- Optimized for mobile viewport

### 6. Network and Loading Issues

**For slow connections or large video files:**

**Optimizations:**
- Use `preload="metadata"` instead of `preload="auto"`
- Implement progressive loading
- Add retry functionality
- Show loading states

## Testing Video Playback

### 1. Browser Console Debugging

Open browser developer tools and check for:
```javascript
// Check if video element exists
console.log(document.querySelectorAll('.video-player'));

// Check video sources
document.querySelectorAll('.video-player').forEach(video => {
    console.log('Video src:', video.src);
    console.log('Video readyState:', video.readyState);
    console.log('Video networkState:', video.networkState);
});
```

### 2. Network Tab Analysis

1. Open Developer Tools → Network tab
2. Filter by "Media" or "All"
3. Reload the page
4. Check if video files are loading (status 200)
5. Look for 404 errors or failed requests

### 3. Manual Video Testing

Test individual video URLs directly:
```
https://yoursite.com/storage/videos/sample-video.mp4
```

## Enhanced Video Implementation

### Controller Updates

```php
// In your ReviewController or wherever you fetch video reviews
public function videoReviews()
{
    $videoReviews = Review::with(['user', 'product'])
        ->whereNotNull('media_urls')
        ->where('media_urls', '!=', '[]')
        ->get()
        ->filter(function($review) {
            // Ensure media_urls is an array and has valid entries
            $mediaUrls = is_string($review->media_urls) 
                ? json_decode($review->media_urls, true) 
                : $review->media_urls;
            
            return is_array($mediaUrls) && count($mediaUrls) > 0;
        })
        ->map(function($review) {
            // Normalize media URLs
            if (is_string($review->media_urls)) {
                $review->media_urls = json_decode($review->media_urls, true);
            }
            
            // Validate video file exists
            if (isset($review->media_urls[0])) {
                $videoPath = storage_path('app/public/' . $review->media_urls[0]);
                if (!file_exists($videoPath)) {
                    \Log::warning("Video file not found: " . $videoPath);
                }
            }
            
            return $review;
        });

    return view('frontend.pages.video-reviews', compact('videoReviews'));
}
```

### Database Schema Verification

Ensure your reviews table has the correct structure:
```sql
-- Check media_urls column
DESCRIBE reviews;

-- Sample data check
SELECT id, media_urls FROM reviews WHERE media_urls IS NOT NULL LIMIT 5;
```

### File Permissions

Ensure proper file permissions:
```bash
# Set correct permissions for storage
chmod -R 755 storage/
chmod -R 755 public/storage/

# For video files specifically
find storage/app/public/videos -type f -exec chmod 644 {} \;
```

## Performance Optimization

### 1. Video Compression
- Keep video files under 10MB for web
- Use appropriate resolution (720p for mobile, 1080p for desktop)
- Optimize bitrate for web delivery

### 2. CDN Integration
Consider using a CDN for video delivery:
```php
// Example with AWS CloudFront
$videoUrl = config('app.cdn_url') . '/' . $review->media_urls[0];
```

### 3. Lazy Loading
Implement lazy loading for videos not currently visible:
```javascript
// Only load videos when they come into viewport
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const video = entry.target.querySelector('video');
            if (video && !video.src) {
                video.load();
            }
        }
    });
});
```

## Debugging Checklist

- [ ] Video files exist in storage directory
- [ ] Storage link is created (`php artisan storage:link`)
- [ ] Video URLs are accessible directly in browser
- [ ] Browser console shows no JavaScript errors
- [ ] Network tab shows successful video loading (200 status)
- [ ] Video format is web-compatible (MP4/H.264)
- [ ] File permissions are correct (644 for files, 755 for directories)
- [ ] CORS headers are set if needed
- [ ] Videos are muted for autoplay compliance

## Browser-Specific Issues

### Chrome
- Requires user interaction for unmuted autoplay
- Works well with muted autoplay

### Safari (iOS)
- Requires `playsinline` attribute
- May need user interaction even for muted videos
- Check iOS version compatibility

### Firefox
- Generally good video support
- May have issues with some codecs

### Edge
- Similar to Chrome behavior
- Good HTML5 video support

If videos still don't play after following this guide, check the browser console for specific error messages and verify that your video files are in the correct format and location.