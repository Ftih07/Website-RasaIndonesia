<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Testimonial;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    /**
     * Display business details, type, and testimonials.
     */
    public function show($slug, Request $request)
    {
        // Ambil business berdasarkan slug + relasi
        $business = Business::with(['type', 'testimonials.testimonial_user', 'food_categories', 'products'])
            ->where('slug', $slug)
            ->firstOrFail();

        $types = Type::all();
        $typeFilter = $request->get('type', 'all');

        // Retrieve 3 other businesses of the same type (if filtered), and not the one currently displayed
        $otherBusinesses = Business::with('type')
            ->when($typeFilter !== 'all', function ($query) use ($typeFilter) {
                $query->whereHas('type', function ($q) use ($typeFilter) {
                    $q->where('title', $typeFilter);
                });
            })
            ->where('id', '!=', $business->id)
            ->whereNotNull('slug')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Retrieve testimonials based on rating & order filters
        $ratingFilter = $request->get('rating');
        $sortOrder = $request->get('order', 'newest');

        $testimonialsQuery = Testimonial::where('business_id', $business->id);

        if ($ratingFilter) {
            $testimonialsQuery->where('rating', $ratingFilter);
        }

        $testimonials = $testimonialsQuery
            ->orderBy('created_at', $sortOrder === 'newest' ? 'desc' : 'asc')
            ->get();

        $latestMenus = $business->products()->latest()->take(6)->get();

        return view('business.show', compact(
            'business',
            'types',
            'otherBusinesses',
            'typeFilter',
            'testimonials',
            'ratingFilter',
            'sortOrder',
            'latestMenus'
        ));
    }


    public function menu($slug)
    {
        // Get business by slug, including product relationships
        $business = Business::with('products')->where('slug', $slug)->firstOrFail();

        // Retrieve all menus from the products relation
        $menus = $business->products()->latest()->get();

        return view('business.menu', compact('business', 'menus'));
    }

    /**
     * Store a new testimonial in the database.
     */
    public function storeTestimonial(Request $request, $slug)
    {
        if (!auth('testimonial')->check()) {
            return redirect()->route('testimonial.login');
        }

        $business = Business::where('slug', $slug)->firstOrFail();

        $request->validate([
            'description' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'business_id' => $business->id,
            'testimonial_user_id' => auth('testimonial')->id(),
            'name' => auth('testimonial')->user()->username,
            'description' => $request->description,
            'rating' => $request->rating,
        ]);

        return redirect()->route('business.show', ['slug' => $slug])
            ->with('success', 'Testimonial added successfully!');
    }
}
