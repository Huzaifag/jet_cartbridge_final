<?php

use App\Http\Controllers\Accountant\AccountantOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\ChatController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Seller\AccountantController;
use App\Http\Controllers\Seller\AuthController as SellerAuthController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Salesman\DashboardController as Sales;
use App\Http\Controllers\Seller\DeliveryController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SalesmanController;
use App\Http\Controllers\Seller\WarehouseController;
use App\Http\Controllers\Seller\LeadController;
use App\Http\Controllers\Seller\PromotionController;
use App\Http\Controllers\Seller\CoinController;
use App\Http\Controllers\Seller\CommunicationController;
use App\Http\Controllers\Seller\ContactBookController;
use App\Http\Controllers\Seller\SettingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Seller\InquiryController;
use App\Http\Controllers\Seller\LuckyDrawController;
use App\Http\Controllers\UserContactController;
use App\Http\Controllers\Salesman\productController as SalesmanProductController;
use App\Http\Controllers\Warehouse\WarehouseDashboardController;
use App\Http\Controllers\Warehouse\WarehouseOrdersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Salesman\OrderController as SalesmanOrderController;
use App\Http\Controllers\Salesman\LeadController as SalesmanLeadController;
use App\Http\Controllers\Accountant\DashboardController as AccountantDashboardController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\manufacturer\ManufacturerAuthController;
use App\Http\Controllers\manufacturer\ManufacturerDashboardController;
use App\Http\Controllers\manufacturer\ManufacturerProductController;
use App\Http\Controllers\manufacturer\ManufacturerOrderController;
use App\Http\Controllers\manufacturer\ManufacturerCategoryController;
use App\Http\Controllers\manufacturer\ManufacturerInquiryController;
use App\Http\Controllers\manufacturer\ManufacturerSettingController;
use App\Http\Controllers\manufacturer\ManufacturerAccountantController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;



use App\Http\Controllers\Seller\ChatController as SellerChatController;

Route::get('/link-storage', function () {
    try {
        Artisan::call('storage:link');
        return '<h3 style="color:green;">✅ Storage link created successfully!</h3>';
    } catch (\Exception $e) {
        return '<h3 style="color:red;">❌ Failed to create storage link:</h3><pre>' . $e->getMessage() . '</pre>';
    }
});

// Seed database route

Route::get('/seed-database/{class}', function ($class) {
    $class = str_replace('-', '\\', $class); // Allow dashes in URL to represent namespace separators

    try {
        Artisan::call('db:seed', [
            '--class' => $class,
            '--force' => true
        ]);
    } catch (\Exception $e) {
        return '<h3 style="color:red;">❌ Failed to seed database:</h3><pre>' . $e->getMessage() . '</pre>';
    }
});


Route::get('/run-migrations', function () {
    try {
        // Run migrations and capture output
        Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();

        // Check if there was any error-like output
        if (stripos($output, 'error') !== false || stripos($output, 'failed') !== false) {
            Log::error('Migration error detected: ' . $output);
            return response()->json([
                'status' => 'error',
                'message' => 'Migration completed with errors.',
                'output' => $output,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'All migrations executed successfully!',
            'output' => $output,
        ]);

    } catch (Throwable $e) {
        // Catch any PHP/Laravel-level errors
        Log::error('Migration exception: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
})->middleware('auth'); // optional but strongly recommended





Route::get('/run-storage-setup', function () {
    // Run Laravel artisan commands
    Artisan::call('storage:link');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');

    // Safely update permissions without exec()
    $storagePath = storage_path();

    if (File::exists($storagePath)) {
        $files = File::allFiles($storagePath);
        foreach ($files as $file) {
            @chmod($file->getRealPath(), 0775);
        }

        $directories = File::directories($storagePath);
        foreach ($directories as $dir) {
            @chmod($dir, 0775);
        }
    }

    return '✅ Storage linked, cache cleared, and permissions updated successfully!';
})->middleware('auth'); // Optional but highly recommended


Route::get('/optimize-clear', function () {
    if (!app()->environment('local')) {
        abort(403, 'Not allowed in this environment');
    }

    Artisan::call('optimize:clear');

    return '✅ All caches cleared (config, route, view, and compiled files).';
});


Route::middleware(['auth'])->prefix('customer')->group(function () {
    Route::post('/chat/start', [ChatController::class, 'startConversation'])->name('chat.start');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{conversationId}', [ChatController::class, 'fetchMessages'])->name('chat.fetchMessages');
    Route::get('/chat/conversations', [ChatController::class, 'fetchConversations'])->name('chat.fetchConversations');

    // Business History Routes
    Route::get('/business-history', [\App\Http\Controllers\Buyer\BusinessHistoryController::class, 'index'])->name('business-history.index');
    Route::get('/business-history/{seller}', [\App\Http\Controllers\Buyer\BusinessHistoryController::class, 'show'])->name('business-history.show');
});

Route::post('/meeting/request', [MeetingController::class, 'customerRequest'])
    ->name('customer.meeting.request')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/meeting/join/{room_name}', [MeetingController::class, 'join'])
        ->name('meeting.join');
});





Route::get('/', [FrontendController::class, 'index'])->name('home');

// Frontend Pages
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/terms', [FrontendController::class, 'terms'])->name('terms');
Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/categories', [FrontendController::class, 'categories'])->name('categories');
Route::get('/sellers', [FrontendController::class, 'sellers'])->name('sellers');
Route::get('/manufacturers', [FrontendController::class, 'manufacturers'])->name('manufacturers');
Route::get('/resources', [FrontendController::class, 'resources'])->name('resources');

Route::get('/product/{slug}', [FrontendController::class, 'showProduct'])->name('product.show');

Route::get('/contributor-dashboard', [FrontendController::class, 'contributorDashboard'])->name('contributor.dashboard')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::post('/follow/seller/{seller}', [App\Http\Controllers\FollowController::class, 'followSeller'])->name('follow.seller');
    Route::post('/follow/manufacturer/{manufacturer}', [App\Http\Controllers\FollowController::class, 'followManufacturer'])->name('follow.manufacturer');
});


// kbkb




/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/


Route::middleware('auth')->group(function () {
    // Logout route (only for logged-in users)
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    // Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');
});

Route::middleware(['web', 'auth'])->group(function () {
    // Auth routes
    Route::middleware('auth')->group(function () {
        // Cart routes with proper role restriction
        Route::middleware(['role:customer'])->group(function () {
            Route::get('/cart', [CartController::class, 'index'])->name('cart');
            Route::delete('/cart/item/{item}', [CartController::class, 'removeFromCart'])->name('cart.remove');
            Route::post('/add-to-cart/{product}', [CartController::class, 'addToCart'])->name('addToCart');
            Route::post('/order/{cart}', [CartController::class, 'order'])->name('order');
            // Selection management
            Route::post('/cart/{cartItem}/toggle-selection', [CartController::class, 'toggleItemSelection'])->name('cart.toggle.selection');
            Route::post('/cart/{cart}/select-all', [CartController::class, 'selectAll'])->name('cart.select.all');
            Route::post('/cart/{cart}/deselect-all', [CartController::class, 'deselectAll'])->name('cart.deselect.all');
            Route::post('/cart/{cart}/toggle-select-all', [CartController::class, 'toggleSelectAll'])->name('cart.toggle.select.all');
            Route::post('/cart/{cart}/bulk-update-selection', [CartController::class, 'bulkUpdateSelection'])->name('cart.bulk.update.selection');
            Route::put('/cart/{cartItem}/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
            Route::get('/cart/{cart}/selected-summary', [CartController::class, 'getSelectedSummary'])->name('cart.selected.summary');

            // Checkout flow
            Route::post('order/{id}/select-address', [CartController::class, 'selectAddress'])->name('order.select-address');
            Route::get('/order/order-payment', [CartController::class, 'payment'])->name('order.order-payment');
            Route::post('/order/{cart}/place', [CartController::class, 'placeOrder'])->name('order.place');

            // User contacts management
            Route::resource('user/contacts', UserContactController::class)
                ->names('user.contacts');
        });

        // General authenticated routes
        Route::get('/track-order', [FrontendController::class, 'showTrackOrderForm'])->name('track-order.form');
        Route::get('/customer-invoices', [InvoicesController::class, 'index'])->name('invoices.index');
        Route::get('/customer-invoices/{id}/dowload', [InvoicesController::class, 'download'])->name('invoice.download');
        Route::post('/customer-invoices/{id}/pay', [InvoicesController::class, 'pay'])->name('invoice.pay');

        Route::get('product/{slug}/send-inquiry', [FrontendController::class, 'showInquiryForm'])->name('inquiry.form');
        Route::post('product/send-inquiry', [FrontendController::class, 'submitInquiry'])->name('inquiry.submit');

        Route::post('/product/{slug}/review', [ReviewController::class, 'store'])->name('review.store');
        Route::post('/test-upload', [ReviewController::class, 'testUpload'])->name('review.test-upload');
        Route::post('/product/{review}/ref-order', [ReviewController::class, 'orderWithFer'])->name('review.orderWithFer');
        Route::get('/checkout', [ReviewController::class, 'show'])
            ->name('checkout.page')
            ->middleware('signed');

        // Video Reviews Routes
        Route::get('/video-reviews/{slug?}', [ReviewController::class, 'videoReels'])->name('video.reviews');
        Route::post('/api/reviews/{review}/view', [ReviewController::class, 'trackView'])->name('review.track-view');
        Route::post('/api/reviews/{review}/like', [ReviewController::class, 'toggleLike'])->name('review.toggle-like');
        Route::get('/api/reviews/{review}/comments', [ReviewController::class, 'getComments'])->name('review.get-comments');
        Route::post('/api/reviews/{review}/comments', [ReviewController::class, 'postComment'])->name('review.post-comment');
        Route::post('/api/reviews/{review}/share', [ReviewController::class, 'trackShare'])->name('review.track-share');

        // Customer Support API Routes
        Route::get('/api/sellers/list', [\App\Http\Controllers\Api\SupportController::class, 'getSellers'])->name('api.sellers.list');
        Route::get('/api/manufacturers/list', [\App\Http\Controllers\Api\SupportController::class, 'getManufacturers'])->name('api.manufacturers.list');
        Route::post('/api/conversations/create', [\App\Http\Controllers\Api\SupportController::class, 'createConversation'])->name('api.conversations.create');
        Route::post('/api/meetings/request', [\App\Http\Controllers\Api\SupportController::class, 'requestMeeting'])->name('api.meetings.request');
    });
});


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

// Routes for guests only (redirects to "/" if already logged in)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    // Registration Routes
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});


/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Guest Seller Routes
|--------------------------------------------------------------------------
*/

Route::prefix('seller')->name('seller.')->group(function () {

    // ✅ Auth Routes
    Route::middleware(['guest:seller'])->group(function () {
        // Seller Register
        Route::get('/register', [SellerAuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register/step1', [SellerAuthController::class, 'processStep1'])->name('register.step1');
        Route::post('/register/step2', [SellerAuthController::class, 'processStep2'])->name('register.step2');
        Route::post('/register/step3', [SellerAuthController::class, 'processStep3'])->name('register.step3');

        // Seller Login
        Route::get('/login', [SellerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [SellerAuthController::class, 'login'])->name('login.submit');
    });
});

/*
|--------------------------------------------------------------------------
| Unified Admin Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');
    
    // Unified Product Management Routes
    Route::resource('admin/products', \App\Http\Controllers\Admin\ProductController::class, [
        'as' => 'admin'
    ]);
    
    // Appointment Management Routes
    Route::prefix('admin/appointments')->name('admin.appointments.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AppointmentController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AppointmentController::class, 'show'])->name('show');
        Route::post('/create', [\App\Http\Controllers\Admin\AppointmentController::class, 'createMeeting'])->name('create');
        Route::post('/{id}/status', [\App\Http\Controllers\Admin\AppointmentController::class, 'updateStatus'])->name('update-status');
        Route::get('/calendar/data', [\App\Http\Controllers\Admin\AppointmentController::class, 'getCalendarData'])->name('calendar-data');
        Route::get('/search-customers', [\App\Http\Controllers\Admin\AppointmentController::class, 'searchCustomers'])->name('search-customers');
        Route::get('/export', [\App\Http\Controllers\Admin\AppointmentController::class, 'export'])->name('export');
    });
    
    // Inquiry Management Routes
    Route::prefix('admin/inquiries')->name('admin.inquiries.')->group(function () {
        Route::get('/{id}', [\App\Http\Controllers\Admin\AppointmentController::class, 'showInquiry'])->name('show');
        Route::post('/{id}/status', [\App\Http\Controllers\Admin\AppointmentController::class, 'updateInquiryStatus'])->name('update-status');
        Route::post('/{id}/convert-to-lead', [\App\Http\Controllers\Admin\AppointmentController::class, 'convertToLead'])->name('convert-to-lead');
    });
    
    // Placeholder routes for navigation (you can implement these later)
    Route::get('/admin/messages', function() { return redirect()->route('admin.dashboard'); })->name('admin.messages.index');
    Route::get('/admin/settings', function() { return redirect()->route('admin.dashboard'); })->name('admin.settings.index');
});

// Demo route to show the unified dashboard implementation
Route::get('/demo/unified-dashboard', function() {
    return view('demo.unified-dashboard');
})->name('demo.unified-dashboard');

/*
|--------------------------------------------------------------------------
| Protected Seller Routes
|--------------------------------------------------------------------------
*/


Route::prefix('seller')
    ->name('seller.')
    ->middleware(['auth', 'role:seller'])
    ->group(function () {

        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard')->middleware('unified_dashboard');

        Route::post('/logout', [SellerAuthController::class, 'logout'])->name('logout');

        // Product Routes
        Route::resource('products', ProductController::class);
        Route::get('products/create/bulk', [ProductController::class, 'createBulk'])->name('products.createBulk');
        Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');

        // Category Routes
        Route::resource('categories', \App\Http\Controllers\Seller\CategoryController::class);

        // ✅ Employees Routes
        Route::prefix('employees')->name('employees.')->group(function () {

            Route::resource('accountant', AccountantController::class);
            Route::resource('salesman', SalesmanController::class);
            Route::resource('warehouse', WarehouseController::class);
            Route::resource('delivery', DeliveryController::class);
        });

        // Employee Activities Route
        Route::get('/employee-activities', [\App\Http\Controllers\Seller\EmployeeActivityController::class, 'index'])->name('employee-activities.index');

        Route::get('/contact-book', [ContactBookController::class, 'index'])->name('contact-book.index');

        // Analytics Routes
        Route::get('/analytics', [\App\Http\Controllers\Seller\AnalyticsController::class, 'index'])->name('analytics.index');

        // Business History Routes
        Route::get('/business-history', [\App\Http\Controllers\Seller\BusinessHistoryController::class, 'index'])->name('business-history.index');
        Route::get('/business-history/{customer}', [\App\Http\Controllers\Seller\BusinessHistoryController::class, 'show'])->name('business-history.show');

        // Inquiries Routes
        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');

        Route::get('/inquiries/{inquiry}/bulk-order', [InquiryController::class, 'createBulkOrder'])->name('inquiries.bulk-order.create');

        Route::post('/inquiries/bulk-order/store', [InquiryController::class, 'storeBulkOrder'])->name('inquiries.bulk-order.store');

        Route::get('/inquiries/{inquiry}/response', [InquiryController::class, 'createResponse'])->name('inquiries.response.create');

        Route::get('/inquiries/{inquiry}/assign', [InquiryController::class, 'showAssignForm'])->name('inquiries.assign');
        Route::post('/inquiries/{inquiry}/assign-salesman', [InquiryController::class, 'assignToSalesman'])->name('inquiries.assign-salesman');

        Route::get('/bulk-orders', [InquiryController::class, 'bulkIndex'])->name('bulk-orders.index');


        Route::get('/bulk-orders/{bulkOrder}', [InquiryController::class, 'bulkShow'])->name('bulk-orders.show');





        // ✅ Orders Resource Routes
        Route::resource('orders', OrderController::class);


        // ✅ Order Tracking Routes
        Route::prefix('orders/track')->name('orders.track.')->group(function () {
            Route::get('/', [OrderController::class, 'tracking_view'])->name('index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        });
        // ✅ Leads (single page, not resource)
        Route::get('/leads', [LeadController::class, 'index'])->name('leads');
        Route::get('/leads/{lead}/assign', [LeadController::class, 'assign'])->name('leads.assign');

        // ✅ Promotions (full CRUD)
        Route::resource('promotions', PromotionController::class);
        Route::get('/lucky-draw/{luckyDraw}/entries', [LuckyDrawController::class, 'entries'])
            ->name('lucky-draw.entries');

        // ✅ Coins & Rewards (full CRUD if needed)
        Route::resource('coins', CoinController::class);

        // ✅ Communication (single page, not resource)
        Route::get('/communication', [CommunicationController::class, 'index'])->name('communication');

        // ✅ Settings (single page, not resource)
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('payment-settings/store', [App\Http\Controllers\Seller\PaymentSettingsController::class, 'store'])->name('payment-settings.store');

        Route::post('notification-preferences/store', [App\Http\Controllers\Seller\NotificationPreferenceController::class, 'store'])->name('notification-preferences.store');
        Route::get('notification-preferences/show', [App\Http\Controllers\Seller\NotificationPreferenceController::class, 'show'])->name('notification-preferences.show');
        Route::post('twofactor/store', [App\Http\Controllers\Seller\TwoFactorController::class, 'store'])->name('twofactor.store');
        Route::post('change-password', [App\Http\Controllers\Seller\SettingsController::class, 'changePassword'])->name('change-password');

        Route::prefix('chat')->name('chat.')->group(function () {
            // Seller chat main page (sidebar + chat window)
            Route::get('/', [SellerChatController::class, 'index'])->name('index');

            // Fetch all conversations (for sidebar via AJAX)
            Route::get('/conversations', [SellerChatController::class, 'fetchConversations'])->name('conversations');

            // Fetch all messages of a conversation
            Route::get('/messages/{conversationId}', [SellerChatController::class, 'fetchMessages'])->name('messages');

            // Send message (Seller → Customer)
            Route::post('/send', [SellerChatController::class, 'sendMessage'])->name('send');
        });

        Route::post('/meeting/{id}/accept', [MeetingController::class, 'accept'])
            ->name('meeting.accept');
        Route::post('/meeting/{id}/reject', [MeetingController::class, 'reject'])
            ->name('/meeting.reject');

        Route::get('/meetings', [MeetingController::class, 'index'])
            ->name('meetings.index');
    });

// Seller Profile Route (must come after seller dashboard routes to avoid conflicts)
Route::get('/seller/{slug}', [FrontendController::class, 'sellerProfile'])->name('seller.profile');

/*
|--------------------------------------------------------------------------
| Guest Manufacturer Routes
|--------------------------------------------------------------------------
*/

Route::prefix('manufacturer')->name('manufacturer.')->group(function () {

    // ✅ Auth Routes
    Route::middleware(['guest'])->group(function () {
        // Manufacturer Register (step-wise)
        Route::get('/register', [ManufacturerAuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register/step1', [ManufacturerAuthController::class, 'processStep1'])->name('register.step1');
        Route::post('/register/step2', [ManufacturerAuthController::class, 'processStep2'])->name('register.step2');
        Route::post('/register/step3', [ManufacturerAuthController::class, 'processStep3'])->name('register.step3');

        // Manufacturer Login
        Route::get('/login', [ManufacturerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [ManufacturerAuthController::class, 'login'])->name('login.submit');
    });
});

/*
|--------------------------------------------------------------------------
| Protected Manufacturer Routes
|--------------------------------------------------------------------------
*/

Route::prefix('manufacturer')
    ->name('manufacturer.')
    ->middleware(['auth', 'role:manufacturer'])
    ->group(function () {

        Route::get('/dashboard', [ManufacturerDashboardController::class, 'index'])->name('dashboard')->middleware('unified_dashboard');

        Route::post('/logout', [ManufacturerAuthController::class, 'logout'])->name('logout');

        // Product Routes
        Route::resource('products', ManufacturerProductController::class);
        Route::get('products/create/bulk', [ManufacturerProductController::class, 'createBulk'])->name('products.createBulk');
        Route::post('products/bulk-delete', [ManufacturerProductController::class, 'bulkDelete'])->name('products.bulk-delete');

        // Category Routes
        Route::resource('categories', ManufacturerCategoryController::class);

        // Employees Routes
        Route::prefix('employees')->name('employees.')->group(function () {
            Route::resource('accountant', ManufacturerAccountantController::class);
            Route::resource('salesman', App\Http\Controllers\manufacturer\ManufacturerSalesmanController::class);
            Route::resource('warehouse', App\Http\Controllers\manufacturer\ManufacturerWarehouseController::class);
            Route::resource('delivery', App\Http\Controllers\manufacturer\ManufacturerDeliveryController::class);
        });

        // Inquiries Routes
        Route::get('/inquiries', [ManufacturerInquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/{inquiry}/bulk-order', [ManufacturerInquiryController::class, 'createBulkOrder'])->name('inquiries.bulk-order.create');
        Route::post('/inquiries/bulk-order/store', [ManufacturerInquiryController::class, 'storeBulkOrder'])->name('inquiries.bulk-order.store');
        Route::get('/inquiries/{inquiry}/response', [ManufacturerInquiryController::class, 'createResponse'])->name('inquiries.response.create');

        // Bulk Orders
        Route::get('/bulk-orders', [ManufacturerInquiryController::class, 'bulkIndex'])->name('bulk-orders.index');
        Route::get('/bulk-orders/{bulkOrder}', [ManufacturerInquiryController::class, 'bulkShow'])->name('bulk-orders.show');

        // Orders Resource Routes
        Route::resource('orders', ManufacturerOrderController::class);

        // Order Tracking Routes
        Route::prefix('orders/track')->name('orders.track.')->group(function () {
            Route::get('/', [ManufacturerOrderController::class, 'tracking_view'])->name('index');
            Route::get('/{order}', [ManufacturerOrderController::class, 'show'])->name('show');
        });

        // Settings
        Route::get('/settings', [ManufacturerSettingController::class, 'index'])->name('settings');
        Route::post('/settings/profile', [ManufacturerSettingController::class, 'updateProfile'])->name('settings.profile');
        Route::post('/settings/change-password', [ManufacturerSettingController::class, 'changePassword'])->name('settings.change-password');
        Route::post('payment-settings/store', [App\Http\Controllers\Seller\PaymentSettingsController::class, 'store'])->name('payment-settings.store');
        Route::post('notification-preferences/store', [App\Http\Controllers\Seller\NotificationPreferenceController::class, 'store'])->name('notification-preferences.store');
        Route::get('notification-preferences/show', [App\Http\Controllers\Seller\NotificationPreferenceController::class, 'show'])->name('notification-preferences.show');
        Route::post('twofactor/store', [App\Http\Controllers\Seller\TwoFactorController::class, 'store'])->name('twofactor.store');
        Route::post('change-password', [ManufacturerSettingController::class, 'changePassword'])->name('change-password');

        // Meetings
        Route::post('/meeting/{id}/accept', [MeetingController::class, 'accept'])->name('meeting.accept');
        Route::post('/meeting/{id}/reject', [MeetingController::class, 'reject'])->name('meeting.reject');
        Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index');
    });



Route::prefix('salesman')
    ->name('salesman.')
    ->middleware(['auth', 'role:salesman'])
    ->group(function () {
        Route::get('/dashboard', [Sales::class, 'index'])->name('dashboard.index');

        // Product Routes
        Route::resource('products', SalesmanProductController::class);
        Route::get('products/create/bulk', [SalesmanProductController::class, 'createBulk'])->name('products.createBulk');
        Route::post('products/bulk-delete', [SalesmanProductController::class, 'bulkDelete'])->name('products.bulk-delete');

        // Placed orders
    
        Route::get('/placed-orders', [SalesmanOrderController::class, 'index'])->name('placed-orders.index');

        Route::get('/placed-orders/{id}', [SalesmanOrderController::class, 'show'])->name('placed-orders.show');

        Route::put('/placed-orders/{id}/confirm', [SalesmanOrderController::class, 'confirm'])->name('placed-orders.confirm');

        // Lead Management Routes
        Route::get('/leads', [SalesmanLeadController::class, 'index'])->name('leads.index');
        Route::get('/leads/{id}', [SalesmanLeadController::class, 'show'])->name('leads.show');
        Route::put('/leads/{id}/status', [SalesmanLeadController::class, 'updateStatus'])->name('leads.update-status');
        Route::put('/leads/{id}/priority', [SalesmanLeadController::class, 'updatePriority'])->name('leads.update-priority');
        Route::post('/leads/{id}/split', [SalesmanLeadController::class, 'split'])->name('leads.split');
        Route::post('/leads/{id}/follow-up', [SalesmanLeadController::class, 'markFollowedUp'])->name('leads.follow-up');
    });


Route::prefix('accountant')
    ->name('accountant.')
    ->middleware(['auth', 'role:accountant'])
    ->group(function () {
        Route::get('/dashboard', [AccountantDashboardController::class, 'index'])->name('dashboard.index');

        // Confirmed orders
    
        Route::get('/confirmed-orders', [AccountantOrderController::class, 'index'])->name('confirmed-orders.index');

        Route::get('/confirmed-orders/{id}', [AccountantOrderController::class, 'show'])->name('confirmed-orders.show');

        Route::get('/confirmed-orders/{id}/confirm', [AccountantOrderController::class, 'confirm'])->name('confirmed-orders.confirm');

        Route::post('/orders/{id}/invoice/save', [AccountantOrderController::class, 'saveInvoice'])->name('orders.invoice.save');
    });


Route::prefix('warehouse')
    ->name('warehouse.')
    ->middleware(['auth', 'role:warehouse'])
    ->group(function () {
        Route::get('/dashboard', [WarehouseDashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/warehouse-orders', [WarehouseOrdersController::class, 'index'])->name('orders.index');
        Route::get('/warehouse-orders/{id}/', [WarehouseOrdersController::class, 'show'])->name('orders.show');
        Route::post('/warehouse/orders/dispatch/{id}/', [WarehouseOrdersController::class, 'dispatch'])->name('orders.dispatch');
        Route::get('/warehouse/orders/edit/{id}/', [WarehouseOrdersController::class, 'edit'])->name('orders.edit');
    });

Route::prefix('deliveryman')
    ->name('deliveryman.')
    ->middleware(['auth', 'role:deliveryman'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Deliveryman\DeliveryManController::class, 'index'])->name('dashboard');
        Route::get('/orders', [App\Http\Controllers\Deliveryman\DeliveryManController::class, 'orders'])->name('orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Deliveryman\DeliveryManController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/deliver', [App\Http\Controllers\Deliveryman\DeliveryManController::class, 'deliver'])->name('orders.deliver');
        Route::get('/orders/{order}/deliver/edit', [App\Http\Controllers\Deliveryman\DeliveryManController::class, 'edit'])->name('orders.edit');
    });
/*
|--------------------------------------------------------------------------
| Enhanced User Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [App\Http\Controllers\UserProfileController::class, 'show'])->name('user.profile');
    Route::get('/profile/edit', [App\Http\Controllers\UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/basic', [App\Http\Controllers\UserProfileController::class, 'updateBasic'])->name('profile.update.basic');
    Route::put('/profile/pictures', [App\Http\Controllers\UserProfileController::class, 'updatePictures'])->name('profile.update.pictures');
    Route::put('/profile/privacy', [App\Http\Controllers\UserProfileController::class, 'updatePrivacy'])->name('profile.update.privacy');
    Route::put('/profile/password', [App\Http\Controllers\UserProfileController::class, 'changePassword'])->name('profile.change.password');
    
    // Public profile view
    Route::get('/user/{user}', [App\Http\Controllers\UserProfileController::class, 'show'])->name('user.profile.public');
    
    // Work Experience routes
    Route::post('/profile/work-experience', [App\Http\Controllers\WorkExperienceController::class, 'store'])->name('work-experience.store');
    Route::put('/profile/work-experience/{workExperience}', [App\Http\Controllers\WorkExperienceController::class, 'update'])->name('work-experience.update');
    Route::delete('/profile/work-experience/{workExperience}', [App\Http\Controllers\WorkExperienceController::class, 'destroy'])->name('work-experience.destroy');
    
    // Education routes
    Route::post('/profile/education', [App\Http\Controllers\UserEducationController::class, 'store'])->name('education.store');
    Route::put('/profile/education/{education}', [App\Http\Controllers\UserEducationController::class, 'update'])->name('education.update');
    Route::delete('/profile/education/{education}', [App\Http\Controllers\UserEducationController::class, 'destroy'])->name('education.destroy');
    
    // Certification routes
    Route::post('/profile/certification', [App\Http\Controllers\UserCertificationController::class, 'store'])->name('certification.store');
    Route::put('/profile/certification/{certification}', [App\Http\Controllers\UserCertificationController::class, 'update'])->name('certification.update');
    Route::delete('/profile/certification/{certification}', [App\Http\Controllers\UserCertificationController::class, 'destroy'])->name('certification.destroy');
    
    // Connection routes
    Route::get('/profile/connections', [App\Http\Controllers\UserProfileController::class, 'connections'])->name('profile.connections');
    Route::post('/profile/connect/{user}', [App\Http\Controllers\UserProfileController::class, 'sendConnectionRequest'])->name('profile.connect');
    Route::put('/profile/connection/{connection}/respond', [App\Http\Controllers\UserProfileController::class, 'respondToConnection'])->name('profile.connection.respond');
});