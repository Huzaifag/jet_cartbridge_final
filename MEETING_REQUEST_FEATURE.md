# Meeting Request Feature

## Overview
Customers can now request meetings with sellers and manufacturers by selecting date, time, and meeting details - just like sellers do.

## Features

### 🎯 Meeting Request Modal:
1. **Meeting Details Form:**
   - Title (required)
   - Description (required)
   - Date (required, must be today or future)
   - Time (required)
   - Duration (30min, 1hr, 1.5hr, 2hr)
   - Meeting Type (Video, Audio, In-Person)

2. **Visual Information:**
   - Shows seller/manufacturer avatar
   - Displays company name
   - Purple gradient header
   - Clean, modern design

3. **Smart Defaults:**
   - Date: Tomorrow
   - Time: 10:00 AM
   - Duration: 1 hour
   - Type: Video Call

## 🎨 User Flow

### Requesting a Meeting:
```
1. Click support button
2. Browse sellers/manufacturers
3. Click calendar icon
4. Modal opens with form
5. Fill in meeting details:
   - Title
   - Description
   - Date & Time
   - Duration
   - Meeting Type
6. Click "Send Request"
7. Success message shown
8. Modal closes
```

### What Happens:
1. ✅ Meeting record created in database
2. ✅ Status set to 'pending'
3. ✅ Seller/manufacturer receives notification
4. ✅ They can accept/reject the meeting
5. ✅ Customer gets confirmation

## 📋 Form Fields

### Required Fields:
- **Title:** Meeting subject (max 255 chars)
- **Description:** What to discuss (max 1000 chars)
- **Date:** Meeting date (today or future)
- **Time:** Meeting time (HH:MM format)

### Optional Fields:
- **Duration:** 30, 60, 90, or 120 minutes (default: 60)
- **Meeting Type:** video, audio, or in-person (default: video)

## 🔧 Technical Implementation

### Files Modified:
1. **Component:** `resources/views/components/customer-support-popup.blade.php`
   - Added meeting modal HTML
   - Added modal styles
   - Added JavaScript functions

2. **Controller:** `app/Http/Controllers/Api/SupportController.php`
   - Updated `requestMeeting()` method
   - Added validation for all fields
   - Stores complete meeting details

### API Endpoint:
```
POST /api/meetings/request
```

### Request Body:
```json
{
  "type": "seller",
  "id": 1,
  "title": "Product Discussion",
  "description": "I would like to discuss bulk order pricing",
  "date": "2025-11-20",
  "time": "14:00",
  "duration": 60,
  "meeting_type": "video"
}
```

### Response:
```json
{
  "success": true,
  "meeting_id": 123,
  "message": "Meeting request sent successfully"
}
```

## 🎨 Modal Design

### Layout:
```
┌─────────────────────────────────┐
│  📅 Request Meeting        [X]  │ ← Purple gradient header
├─────────────────────────────────┤
│                                 │
│  Meeting With:                  │
│  ┌───────────────────────────┐ │
│  │ [Avatar] Company Name     │ │
│  └───────────────────────────┘ │
│                                 │
│  📝 Meeting Title               │
│  [Input field]                  │
│                                 │
│  📄 Description                 │
│  [Textarea]                     │
│                                 │
│  📅 Date        🕐 Time         │
│  [Date input]   [Time input]    │
│                                 │
│  ⏱️ Duration                    │
│  [Select: 30min, 1hr, etc.]     │
│                                 │
│  📹 Meeting Type                │
│  [Select: Video, Audio, etc.]   │
│                                 │
│  ℹ️ Info message                │
│                                 │
│  [Send Request Button]          │
│  [Cancel Button]                │
└─────────────────────────────────┘
```

### Colors:
- **Header:** Purple gradient (#667eea → #764ba2)
- **Avatar:** Same gradient
- **Buttons:** Primary blue
- **Focus:** Purple border
- **Background:** White

### Animations:
- **Modal entrance:** Scale + fade (0.3s)
- **Button loading:** Spinner animation
- **Hover effects:** Smooth transitions

## 📊 Database Schema

### meetings table:
```sql
- id
- sender_id (customer)
- receiver_id (seller/manufacturer)
- title
- description
- status (pending/accepted/rejected)
- meeting_date
- meeting_time
- duration (minutes)
- meeting_type (video/audio/in-person)
- created_at
- updated_at
```

## ✅ Validation Rules

### Backend Validation:
```php
'type' => 'required|in:seller,manufacturer'
'id' => 'required|integer'
'title' => 'required|string|max:255'
'description' => 'required|string|max:1000'
'date' => 'required|date|after_or_equal:today'
'time' => 'required'
'duration' => 'nullable|integer|in:30,60,90,120'
'meeting_type' => 'nullable|in:video,audio,in-person'
```

### Frontend Validation:
- All required fields must be filled
- Date cannot be in the past
- Time must be valid format
- Form disables during submission

## 🔄 JavaScript Functions

### Main Functions:
```javascript
requestMeeting(type, id)        // Opens modal with data
openMeetingModal(type, id, data) // Shows modal
closeMeetingModal()             // Hides modal
form.submit()                   // Sends request
```

### Features:
- ✅ Auto-fills seller/manufacturer info
- ✅ Sets default date/time
- ✅ Shows loading state
- ✅ Handles errors
- ✅ Resets form on close
- ✅ Disables button during submission

## 📱 Responsive Design

### Desktop:
- Modal: 500px width
- Centered on screen
- Rounded corners
- Shadow overlay

### Mobile:
- Modal: Full width
- Rounded top corners
- Scrollable content
- Touch-friendly inputs

## 🎯 User Experience

### Before (Old Way):
- ❌ Click meeting button
- ❌ Generic request sent
- ❌ No details provided
- ❌ Fixed date/time
- ❌ No customization

### After (New Way):
- ✅ Click meeting button
- ✅ Modal opens
- ✅ Fill in details
- ✅ Choose date/time
- ✅ Select meeting type
- ✅ Add description
- ✅ Send custom request

## 🚀 Benefits

### For Customers:
- ✅ Choose convenient time
- ✅ Explain meeting purpose
- ✅ Select meeting type
- ✅ Professional appearance
- ✅ Better communication

### For Sellers/Manufacturers:
- ✅ Know meeting purpose
- ✅ See requested time
- ✅ Understand customer needs
- ✅ Can accept/reject
- ✅ Better preparation

## 🧪 Testing

### Test Meeting Request:
1. Open support popup
2. Click calendar icon on any seller
3. Fill in form:
   - Title: "Product Demo"
   - Description: "Want to see product features"
   - Date: Tomorrow
   - Time: 2:00 PM
   - Duration: 1 hour
   - Type: Video
4. Click "Send Request"
5. Check success message
6. Verify in database

### Verify Database:
```sql
SELECT * FROM meetings 
WHERE sender_id = [customer_id] 
AND receiver_id = [seller_user_id]
ORDER BY created_at DESC 
LIMIT 1;
```

## 🔍 Error Handling

### Validation Errors:
- Empty required fields
- Past dates
- Invalid time format
- Missing seller/manufacturer

### Network Errors:
- Connection timeout
- Server error
- Invalid response

### User Feedback:
- Loading spinner during submission
- Success alert on completion
- Error alert on failure
- Form stays open on error

## ✨ Future Enhancements

Potential additions:
- [ ] Calendar view for date selection
- [ ] Time slot availability
- [ ] Recurring meetings
- [ ] Meeting reminders
- [ ] Video call integration
- [ ] Meeting notes
- [ ] Attachment upload
- [ ] Meeting history
- [ ] Reschedule option
- [ ] Cancel meeting

---

**Status:** ✅ Complete and Production Ready
**Last Updated:** November 19, 2025
**Version:** 1.0.0
