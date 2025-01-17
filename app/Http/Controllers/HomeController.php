<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\FoodCategory;
use App\Models\Gallery;
use App\Models\QnA;
use App\Models\Type;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    //
    public function home(Request $request)
    {
        $galleries = Gallery::all();
        $qna = QnA::all();
        $types = Type::all();

        // Ambil filter tipe dari request (default 'all' jika tidak ada filter)
        $typeFilter = $request->get('type', 'all');

        // Query bisnis dengan filter tipe
        $businesses = Business::with('testimonials', 'type')
            ->when($typeFilter !== 'all', function ($query) use ($typeFilter) {
                $query->whereHas('type', function ($q) use ($typeFilter) {
                    $q->where('title', $typeFilter);
                });
            })
            ->get();

        // Hitung rata-rata rating untuk setiap bisnis
        foreach ($businesses as $business) {
            $business->average_rating = $business->testimonials->avg('rating') ?? 0;
        }

        // Kirim data ke view
        return view('home', compact('galleries', 'qna', 'businesses', 'types', 'typeFilter'));
    }

    public function tokorestoran(Request $request)
    {
        $query = Business::with('testimonials', 'food_categories', 'type');

        // Filter berdasarkan kategori makanan
        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('food_categories', function ($q) use ($request) {
                $q->where('title', $request->category);
            });
        }

        // Filter berdasarkan jenis bisnis
        if ($request->filled('type') && $request->type !== 'all') {
            $query->whereHas('type', function ($q) use ($request) {
                $q->where('title', $request->type);
            });
        }

        // Pencarian berdasarkan nama
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // Sorting data
        if ($request->filled('sort')) {
            $order = $request->sort === 'oldest' ? 'asc' : 'desc';
            $query->orderBy('created_at', $order);
        }

        $businesses = $query->get();

        // Hitung rata-rata rating
        foreach ($businesses as $business) {
            $business->average_rating = $business->testimonials->avg('rating') ?? 0;
        }

        // Ambil kategori makanan dan jenis bisnis untuk dropdown
        $foodCategories = FoodCategory::all();
        $businessTypes = Type::all();

        return view('tokorestoran', compact('businesses', 'foodCategories', 'businessTypes'));
    }


    public function show()
    {
        return view('show');
    }
}
