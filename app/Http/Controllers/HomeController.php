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

        // Ambil yang approved dulu (acak)
        $approvedBusinesses = Business::with('testimonials', 'type')
            ->when($typeFilter !== 'all', function ($query) use ($typeFilter) {
                $query->whereHas('type', function ($q) use ($typeFilter) {
                    $q->where('title', $typeFilter);
                });
            })
            ->where('orders_status', 'approved')
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Kalau kurang dari 6, ambil sisanya dari yang lain (acak)
        if ($approvedBusinesses->count() < 6) {
            $remaining = 6 - $approvedBusinesses->count();

            $otherBusinesses = Business::with('testimonials', 'type')
                ->when($typeFilter !== 'all', function ($query) use ($typeFilter) {
                    $query->whereHas('type', function ($q) use ($typeFilter) {
                        $q->where('title', $typeFilter);
                    });
                })
                ->where('orders_status', '!=', 'approved')
                ->inRandomOrder()
                ->take($remaining)
                ->get();

            // gabungkan hasilnya
            $businesses = $approvedBusinesses->concat($otherBusinesses);
        } else {
            $businesses = $approvedBusinesses;
        }

        // Hitung rata-rata rating untuk masing-masing bisnis
        foreach ($businesses as $business) {
            $business->average_rating = $business->testimonials->avg('rating') ?? 0;
        }

        $events = Events::where('end_time', '>', Carbon::now('Australia/Melbourne'))->get();
        $news   = News::where('status', 'published')->latest()->take(6)->get();

        return view('home', compact('galleries', 'qna', 'businesses', 'types', 'typeFilter', 'events', 'news'));
    }

    // Get nearby businesses based on latitude and longitude
    public function getNearbyBusinesses(Request $request)
    {
        $latitude = $request->query('lat');
        $longitude = $request->query('lng');
        $radius = $request->query('radius', 10); // default 10 km

        $query = Business::with(['type', 'testimonials', 'galleries']);

        // Jika ada lat/lng, filter berdasarkan jarak
        if ($latitude && $longitude) {
            $query->selectRaw("
            *, (6371 * acos(
                cos(radians(?)) * cos(radians(latitude)) 
                * cos(radians(longitude) - radians(?)) 
                + sin(radians(?)) * sin(radians(latitude))
            )) AS distance", [$latitude, $longitude, $latitude])
                ->having('distance', '<', $radius) // radius dalam KM
                ->orderBy('distance');
        }

        // Kalau tidak ada lat/lng → ambil semua bisnis (tanpa filter jarak)
        $businesses = $query->get()->map(function ($business) {
            return [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'latitude' => $business->latitude,
                'longitude' => $business->longitude,
                'type' => [
                    'id' => optional($business->type)->id,
                    'title' => optional($business->type)->title ?? 'N/A',
                ],
                'average_rating' => round($business->testimonials->avg('rating') ?? 0, 1),
                'total_responses' => $business->testimonials->count(),
                'orders_status' => $business->orders_status, // << tambahkan ini
                'galleries' => $business->galleries->map(fn($gallery) => [
                    'title' => $gallery->title,
                    'image' => asset('storage/' . $gallery->image),
                ]),
            ];
        });

        return response()->json($businesses);
    }

    // Display businesses filtered by category, type, keyword, country, and city
    public function storeandrestaurant(Request $request)
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

        // Filter by country
        if ($request->filled('country') && $request->country !== 'all') {
            $query->where('country', $request->country);
        }

        // Filter by city
        if ($request->filled('city') && $request->city !== 'all') {
            $query->where('city', $request->city);
        }

        // 🔹 Filter by orders_status
        if ($request->filled('orders_status') && $request->orders_status !== 'all') {
            // misalnya approved / not_approved
            $query->where('orders_status', $request->orders_status);
        }

        // Search by name
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Sort businesses
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

        // Get unique countries and cities for filters
        $countries = Business::select('country')->distinct()->pluck('country')->filter()->sort()->values();
        $cities = Business::select('city')->distinct()->pluck('city')->filter()->sort()->values();

        return view('store-and-restaurant', compact(
            'businesses',
            'foodCategories',
            'businessTypes',
            'countries',
            'cities'
        ));
    }
}
