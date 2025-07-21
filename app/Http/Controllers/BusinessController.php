<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Testimonial;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\NotificationHelper; // tambahkan di atas

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
                if ($typeFilter === 'null') {
                    $query->whereNull('type_id');
                } else {
                    $query->whereHas('type', function ($q) use ($typeFilter) {
                        $q->where('title', $typeFilter);
                    });
                }
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


    public function create()
    {
        $types = Type::all();
        return view('business.register', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
            'description' => 'nullable|string',
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'location' => 'nullable|string',
        ]);


        $logoPath = $request->hasFile('logo')
            ? $request->file('logo')->store('logos', 'public')
            : null;

        Business::create([
            'user_id' => auth()->id(),
            'type_id' => $request->type_id, // ⬅️ ini penting agar relasinya tersimpan
            'name' => $request->name,
            'description' => $request->description,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'location' => $request->location,
            'is_verified' => false,
        ]);

        NotificationHelper::send(
            auth()->id(),
            'Bisnismu sedang menunggu verifikasi',
            'Tim kami akan memverifikasi bisnismu dalam waktu dekat.',
            route('dashboard') // Ganti dengan route seller kamu
        );

        return redirect()->route('home')->with('success', 'Business submitted for verification!');
    }

    public function destroy()
    {
        $business = auth()->user()->business;

        if (!$business) {
            return redirect()->back()->with('error', 'You don\'t have a business to delete.');
        }

        $business->delete(); // Akan trigger BusinessObserver

        return redirect()->route('home')->with('success', 'Your business has been deleted.');
    }
}
