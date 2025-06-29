<?php

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Import the API controller class that will handle this route.
// This line ensures that Laravel knows where to find the `EventCheckInController`.
use App\Http\Controllers\Api\EventCheckInController;

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

// Define a GET route for the event check-in API.
// This route is designed to be an API endpoint, typically used by a scanner or another system
// to check in participants using their unique QR code.
//
// - URL: '/check-in/{qrCode}'
//   - '/check-in': The base path for the check-in functionality.
//   - '{qrCode}': A wildcard segment. This means any value placed here in the URL
//     will be captured and passed as an argument to the controller method.
//     For example, if the URL is '/check-in/a1b2c3d4-e5f6-7890-1234-567890abcdef',
//     'a1b2c3d4-e5f6-7890-1234-567890abcdef' will be passed as the `$qrCode` parameter.
//
// - Controller Action: `[EventCheckInController::class, 'check']`
//   - This tells Laravel to call the `check` method within the `EventCheckInController` class
//     when this route is accessed. The `$qrCode` value from the URL will be automatically
//     injected into the `check` method as an argument.
Route::get('/check-in/{qrCode}', [EventCheckInController::class, 'check']);
