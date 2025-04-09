<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Events;
use App\Models\FoodCategory;
use App\Models\Gallery;
use App\Models\News;
use App\Models\QnA;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    // Display the 'show' view
    public function show()
    {
        return view('show');
    }

    // Display the home page with filtered businesses
    public function home(Request $request)
    {
        $galleries = Gallery::all();
        $qna = QnA::all();
        $types = Type::all();

        // Get type filter from request (default: 'all')
        $typeFilter = $request->get('type', 'all');

        // Query businesses based on type filter
        $businesses = Business::with('testimonials', 'type')
            ->when($typeFilter !== 'all', function ($query) use ($typeFilter) {
                $query->whereHas('type', function ($q) use ($typeFilter) {
                    $q->where('title', $typeFilter);
                });
            })
            ->take(6)
            ->get();

        // Calculate the average rating for each business
        foreach ($businesses as $business) {
            $business->average_rating = $business->testimonials->avg('rating') ?? 0;
        }

        $events = Events::where('end_time', '>', Carbon::now('Australia/Melbourne'))->get();
        $news = News::where('status', 'published')->latest()->take(6)->get(); // ambil 6 news terbaru

        return view('home', compact('galleries', 'qna', 'businesses', 'types', 'typeFilter', 'events', 'news'));
    }

    // Get nearby businesses based on latitude and longitude
    public function getNearbyBusinesses(Request $request)
    {
        // Retrieve latitude and longitude from query parameters
        $latitude = $request->query('lat');
        $longitude = $request->query('lng');

        // Initialize query with related models
        $query = Business::with(['type', 'testimonials', 'galleries']);

        // If latitude and longitude are provided, calculate distance
        if ($latitude && $longitude) {
            $query->selectRaw("
                *, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) 
                * cos(radians(longitude) - radians(?)) + sin(radians(?)) 
                * sin(radians(latitude)))) AS distance", [$latitude, $longitude, $latitude])
                ->having('distance', '<', 10) // Filter businesses within a 10 km radius
                ->orderBy('distance'); // Order results by distance (nearest first)
        }

        // Retrieve businesses and format response
        $businesses = $query->get()->map(function ($business) {
            return [
                'id' => $business->id,
                'name' => $business->name,
                'latitude' => $business->latitude,
                'longitude' => $business->longitude,
                'type' => [
                    'id' => optional($business->type)->id,
                    'title' => optional($business->type)->title ?? 'N/A', // Handle missing type
                ],
                'average_rating' => round($business->testimonials->avg('rating') ?? 0, 1), // Calculate average rating
                'total_responses' => $business->testimonials->count(), // Count total testimonials
                'galleries' => $business->galleries->map(function ($gallery) {
                    return [
                        'title' => $gallery->title,
                        'image' => asset('storage/' . $gallery->image), // Convert image path to URL
                    ];
                }),
            ];
        });

        // Return JSON response with business data
        return response()->json($businesses);
    }

    // Display businesses filtered by category, type, and keyword search
    public function tokorestoran(Request $request)
    {
        $query = Business::with('testimonials', 'food_categories', 'type');

        // Filter by food category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('food_categories', function ($q) use ($request) {
                $q->where('title', $request->category);
            });
        }

        // Filter by business type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->whereHas('type', function ($q) use ($request) {
                $q->where('title', $request->type);
            });
        }

        // Search by name
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Sort businesess
        if ($request->filled('sort')) {
            $order = $request->sort === 'oldest' ? 'asc' : 'desc';
            $query->orderBy('created_at', $order);
        }

        $businesses = $query->get();

        // Calculate average rating for each business
        foreach ($businesses as $business) {
            $business->average_rating = $business->testimonials->avg('rating') ?? 0;
        }

        // Get food categories and business types for dropdowns
        $foodCategories = FoodCategory::all();
        $businessTypes = Type::all();

        return view('tokorestoran', compact('businesses', 'foodCategories', 'businessTypes'));
    }
}
