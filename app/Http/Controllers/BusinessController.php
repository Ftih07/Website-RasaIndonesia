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
     * Menampilkan detail bisnis, tipe, dan testimonial
     */
    public function show($id, Request $request)
    {
        $business = Business::with(['type', 'testimonials.testimonial_user', 'food_categories'])->findOrFail($id);

        // Ambil semua tipe untuk filter
        $types = Type::all();

        // Ambil filter tipe dari request (default 'all' jika tidak ada filter)
        $typeFilter = $request->get('type', 'all');

        // Query bisnis lain dengan filter tipe
        $otherBusinesses = Business::with('type')
            ->when($typeFilter !== 'all', function ($query) use ($typeFilter) {
                $query->whereHas('type', function ($q) use ($typeFilter) {
                    $q->where('title', $typeFilter);
                });
            })
            ->where('id', '!=', $id) // Jangan tampilkan bisnis yang sedang dilihat
            ->take(3)                               // Ambil 3 data lainnya
            ->get();


        // Ambil parameter filter
        $ratingFilter = $request->get('rating'); // Filter rating
        $sortOrder = $request->get('order', 'newest'); // Urutan (default 'newest')

        // Query testimonials dengan filter
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

        // Kirim data ke view
        return view('business.show', compact('business', 'types', 'otherBusinesses', 'typeFilter', 'testimonials', 'ratingFilter', 'sortOrder'));
    }

    /**
     * Menampilkan form tambah testimonial
     */
    public function createTestimonial(Request $request)
    {
        $businessId = $request->get('business_id'); // Ambil ID bisnis dari URL

        return view('testimonials.create', compact('businessId'));
    }

    /**
     * Menyimpan testimonial ke database
     */
    public function storeTestimonial(Request $request)
    {
        if (!auth('testimonial')->check()) {
            return redirect()->route('testimonial.login');
        }

        $request->validate([
            'description' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
            'business_id' => 'required|exists:businesses,id',
        ]);

        Testimonial::create([
            'business_id' => $request->business_id,
            'testimonial_user_id' => auth('testimonial')->id(),
            'name' => auth('testimonial')->user()->username,
            'description' => $request->description,
            'rating' => $request->rating,
        ]);

        return redirect()->route('business.show', ['id' => $request->business_id])
            ->with('success', 'Testimonial added successfully!');
    }

    public function showUploadForm()
    {
        return view('upload-business');
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'json_file' => 'required|mimes:json|max:2048',
        ]);

        // Simpan file JSON ke storage
        $path = $request->file('json_file')->store('json_uploads');

        // Baca file yang sudah diupload
        $jsonData = Storage::get($path);
        $data = json_decode($jsonData, true);

        if (!$data) {
            return back()->with('error', 'File JSON tidak valid.');
        }

        // Simpan ke database
        foreach ($data as $row) {
            Business::create([
                'type_id' => 1,
                'name' => $row['Place_name'],
                'address' => $row['Address1'],
                'location' => $row['Location'],
                'latitude' => $row['Latitude'] ?? null,
                'longitude' => $row['Longitude'] ?? null,
                'description' => null,
                'logo' => null,
                'open_hours' => null,
                'services' => null,
                'menu' => null,
                'media_social' => null,
                'iframe_url' => null,
                'contact' => null,
            ]);
        }

        return back()->with('success', 'Data berhasil diimport!');
    }
}
