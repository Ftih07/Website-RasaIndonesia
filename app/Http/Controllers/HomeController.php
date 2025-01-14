<?php

namespace App\Http\Controllers;
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

        return view('home', compact('galleries', 'qna')); 
    }

    public function show()
    {
        return view('show');
    }

    public function tokorestoran()
    {
        return view('tokorestoran');
    }
}
