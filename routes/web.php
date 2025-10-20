<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InvoicesController;
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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Salesman\OrderController as SalesmanOrderController;




Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/product/{slug}', [FrontendController::class, 'showProduct'])->name('product.show');







/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/


Route::middleware('auth')->group(function () {
    // Logout route (only for logged-in users)
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');
});

Route::middleware(['web', 'auth'])->group(function () {
    // Auth routes
    Route::middleware('auth')->group(function () {
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

        Route::post('order/{id}/select-address', [CartController::class, 'selectAddress'])->name('order.select-address');
        Route::get('/track-order', [FrontendController::class, 'showTrackOrderForm'])->name('track-order.form');
        Route::get('/order/order-payment', [CartController::class, 'payment'])->name('order.order-payment');
        Route::post('/order/{cart}/place', [CartController::class, 'placeOrder'])->name('order.place');
        Route::get('/customer-invoices', [InvoicesController::class, 'index'])->name('invoices.index');
        Route::get('/customer-invoices/{id}/dowload', [InvoicesController::class, 'download'])->name('invoice.download');
        Route::post('/customer-invoices/{id}/pay', [InvoicesController::class, 'pay'])->name('invoice.pay');

        Route::get('product/{slug}/send-inquiry', [FrontendController::class, 'showInquiryForm'])->name('inquiry.form');

        Route::post('product/send-inquiry', [FrontendController::class, 'submitInquiry'])->name('inquiry.submit');

        Route::resource('user/contacts', UserContactController::class)
            ->names('user.contacts');
        Route::post('/product/{slug}/review', [ReviewController::class, 'store'])->name('review.store');
        Route::post('/product/{review}/ref-order', [ReviewController::class, 'orderWithFer'])->name('review.orderWithFer');
        Route::get('/checkout', [ReviewController::class, 'show'])
            ->name('checkout.page')
            ->middleware('signed');
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
| Protected Seller Routes
|--------------------------------------------------------------------------
*/


Route::prefix('seller')
    ->name('seller.')
    ->middleware(['auth', 'role:seller'])
    ->group(function () {

        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

        Route::post('/logout', [SellerAuthController::class, 'logout'])->name('logout');

        // Product Routes
        Route::resource('products', ProductController::class);
        Route::get('products/create/bulk', [ProductController::class, 'createBulk'])->name('products.createBulk');
        Route::post('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');

        // ✅ Employees Routes
        Route::prefix('employees')->name('employees.')->group(function () {

            Route::resource('accountant', AccountantController::class);
            Route::resource('salesman', SalesmanController::class);
            Route::resource('warehouse', WarehouseController::class);
            Route::resource('delivery', DeliveryController::class);
        });

        Route::get('/contact-book', [ContactBookController::class, 'index'])->name('contact-book.index');

        // Inquiries Routes
        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');

        Route::get('/inquiries/{inquiry}/bulk-order', [InquiryController::class, 'createBulkOrder'])->name('inquiries.bulk-order.create');

        Route::post('/inquiries/bulk-order/store', [InquiryController::class, 'storeBulkOrder'])->name('inquiries.bulk-order.store');

        Route::get('/inquiries/{inquiry}/response', [InquiryController::class, 'createResponse'])->name('inquiries.response.create');


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
    });


/*
|--------------------------------------------------------------------------
| Protected Seller Routes
|--------------------------------------------------------------------------
*/


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
    });


    Route::prefix('accountant')
    ->name('accountant.')
    ->middleware(['auth', 'role:accountant'])
    ->group(function () {
        Route::get('/dashboard', [AccountantController::class, 'index'])->name('dashboard.index');

        // Confirmed orders

        Route::get('/confirmed-orders', [SalesmanOrderController::class, 'index'])->name('confirmed-orders.index');

        Route::get('/confirmed-orders/{id}', [SalesmanOrderController::class, 'show'])->name('confirmed-orders.show');

        Route::put('/confirmed-orders/{id}/confirm', [SalesmanOrderController::class, 'confirm'])->name('confirmed-orders.invoincing');
    });