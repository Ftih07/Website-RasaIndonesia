<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\TestimonialAuthController;

Route::get('/tokorestoran', function () {
    return view('tokorestoran');
});

Route::get('/show', function () {
    return view('show');
});

Route::get('/', function () {
    return view('home');
})->middleware('auth:testimonial')->name('home');

Route::get('/business/{id}', [BusinessController::class, 'show'])->name('business.show');

Route::middleware('auth')->group(function () {
    Route::post('/business/add-testimonial', [BusinessController::class, 'storeTestimonial'])->name('business.testimonials.store');
});

Route::middleware('auth:testimonial')->group(function () {
    Route::post('/business/testimonials', [BusinessController::class, 'storeTestimonial'])->name('business.testimonials.store');
});


Route::get('/', [HomeController::class, 'home'])->name('home'); //Multicore
Route::get('/show', [HomeController::class, 'show'])->name('show'); //Multicore
Route::get('/tokorestoran', [HomeController::class, 'tokorestoran'])->name('tokorestoran'); //Multicore

Route::get('/business/{id}', [BusinessController::class, 'show'])->name('business.show');

// Testimonial Auth
Route::get('/testimonial/register', [TestimonialAuthController::class, 'showRegisterForm'])->name('testimonial.register');
Route::post('/testimonial/register', [TestimonialAuthController::class, 'register']);
Route::get('/testimonial/login', [TestimonialAuthController::class, 'showLoginForm'])->name('testimonial.login');
Route::post('/testimonial/login', [TestimonialAuthController::class, 'login']);
Route::post('/testimonial/logout', [TestimonialAuthController::class, 'logout'])->name('testimonial.logout');

Route::get('/profile/edit', [TestimonialAuthController::class, 'editProfile'])->name('testimonial.profile.edit');
Route::post('/profile/update', [TestimonialAuthController::class, 'updateProfile'])->name('testimonial.profile.update');
