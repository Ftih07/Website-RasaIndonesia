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

        // Ambil 3 bisnis lain dengan tipe yang sama (kalau difilter), dan bukan yang sedang ditampilkan
        $otherBusinesses = Business::with('type')
            ->when($typeFilter !== 'all', function ($query) use ($typeFilter) {
                $query->whereHas('type', function ($q) use ($typeFilter) {
                    $q->where('title', $typeFilter);
                });
            })
            ->where('id', '!=', $business->id)
            ->whereNotNull('slug') // Tambahan agar tidak error jika slug null
            ->inRandomOrder() // Menambahkan pengurutan acak
            ->take(3)
            ->get();

        // Ambil testimoni berdasarkan filter rating & urutan
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
        // Ambil business berdasarkan slug, termasuk relasi products
        $business = Business::with('products')->where('slug', $slug)->firstOrFail();

        // Ambil semua menu dari relasi products
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
