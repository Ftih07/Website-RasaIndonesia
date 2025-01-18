<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Type;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    //
    public function show($id)
    {
        // Menampilkan bisnis berdasarkan ID
        $business = Business::with(['testimonials', 'products', 'galleries'])->findOrFail($id);

        // Mengambil 3 restoran lainnya, menghindari yang sama dengan bisnis yang sedang ditampilkan
        $otherBusinesses = Business::where('type_id', $business->type_id)  // Asumsi ada relasi 'type'
            ->whereNotIn('id', [$id])               // Gunakan whereNotIn untuk menghindari ID yang sedang ditampilkan
            ->take(3)                               // Ambil 3 data lainnya
            ->get();


        return view('business.show', compact('business', 'otherBusinesses'));
    }
}
