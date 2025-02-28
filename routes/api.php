<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * User Route
 * Returns the authenticated user data.
 * This route is protected by 'auth:sanctum' middleware.
 */
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Nearby Businesses Route (Manual Query)
 * Retrieves businesses near the given latitude and longitude.
 * If no coordinates are provided, it returns all businesses with location data.
 */
Route::get('/nearby-businesses', function (Request $request) {
    $latitude = $request->query('lat'); // Get latitude from query params
    $longitude = $request->query('lng'); // Get longitude from query params

    if ($latitude && $longitude) {
        // Query to find businesses within a 10km radius
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
        // Return all businesses with valid latitude & longitude
        $businesses = DB::table('businesses')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->toArray();
    }

    return response()->json($businesses);
});

/**
 * Nearby Businesses Route (Controller-Based)
 * Uses HomeController to handle the logic for retrieving nearby businesses.
 */
Route::get('/nearby-businesses', [HomeController::class, 'getNearbyBusinesses']);
