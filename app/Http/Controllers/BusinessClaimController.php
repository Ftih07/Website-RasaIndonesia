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
            return redirect()->route('home')->with('error', 'You already own a business.');
        }

        $businesses = Business::whereNull('user_id')->get();

        return view('business.claim', compact('businesses'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->business) {
            return back()->with('error', 'You already own a business.');
        }

        $request->validate([
            'business_id' => 'required|exists:businesses,id',
        ]);

        $business = Business::find($request->business_id);
        if ($business->user_id !== null) {
            return back()->with('error', 'The business is already owned by another user.');
        }

        BusinessClaim::firstOrCreate([
            'user_id' => $user->id,
            'business_id' => $business->id,
        ]);

        NotificationHelper::send(
            $user->id,
            'Your business claim is being processed',
            'The admin will evaluate your claim request.',
            route('dashboard') // Change as needed
        );

        return redirect()->route('home')->with('success', 'Your business claim request has been sent.');
    }
}
