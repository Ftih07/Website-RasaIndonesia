<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\TestimonialAuthController;

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
Route::get('/business/{id}', [BusinessController::class, 'show'])->name('business.show');

/**
 * Authenticated Routes Group
 * Requires user authentication to add testimonials to businesses.
 */
Route::middleware('auth')->group(function () {
    Route::post('/business/add-testimonial', [BusinessController::class, 'storeTestimonial'])
        ->name('business.testimonials.store');
});

/**
 * Testimonial-Specific Auth Routes
 * Allows authenticated testimonial users to submit testimonials.
 */
Route::middleware('auth:testimonial')->group(function () {
    Route::post('/business/testimonials', [BusinessController::class, 'storeTestimonial'])
        ->name('business.testimonials.store');
});

/**
 * HomeController Routes
 * Uses a controller to handle the main home, show, and tokorestoran pages.
 */
Route::get('/', [HomeController::class, 'home'])->name('home'); // Multicore
Route::get('/show', [HomeController::class, 'show'])->name('show'); // Multicore
Route::get('/tokorestoran', [HomeController::class, 'tokorestoran'])->name('tokorestoran'); // Multicore

/**
 * Business Routes
 * Handles business-related functionalities such as displaying details.
 */
Route::get('/business/{id}', [BusinessController::class, 'show'])->name('business.show');

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