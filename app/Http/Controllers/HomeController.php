<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Gallery;
use App\Models\QnA;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    //
    public function home()
    {
        $galleries = Gallery::all(); 
        $qna = QnA::all();
        $businesses = Business::with('testimonials')->get();

        foreach ($businesses as $business) {
            // Hitung rata-rata rating
            $business->average_rating = $business->testimonials->avg('rating') ?? 0;
        }
    
        return view('home', compact('galleries', 'qna', 'businesses')); 
    }

    public function tokorestoran()
    {
        $businesses = Business::with('testimonials')->get();

        foreach ($businesses as $business) {
            // Hitung rata-rata rating
            $business->average_rating = $business->testimonials->avg('rating') ?? 0;
        }
    
        return view('tokorestoran', compact('businesses')); 
    }

    public function show()
    {
        return view('show');
    }
}
