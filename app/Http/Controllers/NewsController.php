<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //
    public function show($slug)
    {
        // Ambil news berdasarkan slug
        $currentNews = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Ambil 3 berita lain sebagai "another news", kecuali yang sedang dilihat
        $anotherNews = News::where('status', 'published')
            ->where('id', '!=', $currentNews->id)
            ->latest()
            ->get();

        return view('news.show', compact('currentNews', 'anotherNews'));
    }

    public function index()
    {
        $allNews = News::where('status', 'published')->get();

        return view('news.index', compact('allNews'));
    }
}
