<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/nearby-businesses', function (Request $request) {
    $latitude = $request->query('lat');
    $longitude = $request->query('lng');

    if ($latitude && $longitude) {
        $businesses = DB::select("
            SELECT *, 
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) 
            * cos(radians(longitude) - radians(?)) + sin(radians(?)) 
            * sin(radians(latitude)))) AS distance 
            FROM businesses 
            HAVING distance < 10 
            ORDER BY distance 
            LIMIT 10;
        ", [$latitude, $longitude, $latitude]);
    } else {
        $businesses = DB::table('businesses')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();
    }

    return response()->json($businesses);
});

Route::get('/nearby-businesses', [HomeController::class, 'getNearbyBusinesses']);
