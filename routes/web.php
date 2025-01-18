<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BusinessController;

Route::get('/', function () {
    return view('home');
});

Route::get('/tokorestoran', function () {
    return view('tokorestoran');
});

Route::get('/show', function () {
    return view('show');
});

Route::get('/', [HomeController::class, 'home'])->name('home'); //Multicore
Route::get('/show', [HomeController::class, 'show'])->name('show'); //Multicore
Route::get('/tokorestoran', [HomeController::class, 'tokorestoran'])->name('tokorestoran'); //Multicore

Route::get('/business/{id}', [BusinessController::class, 'show'])->name('business.show');