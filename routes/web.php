<?php
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\FCMController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\ProfileController as FrontProfileController;
// use App\Http\Controllers\PaymentController;

use App\Http\Controllers\RestaurantAdmin\ItemController;
use App\Http\Controllers\RestaurantAdmin\OfferController;
use App\Http\Controllers\Admin\PageVisitController;
use App\Http\Controllers\RestaurantAdmin\RestaurantPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\RestaurantAdmin\DashboardController as RestaurantDashboardController;
use App\Http\Controllers\RestaurantAdmin\OrderController as RestaurantOrderController;

use App\Http\Controllers\RestaurantAdmin\ProfileController;
use App\Http\Controllers\Front\UserDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MarketingBannerCategoryController;
use App\Http\Controllers\Admin\MarketingBannerController;
use App\Http\Controllers\RestaurantAdmin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\RestaurantAdmin\ProductController as RestaurantProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Front\MarketingBannerController as FrontMarketingBannerController;
use App\Http\Controllers\RestaurantAdmin\OrderOfferController;
use App\Http\Controllers\RestaurantInvoiceController;
use App\Http\Controllers\UserInvoiceController;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Admin\TermsAndConditionController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\RestaurantCategoryController;
use App\Http\Controllers\Admin\RestaurantPolicyController;
use App\Http\Controllers\Admin\RestaurantRefundPolicyController;
use App\Http\Controllers\Admin\RestaurantTermsConditionController;

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RestaurantAdmin\RestaurantBannerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\RestaurantAdmin\ProductAddonController;
use App\Http\Controllers\RestaurantAdmin\CustomerController;
use App\Http\Controllers\RestaurantAdmin\MarketingController;
use App\Http\Controllers\RestaurantAdmin\LoyaltyRewardController;



// ---use when migrate image db to drive-----
// Route::get(
//     '/admin/products/migrate-remaining-images',
//     [ProductController::class, 'migrateRemainingImages']
// )->name('products.migrate-remaining-images');
// ----------------------------------------------



Route::post(
    '/driverwebhook',
    [RestaurantOrderController::class, 'driverwebhook']
);

Route::get('/cart/summary', [CartController::class, 'summary']);

use App\Http\Controllers\UberWebhookController;

Route::post('/uber/webhook', [UberWebhookController::class, 'handle']);




use App\Http\Controllers\Front\UserAddressController;
use App\Http\Controllers\RestaurantAdmin\PageVisitController as RestaurantAdminPageVisitController;

Route::post('/checkout/uber/quote', [UserAddressController::class, 'generateUberQuote'])
    ->name('checkout.uber.quote');

Route::middleware('auth')->group(function () {
    Route::get('/addresses/{id}', [UserAddressController::class, 'show'])->name('addresses.show');
    Route::get('/addresses', [UserAddressController::class, 'index'])->name('addresses.index');

    Route::post('/addresses', [UserAddressController::class, 'store'])->name('addresses.store');

    Route::put('/addresses/{id}', [UserAddressController::class, 'update'])->name('addresses.update');

    Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy'])->name('addresses.destroy');

    Route::post('/addresses/{id}/default', [UserAddressController::class, 'setDefault'])->name('addresses.default');
});




Route::post(

    '/submit-review/{id}',
    [OrderController::class, 'submitReview']

)->middleware('auth');

Route::get(
    '/notifications/latest',
    [NotificationController::class, 'latest']
)->middleware('auth');

Route::middleware('auth')->group(function () {

    // Customer
    Route::post('/complaints', [ComplaintController::class, 'store'])
        ->name('complaints.store');
    
    Route::post('/complaints/message/{id}', [ComplaintController::class, 'sendMessage'])
        ->name('complaints.message');    

    Route::get('/my-complaints', [ComplaintController::class, 'myComplaints'])
        ->name('complaints.my');


    // Restaurant
    Route::get('/restaurant/complaints', [ComplaintController::class, 'restaurantComplaints'])
        ->name('restaurant.complaints');

    Route::post('/restaurant/complaints/{id}/reply', [ComplaintController::class, 'reply'])
        ->name('restaurant.complaints.reply');

});

Route::get(
    '/restaurant/orders/{id}/invoice',
    [RestaurantInvoiceController::class, 'show']
)->name('restaurant.invoice.show');

Route::get(
    '/my-orders/{id}/invoice',
    [UserInvoiceController::class,'show']
)->name('user.invoice.show');

// Route::get('/payment', [PaymentController::class, 'index'])->name('payment.form');
// Route::post('/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay');
// Route::post('/payment/notify', [PaymentController::class, 'notify'])->name('payment.notify');
// Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
// Route::post('/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure');
// Route::get('/payment/successpage', [PaymentController::class, 'successPage'])->name('payment.successpage');

Route::get(
    '/payment',
    [PaymentController::class, 'index']
)->name('payment.form');

Route::post(
    '/payment/pay',
    [PaymentController::class, 'pay']
)->name('payment.pay');

Route::get('/payment/callback',[PaymentController::class,'callback'])
    ->name('payment.callback');

Route::match(
    ['get', 'post'],
    '/payment/notify',
    [PaymentController::class, 'notify']
)->name('payment.notify');

Route::match(
    ['get', 'post'],
    '/payment/success',
    [PaymentController::class, 'success']
)->name('payment.success');

Route::match(
    ['get', 'post'],
    '/payment/failure',
    [PaymentController::class, 'failure']
)->name('payment.failure');

Route::get(
    '/payment/successpage',
    [PaymentController::class, 'successPage']
)->name('payment.successpage');

Route::get(
    '/',
    [HomeController::class, 'home']
);

Route::get(
    '/home',
    [HomeController::class, 'home']
);

Route::get(
    '/category/{id}',
    [HomeController::class, 'categoryProducts']
);

Route::get(
    '/product/{id}',
    [HomeController::class, 'productDetails']
);

Route::post('/cart/clear', [CartController::class, 'clear']);

// Route::get(
//     '/restaurants',
//     [HomeController::class, 'restaurants']
// );

Route::get('/offers/{id}', [FrontMarketingBannerController::class, 'show'])
    ->name('front.banners.show');

Route::post('/offers/contact', [FrontMarketingBannerController::class, 'contact'])
    ->name('front.banners.contact');

// Register in routes/web.php:
Route::get('/offers', [FrontMarketingBannerController::class, 'index'])
     ->name('front.banners.index');

Route::post(

    '/save-fcm-token',
    [FCMController::class, 'saveToken']

)->middleware('auth');

 Route::get(
        '/cart',
        [CartController::class, 'index']
    )->name('cart.index');

    Route::post(
        '/cart/add',
        [CartController::class, 'add']
    );

    Route::get(
        '/cart/remove-addon/{cartKey}/{addonId}',
        [CartController::class,'removeAddon']
    )->name('cart.removeAddon');
    
    Route::get(
        '/cart/increase/{id}',
        [CartController::class, 'increase']
    );

    Route::get(
        '/cart/decrease/{id}',
        [CartController::class, 'decrease']
    );

    Route::get(
        '/cart/remove/{id}',
        [CartController::class, 'remove']
    );

    Route::post('/guest-checkout', [OrderController::class, 'storeGuestInfo'])
    ->name('guest.checkout.store');

    Route::get(
        '/checkout',
        [OrderController::class, 'checkout']
    )->name('checkout');

    Route::get('/checkout/success', [PaymentController::class, 'callsuccess'])
    ->name('checkout.success');

    Route::get('/checkout/failed', [PaymentController::class, 'callfailed'])
        ->name('checkout.failed');

    Route::post(
        '/payment/finalize/{payment}',
        [PaymentController::class,'finalize']
    )->name('payment.finalize');

    Route::post(
        '/place-order',
        [OrderController::class, 'placeOrder']
    )->name('place.order');


Route::middleware(['auth'])->group(function () {
    Route::post(
        '/notifications/{id}/clear',
        [NotificationController::class, 'clear']
    )->name('notifications.clear');

    Route::post(
        '/notifications/clear-all',
        [NotificationController::class, 'clearAll']
    )->name('notifications.clearAll');
    
    Route::get(
        '/dashboard',
        [UserDashboardController::class, 'index']
    );

   
    Route::get(
        '/my-orders',
        [OrderController::class, 'myOrders']
    )->name('my.orders');
    Route::get(
        '/my-orders/{id}',
        [OrderController::class, 'orderDetails']
    );

    Route::get(
        '/my-orders/{id}/status',
        [OrderController::class, 'orderStatus']
    )->middleware('auth');


    Route::post(

        '/order/cancel/{id}',

        [OrderController::class, 'cancelOrder']

    )->middleware('auth');

    Route::get(
        '/profile',
        [FrontProfileController::class, 'index']
    )->name('profile');
    

    Route::post(
        '/profile/update',
        [FrontProfileController::class, 'update']
    );
    Route::get(
        '/transactions',
        [OrderController::class, 'transactions']
    );

    Route::post(
        '/my-orders/{id}/evidence',
        [OrderController::class, 'uploadCustomerEvidence']
    )->name('user.orders.evidence');

    

    Route::prefix('restaurant/order-offers')->group(function () {

        Route::get('/', [OrderOfferController::class, 'index']);
        Route::get('/create', [OrderOfferController::class, 'create']);
        Route::post('/', [OrderOfferController::class, 'store']);

        Route::get('/{id}/edit', [OrderOfferController::class, 'edit']);
        Route::put('/{id}', [OrderOfferController::class, 'update']);

        Route::delete('/{id}', [OrderOfferController::class, 'destroy']);

    });

});

Route::middleware(['auth'])
    ->prefix('vendor')
    ->name('vendor.')
    ->group(function () {

        Route::get('/dashboard', function () {

            return view('vendor.dashboard');

        });

        Route::resource(
            'products',
            \App\Http\Controllers\Vendor\ProductController::class
        );

    });

Route::middleware(['auth', 'super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::resource('restaurants', RestaurantController::class);


        Route::resource('products', ProductController::class);

        Route::resource(
            'restaurant-categories',
            RestaurantCategoryController::class
        );
        Route::resource('orders', OrdersController::class);
        Route::resource('vendor', VendorController::class);
		Route::get(

            '/page-visits',

            [PageVisitController::class,'index']

        )->name('page-visits.index');

        Route::resource('marketing-banners', MarketingBannerController::class);

        Route::resource(
            'marketing-banner-categories',
            MarketingBannerCategoryController::class
        );

        Route::put('/restaurants/{restaurant}/display-order', [RestaurantController::class, 'updateOrder'])
            ->name('restaurants.updateOrder');
        Route::get(
            '/users',
            [UserController::class, 'index']
        )->name('users.index');
        Route::delete(
            '/users/{id}',
            [UserController::class, 'destroy']
        )
            ->name('users.destroy');
        Route::post(
            '/orders/status/{id}',
            [OrdersController::class, 'updateStatus']
        )->name('orders.status');

        Route::get('/terms-and-conditions', [TermsAndConditionController::class, 'edit'])
            ->name('terms.edit');
        Route::post('/terms-and-conditions', [TermsAndConditionController::class, 'update'])
            ->name('terms.update');

        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'edit'])
            ->name('privacy.edit');
        Route::post('/privacy-policy', [PrivacyPolicyController::class, 'update'])
            ->name('privacy.update');


        Route::get('/restaurant/privacy-policy/{restaurant}', [RestaurantPolicyController::class, 'edit'])
            ->name('restaurant.privacy-policy.edit');
        Route::post('/restaurant/privacy-policy/{restaurant}', [RestaurantPolicyController::class, 'update'])
            ->name('restaurant.privacy-policy.update');


        Route::get(
            '/restaurant/terms/{restaurant}',
            [RestaurantTermsConditionController::class, 'edit']
        )->name('restaurant.terms.edit');

        Route::post(
            '/restaurant/terms/{restaurant}',
            [RestaurantTermsConditionController::class, 'update']
        )->name('restaurant.terms.update'); 

        // Admin
        Route::get(
            '/restaurant/refund-policy/{restaurant}',
            [RestaurantRefundPolicyController::class, 'edit']
        )->name('restaurant.refund-policy.edit');

        Route::post(
            '/restaurant/refund-policy/{restaurant}',
            [RestaurantRefundPolicyController::class, 'update']
        )->name('restaurant.refund-policy.update');



    });

    Route::post(
        '/restaurant/orders/{id}/message',
        [RestaurantOrderController::class, 'sendMessage']
    )->name('restaurant.orders.message');

Route::middleware(['auth', 'restaurant_admin'])
    ->prefix('restaurant')
    ->name('restaurant.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [RestaurantDashboardController::class, 'index']
        );
        Route::get(

            '/page-visits',

            [RestaurantAdminPageVisitController::class,'index']

        )->name('page-visits.index');
        Route::resource('items', ItemController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('payments', RestaurantPaymentController::class);
        Route::resource('products', RestaurantProductController::class);
        Route::resource('offers', OfferController::class);
        Route::resource('banners', RestaurantBannerController::class)
        ->names('banners');
        Route::get(

            '/reviews',

            [RestaurantOrderController::class, 'reviews']

        )->name('reviews');

         Route::get('/customers', [CustomerController::class, 'index']);

        Route::get('/customers/{id}', [CustomerController::class, 'show']);
        Route::get(
            '/marketing',
            [MarketingController::class, 'index']
        )->name('marketing.index');

        Route::post(
            '/marketing/send',
            [MarketingController::class, 'send']
        )->name('marketing.send');
        Route::get(
            '/ordering',
            [CustomerController::class, 'onlineOrdering']
        )->name('ordering.index');
        Route::get(

            '/loyalty-rewards',

            [
                LoyaltyRewardController::class,

                'index'
            ]

        )->name('loyalty.index');


        Route::post(

            'restaurantloyalty-rewards/send',

            [
                LoyaltyRewardController::class,

                'send'
            ]

        )->name('loyalty.send');
        Route::post(

            '/reviews/{id}/approve',

            [RestaurantOrderController::class, 'approveReview']

        )->name('reviews.approve');


        Route::post(

            '/reviews/{id}/reject',

            [RestaurantOrderController::class, 'rejectReview']

        )->name('reviews.reject');
        Route::post(
            '/offers/{id}/featured',
            [OfferController::class, 'featured']
        )->name('offers.featured');
        Route::get(
            '/orders',
            [RestaurantOrderController::class, 'index']
        );
        Route::get(
            '/all-orders',
            [RestaurantOrderController::class, 'allOrders']
        );
        Route::get(
            '/orders/{id}',
            [RestaurantOrderController::class, 'show']
        )->name('orders.show');

        Route::post(
            '/orders/{id}/status',
            [RestaurantOrderController::class, 'updateStatus']
        )->name('orders.status');

        Route::get(
            '/profile',
            [ProfileController::class, 'index']
        );

        Route::post(
            '/profile/update',
            [ProfileController::class, 'update']
        );
        // ✅ ADD THIS
        Route::post(
            '/orders/payment-status/{id}',
            [RestaurantOrderController::class, 'updatePaymentStatus']
        )->name('orders.payment.status');

        Route::post(
            '/orders/{id}/refund',
            [RestaurantOrderController::class, 'refundPayment']
        )->name('orders.refund');

        Route::post(
            '/payment-settings',
            [RestaurantController::class, 'updatePaymentSettings']
        )->name('payment.settings.update');

        Route::get(
            '/all-payments',
            [RestaurantPaymentController::class, 'allPayments']
        );


        

        Route::post(
            '/orders/{id}/evidence',
            [RestaurantOrderController::class, 'uploadEvidence']
        )->name('orders.evidence');


        Route::post('/status/update', [ProfileController::class, 'updateStatus'])
            ->name('status.update');


        Route::resource('coupons', \App\Http\Controllers\RestaurantAdmin\CouponController::class);    



});


Route::post('/coupon/apply', [\App\Http\Controllers\RestaurantAdmin\CouponController::class, 'apply'])
    ->name('coupon.apply');

Route::middleware(['auth', 'restaurant_admin'])
    ->prefix('restaurant/products/{product}')
    ->name('restaurant.products.addons.')
    ->group(function () {

        Route::get('/addons', [ProductAddonController::class,'index'])->name('index');

        

        Route::get('/addons/create', [ProductAddonController::class,'create'])->name('create');

        Route::post('/addons', [ProductAddonController::class,'store'])->name('store');

        Route::get('/addons/{addon}/edit', [ProductAddonController::class,'edit'])->name('edit');

        Route::put('/addons/{addon}', [ProductAddonController::class,'update'])->name('update');

        Route::delete('/addons/{addon}', [ProductAddonController::class,'destroy'])->name('destroy');
       
    });
    

    Route::get(
        '/sign-in',
        [AdminLoginController::class, 'showLogin']
    );

Route::post('/admin/login',[AdminLoginController::class, 'login'])->name('admin.login');


Route::get('/cart-count', function () {

    return response()->json([
        'count' => collect(session('cart', []))->sum('quantity')
    ]);

});





Route::post('/verify-email',[UserRegisterController::class,'verifyEmailLink']);

// Route::get('/resend-otp',[UserRegisterController::class,'resendOtp']);
Route::get('/resend-otp', [UserRegisterController::class, 'resendOtp'])
    ->name('resend.otp');
// Route::get('/terms-and-conditions', function () {
//     return view('front.terms-and-conditions');
// })->name('terms.conditions');


Route::get('/terms-and-conditions', [TermsAndConditionController::class, 'termsAndConditions'])
    ->name('terms.conditions');

Route::get('/privacy-policy', [PrivacyPolicyController::class, 'privacy'])
    ->name('privacy.policy');
 
Route::get('/restaurant/policy/{slug}', [RestaurantPolicyController::class, 'policy'])
    ->name('policy');   
Route::get('/restaurant/terms/{slug}', [RestaurantTermsConditionController::class, 'restaurantTerms'])
    ->name('restaurant.terms');  

Route::get('/faqs', function () {
    return view('front.faq');
})->name('faqs');    

// Front
Route::get(
    '/restaurant/refund-policy/{slug}',
    [RestaurantRefundPolicyController::class, 'show']
)->name('restaurant.refund-policy');    

Route::get('/refund-and-cancellation-policy', function () {
    return view('front.refund-and-cancellation-policy');
})->name('refund.policy');


Route::post(
    '/restaurant/{restaurant}/favorite',
    [RestaurantController::class, 'favorite']
)->name('restaurant.favorite');


Route::middleware('auth')
    ->get(
        '/favorite-restaurants',
        [RestaurantController::class, 'favorites']
    )
    ->name('favorite.restaurants');

Route::delete(
    '/favorite-restaurant/{restaurant}',
    [RestaurantController::class,
     'removeFavorite']
)->name(
    'favorite.remove'
);

// Route::get('/login', [UsersController::class, 'showLogin']);  

Route::middleware('guest')->group(function () {

    Route::get('/login', [UsersController::class, 'showLogin'])->name('login');

    // Route::post('/login-user', [UsersController::class, 'login']);
    Route::post('/login', [UsersController::class, 'login'])->name('login.submit');

    Route::get(
        '/register',
        [UserRegisterController::class, 'showRegister']
    );

    Route::post(
        '/register-user',
        [UserRegisterController::class, 'register']
    );

    Route::get('/verify-email', function () {
        return view('auth.verify-email');
    });

});

Route::get('/forgot-password', [UsersController::class, 'showForgotPassword']);
Route::post('/forgot-password', [UsersController::class, 'forgotPassword']);  

Route::get('/reset-password', [UsersController::class,'showResetPassword'])
    ->name('password.reset')
    ->middleware('signed');

Route::post('/reset-password', [UsersController::class,'resetPassword'])
    ->name('password.update');
    
// Route::get(
//     '/restaurant/{slug}',
//     [HomeController::class, 'restaurantProducts']
// );
Route::get(
    '/restaurant/{slug}',
    [HomeController::class, 'restaurantProducts']
)->name('restaurant.products');


Route::get(
    '/restaurant/{slug}/{category}',
    [HomeController::class, 'restaurantCategoryProducts']
);

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage Link Created Successfully';
});

Route::post('/logout', function (Request $request) {
    auth()->logout();

    $request->session()->flush();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');