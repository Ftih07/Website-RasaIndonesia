<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlacesController extends Controller
{
    //
    public function getNearbyPlaces(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $apiKey = env('GOOGLE_API_KEY');
        $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json";

        $response = Http::get($url, [
            'location' => "$latitude,$longitude",
            'radius' => 5000,
            'type' => 'restaurant',
            'key' => $apiKey,
        ]);

        return $response->json();
    }
}
