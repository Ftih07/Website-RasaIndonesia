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
