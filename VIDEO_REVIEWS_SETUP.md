# Instagram Reels/YouTube Shorts Style Video Reviews

## Overview
A complete video review feature that mimics Instagram Reels and YouTube Shorts, allowing users to watch, like, comment, share, and buy products directly from video reviews.

## Features

### 1. **Reels-Style Video Player**
- Full-screen vertical video playback
- Swipe/scroll navigation between videos
- Auto-play on scroll
- Tap to play/pause
- Smooth transitions

### 2. **Interactive Actions**
- **Like**: Double-tap or click heart icon
- **Comment**: View and post comments
- **Share**: Share via WhatsApp, Facebook, Twitter, or copy link
- **Buy**: Direct purchase through referral link (earns reviewer 100 coins)

### 3. **Social Features**
- User profiles with avatars
- Follow button
- Product tagging
- View counter
- Like counter
- Comment system

### 4. **Monetization**
- Reviewers earn 100 coins when someone buys through their video
- Unique referral codes for each review
- Purchase tracking

## Installation Steps

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will create:
- `review_likes` table
- `review_comments` table
- `review_shares` table

### Step 2: Verify Routes
Routes are already added:
- `GET /video-reviews/{slug?}` - View video reviews
- `POST /api/reviews/{review}/view` - Track views
- `POST /api/reviews/{review}/like` - Toggle like
- `GET /api/reviews/{review}/comments` - Get comments
- `POST /api/reviews/{review}/comments` - Post comment
- `POST /api/reviews/{review}/share` - Track shares

### Step 3: Access the Feature

#### From Product Details Page:
1. Go to any product details page
2. Click on "Video Reviews" tab
3. Click "Watch as Reels" button
4. Enjoy the full-screen experience!

#### Direct URL:
- All video reviews: `/video-reviews`
- Product-specific: `/video-reviews/{product-slug}`

## Usage Guide

### For Customers:

**Watching Videos:**
1. Scroll up/down to navigate between videos
2. Tap video to play/pause
3. Sound is automatically enabled after first video

**Interacting:**
- **Like**: Click the heart icon (must be logged in)
- **Comment**: Click comment icon, type, and post
- **Share**: Click share icon, choose platform
- **Buy**: Click "Buy Now" button to purchase with reviewer's referral

**Following Reviewers:**
- Click "Follow" button on any video to follow the reviewer

### For Reviewers:

**Creating Video Reviews:**
1. Go to product details page
2. Click "Write a Review"
3. Select "Video Review"
4. Upload your video (max 10MB, MP4/MOV/AVI)
5. Add description
6. Submit

**Earning Coins:**
- You earn 100 coins when someone buys through your video
- Your unique referral code is automatically generated
- Track your earnings in your profile

## Technical Details

### Files Created:

**Views:**
- `resources/views/frontend/pages/video-reviews.blade.php` - Main reels interface

**Controllers:**
- Updated `app/Http/Controllers/ReviewController.php` with:
  - `videoReels()` - Display video reviews
  - `trackView()` - Track video views
  - `toggleLike()` - Like/unlike videos
  - `getComments()` - Fetch comments
  - `postComment()` - Post comments
  - `trackShare()` - Track shares

**Models:**
- `app/Models/ReviewLike.php` - Like tracking
- `app/Models/ReviewComment.php` - Comments
- `app/Models/ReviewShare.php` - Share tracking

**Migrations:**
- `database/migrations/2025_11_19_100000_create_review_interactions_tables.php`

**Routes:**
- Added in `routes/web.php`

### Database Schema:

**review_likes:**
- `id` - Primary key
- `review_id` - Foreign key to reviews
- `user_id` - Foreign key to users
- `created_at`, `updated_at`
- Unique constraint on (review_id, user_id)

**review_comments:**
- `id` - Primary key
- `review_id` - Foreign key to reviews
- `user_id` - Foreign key to users
- `comment` - Text
- `created_at`, `updated_at`

**review_shares:**
- `id` - Primary key
- `review_id` - Foreign key to reviews
- `user_id` - Foreign key to users (nullable)
- `platform` - String (whatsapp, facebook, twitter, copy)
- `created_at`, `updated_at`

## Features Breakdown

### Video Player Features:
✅ Full-screen vertical layout
✅ Smooth scroll navigation
✅ Auto-play on scroll
✅ Tap to play/pause
✅ Loading spinner
✅ Play/pause indicator
✅ Mute/unmute control

### Social Features:
✅ Like button with animation
✅ Comment system with modal
✅ Share to multiple platforms
✅ Follow button
✅ User avatars
✅ View counter
✅ Like counter

### E-commerce Features:
✅ Product tagging
✅ Direct buy button
✅ Referral tracking
✅ Coin rewards for reviewers
✅ Purchase attribution

### UI/UX Features:
✅ Instagram Reels-style interface
✅ Gradient overlays
✅ Smooth animations
✅ Responsive design
✅ Touch-friendly controls
✅ Loading states
✅ Error handling

## Customization

### Styling:
All styles are in the view file. You can customize:
- Colors (gradients, backgrounds)
- Button styles
- Animation speeds
- Layout dimensions

### Behavior:
Modify JavaScript functions:
- `playVideo()` - Video playback logic
- `toggleLike()` - Like behavior
- `shareVia()` - Share platforms
- Scroll detection sensitivity

### Monetization:
Change coin rewards in:
- `ReviewController@orderWithFer()`
- Update the alert message in the view

## API Endpoints

### Track View
```
POST /api/reviews/{review}/view
Response: { success: true, views: 123 }
```

### Toggle Like
```
POST /api/reviews/{review}/like
Response: { success: true, liked: true, likes: 45 }
```

### Get Comments
```
GET /api/reviews/{review}/comments
Response: { comments: [...] }
```

### Post Comment
```
POST /api/reviews/{review}/comments
Body: { text: "Great product!" }
Response: { success: true, comment: {...} }
```

### Track Share
```
POST /api/reviews/{review}/share
Body: { platform: "whatsapp" }
Response: { success: true }
```

## Browser Compatibility

✅ Chrome/Edge (latest)
✅ Firefox (latest)
✅ Safari (iOS 12+)
✅ Mobile browsers

## Performance Tips

1. **Video Optimization:**
   - Compress videos before upload
   - Use H.264 codec
   - Recommended: 720p, 30fps
   - Max file size: 10MB

2. **Loading:**
   - Videos load on demand
   - Only current video plays
   - Preload next video for smooth scrolling

3. **Caching:**
   - Browser caches viewed videos
   - API responses cached where appropriate

## Future Enhancements

Potential additions:
- Video filters and effects
- Duet/stitch features
- Trending videos section
- Hashtag system
- Video analytics dashboard
- Live streaming
- Stories feature
- Video editing tools
- AR filters
- Music library

## Troubleshooting

**Videos not playing:**
- Check video format (MP4 recommended)
- Verify file size < 10MB
- Check browser console for errors

**Likes not working:**
- Ensure user is logged in
- Check CSRF token
- Verify database connection

**Comments not loading:**
- Check API endpoint
- Verify user authentication
- Check network tab for errors

## Support

For issues or questions:
1. Check browser console for errors
2. Verify all migrations ran successfully
3. Check file permissions for uploads
4. Review server logs

## Credits

Inspired by:
- Instagram Reels
- YouTube Shorts
- TikTok

Built with:
- Laravel
- Vanilla JavaScript
- CSS3 Animations
- HTML5 Video API
