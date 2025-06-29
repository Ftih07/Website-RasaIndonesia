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
use App\Http\Controllers\BusinessExportController;
use Maatwebsite\Excel\Facades\Excel;

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
})->middleware('auth:testimonial')->name('home');

/**
 * Business Details Route
 * Retrieves and displays business details based on the given ID.
 */
Route::get('/business/{slug}', [BusinessController::class, 'show'])->name('business.show');

/**
 * Authenticated Routes Group
 * Requires user authentication to add testimonials to businesses.
 */
Route::middleware('auth:testimonial')->group(function () {
    Route::post('/business/{slug}/testimonials', [BusinessController::class, 'storeTestimonial'])
        ->name('business.testimonials.store');
});

/**
 * HomeController Routes
 * Uses a controller to handle the main home, show, and tokorestoran pages.
 */
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/show', [HomeController::class, 'show'])->name('show');
Route::get('/tokorestoran', [HomeController::class, 'tokorestoran'])->name('tokorestoran');

/**
 * Testimonial Authentication Routes
 * Manages registration, login, and logout for testimonial users.
 */
Route::get('/testimonial/register', [TestimonialAuthController::class, 'showRegisterForm'])
    ->name('testimonial.register');
Route::post('/testimonial/register', [TestimonialAuthController::class, 'register']);
Route::get('/testimonial/login', [TestimonialAuthController::class, 'showLoginForm'])
    ->name('testimonial.login');
Route::post('/testimonial/login', [TestimonialAuthController::class, 'login']);
Route::post('/testimonial/logout', [TestimonialAuthController::class, 'logout'])
    ->name('testimonial.logout');

/**
 * Testimonial Profile Routes
 * Allows testimonial users to edit and update their profiles.
 */
Route::get('/profile/edit', [TestimonialAuthController::class, 'editProfile'])
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
