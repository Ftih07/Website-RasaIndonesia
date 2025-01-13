<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/tokorestoran', function () {
    return view('tokorestoran');
});

Route::get('/show', function () {
    return view('show');
});