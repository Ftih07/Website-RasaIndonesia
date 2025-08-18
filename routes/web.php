<?php

use App\Http\Controllers\Api\ReviewScrapperController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\QrLinkDownloadController;
use App\Http\Controllers\TestimonialAuthController;
use App\Exports\BusinessesExport;
use App\Http\Controllers\BusinessClaimController;
use App\Http\Controllers\BusinessExportController;
use App\Http\Controllers\DashboardController;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\DashboardBusinessController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Dashboard\TestimonialController;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware(['auth', CheckRole::class . ':admin,superadmin'])->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'));
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'token.expired', 'check.role:seller'])->name('dashboard');
Route::put('/dashboard', [DashboardController::class, 'update'])->middleware(['auth', 'token.expired', 'check.role:seller'])->name('dashboard.update');

Route::get('/dashboard/business', [DashboardBusinessController::class, 'index'])
    ->middleware(['auth', 'token.expired', 'check.role:seller'])
    ->name('dashboard.business');

Route::put('/dashboard/business', [DashboardBusinessController::class, 'update'])
    ->middleware(['auth', 'token.expired', 'check.role:seller'])
    ->name('dashboard.business.update');

Route::delete('/dashboard', [BusinessController::class, 'destroy'])->name('dashboard.destroy');

Route::prefix('/dashboard')->middleware(['auth', 'token.expired', 'check.role:seller'])->group(function () {
    Route::get('/product', [\App\Http\Controllers\ProductDashboardController::class, 'index'])->name('dashboard.product');
    Route::post('/product', [\App\Http\Controllers\ProductDashboardController::class, 'store'])->name('dashboard.product.store');
    Route::delete('/product/{id}', [\App\Http\Controllers\ProductDashboardController::class, 'destroy'])->name('dashboard.product.destroy');
    Route::get('/dashboard/product/{id}/edit', [\App\Http\Controllers\ProductDashboardController::class, 'edit'])->name('dashboard.product.edit');
    Route::put('/dashboard/product/{id}', [\App\Http\Controllers\ProductDashboardController::class, 'update'])->name('dashboard.product.update');
    Route::post('/dashboard/product/toggle-sell', [\App\Http\Controllers\ProductDashboardController::class, 'toggleSell'])->name('dashboard.product.toggle-sell');

    // Option Groups
    Route::post('/product/option-group', [\App\Http\Controllers\ProductDashboardController::class, 'storeOptionGroup'])->name('dashboard.product.optionGroup.store');
    Route::delete('/product/option-group/{id}', [\App\Http\Controllers\ProductDashboardController::class, 'destroyOptionGroup'])->name('dashboard.product.optionGroup.destroy');
    Route::put('/product/option-group/{id}', [\App\Http\Controllers\ProductDashboardController::class, 'updateOptionGroup'])->name('dashboard.product.optionGroup.update');

    // Categories
    Route::post('/product/category', [\App\Http\Controllers\ProductDashboardController::class, 'storeCategory'])->name('dashboard.product.category.store');
    Route::delete('/product/category/{id}', [\App\Http\Controllers\ProductDashboardController::class, 'destroyCategory'])->name('dashboard.product.category.destroy');
    Route::put('/product/category/{id}', [\App\Http\Controllers\ProductDashboardController::class, 'updateCategory'])->name('dashboard.product.category.update');

    Route::get('/orders', [\App\Http\Controllers\OrderDashboardController::class, 'index'])->name('dashboard.orders');
    Route::get('/orders/{id}', [\App\Http\Controllers\OrderDashboardController::class, 'show'])
        ->name('dashboard.orders.show');

    // Tambahan untuk shipping
    Route::get('/dashboard/orders/shipping', [\App\Http\Controllers\OrderDashboardController::class, 'shipping'])
        ->name('dashboard.orders.shipping');
    Route::patch('/dashboard/orders/shipping', [\App\Http\Controllers\OrderDashboardController::class, 'updateShipping'])
        ->name('dashboard.orders.shipping.update');
        
    Route::post('/orders/request', [\App\Http\Controllers\OrderDashboardController::class, 'requestActivation'])->name('dashboard.orders.request');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\OrderDashboardController::class, 'updateStatus'])->name('dashboard.orders.updateStatus');
    Route::patch('/orders/{order}/approve', [\App\Http\Controllers\OrderDashboardController::class, 'approve'])->name('dashboard.orders.approve');
    Route::patch('/orders/{order}/reject', [\App\Http\Controllers\OrderDashboardController::class, 'reject'])->name('dashboard.orders.reject');
});

Route::middleware(['auth', 'check.role:seller'])->group(function () {
    Route::get('/dashboard/testimonial', [\App\Http\Controllers\Dashboard\TestimonialController::class, 'index'])->name('dashboard.testimonial');
    Route::post('/dashboard/testimonial/{testimonial}/reply', [\App\Http\Controllers\Dashboard\TestimonialController::class, 'reply'])->name('dashboard.testimonial.reply');
    Route::post('/dashboard/testimonial/{testimonial}/like', [\App\Http\Controllers\Dashboard\TestimonialController::class, 'like'])->name('dashboard.testimonial.like');
});

// Untuk Partner
Route::prefix('partner')->name('partner.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [\App\Http\Controllers\Partner\AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [\App\Http\Controllers\Partner\AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth', 'check.role:partner'])->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Partner\AuthController::class, 'logout'])->name('logout');
        Route::get('/orders', [\App\Http\Controllers\Partner\OrderController::class, 'index'])->name('orders.index');
    });
});

// routes/web.php
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderTrackingController;

Route::middleware(['auth'])->group(function () {
    // pisah middleware per role sesuai maumu
    Route::get('/chat/customer', [ChatController::class, 'customerIndex'])
        ->middleware('check.role:customer')
        ->name('chat.customer');

    Route::get('/chat/seller', [ChatController::class, 'sellerIndex'])
        ->middleware('check.role:seller')
        ->name('chat.seller');

    Route::post('/chat/{chat}/send', [ChatController::class, 'send'])
        ->name('chat.send'); // <- ini yang bikin error kemarin
});

Route::middleware(['auth', 'check.role:partner'])->group(function () {
    Route::get('/chat/partner', [ChatController::class, 'partnerIndex'])
        ->name('chat.partner');
});


// Untuk customer
Route::middleware(['auth', 'check.role:customer'])->group(function () {
    Route::post('/testimonial/{testimonial}/like', [TestimonialController::class, 'like'])->name('testimonial.like');
    Route::put('/testimonial/{testimonial}', [TestimonialController::class, 'update'])->name('testimonial.update');
    Route::delete('/testimonial/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');
    Route::post('/business/{slug}/testimonials', [TestimonialController::class, 'store'])->name('testimonial.store');
});

Route::post('/partner/orders/review', [OrderTrackingController::class, 'storeReview'])
    ->name('partner.orders.review.store');

Route::middleware(['auth', 'check.role:customer'])->group(function () {
    Route::get('/register-business', [BusinessController::class, 'create'])->name('business.register');
    Route::post('/register-business', [BusinessController::class, 'store'])->name('business.register.store');

    Route::get('/claim-business', [BusinessClaimController::class, 'create'])->name('business.claim');
    Route::post('/claim-business', [BusinessClaimController::class, 'store'])->name('business.claim.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
});


// Import the controller class that will handle these routes.
// This line ensures that Laravel knows where to find the `ProsperityExpoRegistrationController`.
use App\Http\Controllers\ProsperityExpoRegistrationController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/**
 * Static Page Routes
 * These routes return views without any controller logic.
 */
Route::get('/tokorestoran', function () {
    return view('tokorestoran');
});

Route::get('/show', function () {
    return view('show');
});

/**
 * Home Route
 * This route requires 'auth:testimonial' middleware for authentication.
 */
Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');

/**
 * Business Details Route
 * Retrieves and displays business details based on the given ID.
 */
Route::get('/business/{slug}', [BusinessController::class, 'show'])->name('business.show');

/*******************************************************************************************************************/

/**
 * HomeController Routes
 * Uses a controller to handle the main home, show, and tokorestoran pages.
 */
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/show', [HomeController::class, 'show'])->name('show');
Route::get('/store-and-restaurant', [HomeController::class, 'storeandrestaurant'])->name('tokorestoran');

/**
 * Testimonial Authentication Routes
 * Manages registration, login, and logout for testimonial users.
 */
Route::get('/testimonial/register', [TestimonialAuthController::class, 'showRegisterForm'])
    ->name('testimonial.register');
Route::post('/testimonial/register', [TestimonialAuthController::class, 'register']);
Route::get('/testimonial/login', [TestimonialAuthController::class, 'showLoginForm'])
    ->name('testimonial.login');

Route::post('/testimonial/login', [TestimonialAuthController::class, 'login'])
    ->middleware('login.throttle');

Route::post('/testimonial/logout', [TestimonialAuthController::class, 'logout'])
    ->name('testimonial.logout');

/**
 * Testimonial Profile Routes
 * Allows testimonial users to edit and update their profiles.
 */
Route::get('/profile/edit', [TestimonialAuthController::class, 'editProfile'])
    ->middleware('check.role:customer,seller,superadmin')
    ->name('testimonial.profile.edit');

Route::post('/profile/update', [TestimonialAuthController::class, 'updateProfile'])
    ->name('testimonial.profile.update');


Route::get('/news', [NewsController::class, 'index'])->name('news.index');

/**
 * News Read More Route
 * Retrieves and displays news details based on the given ID.
 */
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
/**
 * News Read More Route
 * Retrieves and displays news details based on the given ID.
 */
Route::get('/events/{slug}', [EventsController::class, 'show'])->name('events.show');

Route::get('/business/{slug}/menu', [BusinessController::class, 'menu'])->name('business.menu');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'getCart'])->name('cart.get'); // Ambil data cart
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add'); // Tambah item

    // Gunakan {rowId} untuk update, remove, dan getCartItem
    Route::post('/cart/update/{rowId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/item/{rowId}', [CartController::class, 'getCartItem'])->name('cart.item');
});

Route::middleware(['auth', 'check.role:customer,seller,superadmin'])->group(function () {
    Route::get('/cart/validate/{business}', [CartController::class, 'validateCart'])->name('cart.validate');
    Route::get('/checkout/{business}', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout/process', [CheckoutController::class, 'checkout'])->name('checkout.process');

    Route::post('/shipping/calculate', [CheckoutController::class, 'calculateShipping'])->name('shipping.calculate');
});
Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('order.success');

Route::get('/stripe/success', [CheckoutController::class, 'stripeSuccess'])->name('stripe.success');
Route::get('/stripe/cancel', [CheckoutController::class, 'stripeCancel'])->name('stripe.cancel');

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderTrackingController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/tracking', [OrderTrackingController::class, 'tracking'])->name('orders.tracking');
});

Route::get('/qr-download/{id}', [QrLinkDownloadController::class, 'download'])->name('qr.download');

// ReviewScrapper JSON download routes
Route::get('/review-scrapper/{reviewScrapper}/download', [ReviewScrapperController::class, 'downloadJson'])
    ->name('api.review-scrapper.download');

Route::post('/review-scrapper/download-multiple', [ReviewScrapperController::class, 'downloadMultipleJson'])
    ->name('api.review-scrapper.download-multiple');

Route::get('/export-businesses', function () {
    return Excel::download(new BusinessesExport, 'businesses.xlsx');
})->name('export-businesses');

Route::get('/export-business-pdf/{id}', [BusinessExportController::class, 'exportSinglePdf'])
    ->name('export-business.pdf.single');

Route::get('businesses/export-all-pdf', [BusinessExportController::class, 'exportAllPdf'])
    ->name('export-all-businesses-pdf');

// Define a GET route for displaying the registration form.
// When a user visits the URL '/prosperity-expo' using a GET request (e.g., by typing it in the browser),
// Laravel will call the `create` method in the `ProsperityExpoRegistrationController`.
// The `->name('prosperity-expo.create')` assigns a unique name to this route,
// which makes it easier to generate URLs in your application (e.g., using `route('prosperity-expo.create')`).
Route::get('/prosperity-expo', [ProsperityExpoRegistrationController::class, 'create'])->name('prosperity-expo.create');

// Define a POST route for handling the submission of the registration form.
// When a user fills out the registration form and submits it, the form data is sent
// via a POST request to the URL '/prosperity-expo'.
// Laravel will then call the `store` method in the `ProsperityExpoRegistrationController`
// to process and save the submitted data.
// This route is also given a name for easy URL generation.
Route::post('/prosperity-expo', [ProsperityExpoRegistrationController::class, 'store'])->name('prosperity-expo.store');

// Define a GET route for the thank you page after successful registration.
// This route includes a wildcard segment '{qr_code}' in the URL, meaning it expects a unique QR code
// value to be passed. For example, '/prosperity-expo/thank-you/some-unique-qr-code'.
// Laravel will call the `thankYou` method in the `ProsperityExpoRegistrationController`,
// passing the value of '{qr_code}' as an argument to that method.
// This route is named 'prosperity-expo.thankyou'.
Route::get('/prosperity-expo/thank-you/{qr_code}', [ProsperityExpoRegistrationController::class, 'thankYou'])->name('prosperity-expo.thankyou');

// Define a GET route for downloading the registration confirmation PDF.
// Similar to the thank you page, this route also expects a '{qr_code}' in the URL.
// When a user accesses this URL (e.g., '/prosperity-expo/download/another-unique-qr-code'),
// Laravel will execute the `downloadPdf` method in the `ProsperityExpoRegistrationController`,
// passing the QR code value. This method will then handle serving the PDF file for download.
// This route is named 'prosperity-expo.download'.
Route::get('/prosperity-expo/download/{qr_code}', [ProsperityExpoRegistrationController::class, 'downloadPdf'])->name('prosperity-expo.download');
