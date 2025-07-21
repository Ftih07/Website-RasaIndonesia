<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Type;
use App\Models\FoodCategory;
use App\Models\QrLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $business = $user->business;

        // Jika belum punya bisnis, bisa redirect atau tampilkan view khusus
        if (!$business) {
            return redirect()->route('home')->with('error', 'You don\'t have a business yet.');
        }

        return view('dashboard.index');
    }
}
