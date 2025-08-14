<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderDashboardController extends Controller
{
    public function index()
    {
        $business = Auth::user()->business;

        if ($business->orders_status === 'not_requested') {
            return view('dashboard.orders.request', compact('business'));
        }

        if ($business->orders_status === 'pending') {
            return view('dashboard.orders.pending', compact('business'));
        }

        if ($business->orders_status === 'approved') {
            return view('dashboard.orders.index', compact('business'));
        }

        if ($business->orders_status === 'rejected') {
            return view('dashboard.orders.rejected', compact('business'));
        }
    }

    public function requestActivation(Request $request)
    {
        $business = Auth::user()->business;
        $business->update([
            'orders_status' => 'pending',
        ]);

        return redirect()->route('dashboard.orders')->with('success', 'Pengajuan aktivasi Orders telah dikirim. Menunggu persetujuan admin.');
    }
}
