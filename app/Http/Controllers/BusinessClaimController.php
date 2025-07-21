<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessClaim;
use Illuminate\Http\Request;
use App\Helpers\NotificationHelper; // tambahkan di atas

class BusinessClaimController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        if ($user->business) {
            return redirect()->route('home')->with('error', 'Kamu sudah memiliki bisnis.');
        }

        $businesses = Business::whereNull('user_id')->get();

        return view('business.claim', compact('businesses'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->business) {
            return back()->with('error', 'Kamu sudah memiliki bisnis.');
        }

        $request->validate([
            'business_id' => 'required|exists:businesses,id',
        ]);

        $business = Business::find($request->business_id);
        if ($business->user_id !== null) {
            return back()->with('error', 'Bisnis sudah dimiliki user lain.');
        }

        BusinessClaim::firstOrCreate([
            'user_id' => $user->id,
            'business_id' => $business->id,
        ]);

        NotificationHelper::send(
            $user->id,
            'Klaim bisnis kamu sedang diproses',
            'Admin akan mengevaluasi permintaan klaim kamu.',
            route('dashboard') // Ganti sesuai kebutuhan
        );

        return redirect()->route('home')->with('success', 'Permintaan klaim bisnis telah dikirim.');
    }
}
