<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('partner.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->username)
            ->orWhere('name', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['error' => 'Username atau password salah.'])->withInput();
        }

        // Cek role partner
        if (!$user->roles()->where('name', 'partner')->exists()) {
            return back()->withErrors(['error' => 'Anda tidak memiliki akses partner.']);
        }

        Auth::login($user, true);
        session(['auth_token_created' => now()]);

        return redirect()->route('partner.orders.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('partner.login');
    }
}
