<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenExpired
{
    public function handle(Request $request, Closure $next)
    {
        $created = session('auth_token_created');

        if ($created && now()->diffInMinutes($created) > 30) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('testimonial.login')->withErrors(['error' => 'Sesi login telah habis. Silakan login ulang.']);
        }

        return $next($request);
    }
}
