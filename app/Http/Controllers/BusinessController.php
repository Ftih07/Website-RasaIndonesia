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
    public function show($id, Request $request)
    {
        // Retrieve business data along with related type, testimonials, and food categories
        $business = Business::with(['type', 'testimonials.testimonial_user', 'food_categories'])->findOrFail($id);

        // Fetch all types for filtering
        $types = Type::all();

        // Get type filter from request (default to 'all' if not provided)
        $typeFilter = $request->get('type', 'all');

        // Query other businesses based on type filter
        $otherBusinesses = Business::with('type')
            ->when($typeFilter !== 'all', function ($query) use ($typeFilter) {
                $query->whereHas('type', function ($q) use ($typeFilter) {
                    $q->where('title', $typeFilter);
                });
            })
            ->where('id', '!=', $id) // Exclude the current business from results
            ->take(3) // Limit results to 3 businesses
            ->get();


        // Retrieve filter parameters
        $ratingFilter = $request->get('rating'); // Rating filter
        $sortOrder = $request->get('order', 'newest'); // Sorting order (default to 'newest')

        // Query testimonials with filters
        $testimonialsQuery = Testimonial::where('business_id', $id);

        if ($ratingFilter) {
            $testimonialsQuery->where('rating', $ratingFilter);
        }

        if ($sortOrder === 'newest') {
            $testimonialsQuery->orderBy('created_at', 'desc');
        } else {
            $testimonialsQuery->orderBy('created_at', 'asc');
        }

        $testimonials = $testimonialsQuery->get();

        $latestMenus = $business->products()->latest()->take(6)->get();

        // Pass data to the view
        return view('business.show', compact('business', 'types', 'otherBusinesses', 'typeFilter', 'testimonials', 'ratingFilter', 'sortOrder', 'latestMenus'));
    }

    public function menu($id)
    {
        $business = Business::with('products')->findOrFail($id);
        $menus = $business->products()->latest()->get();

        return view('business.menu', compact('business', 'menus'));
    }

    /**
     * Display the form for adding a testimonial.
     */
    public function createTestimonial(Request $request)
    {
        // Retrieve business ID from URL request
        $businessId = $request->get('business_id');

        return view('testimonials.create', compact('businessId'));
    }

    /**
     * Store a new testimonial in the database.
     */
    public function storeTestimonial(Request $request)
    {
        // Ensure the user is authenticated as a testimonial user
        if (!auth('testimonial')->check()) {
            return redirect()->route('testimonial.login');
        }

        // Validate input fields
        $request->validate([
            'description' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
            'business_id' => 'required|exists:businesses,id',
        ]);

        // Create a new testimonial record
        Testimonial::create([
            'business_id' => $request->business_id,
            'testimonial_user_id' => auth('testimonial')->id(),
            'name' => auth('testimonial')->user()->username,
            'description' => $request->description,
            'rating' => $request->rating,
        ]);

        // Redirect back to business details with a success message
        return redirect()->route('business.show', ['id' => $request->business_id])
            ->with('success', 'Testimonial added successfully!');
    }
}
