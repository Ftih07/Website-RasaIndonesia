<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class LoginThrottle
{
    protected $levels = [
        1 => 30,         // 30 detik
        2 => 60,         // 1 menit
        3 => 3600,       // 1 jam
        4 => 86400,      // 1 hari
        5 => 604800,     // 1 minggu
        6 => 2592000,    // 1 bulan
        7 => 31536000,   // 1 tahun
    ];

    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $blockKey = 'login_block_until_' . $ip;

        // Kalau masih diblokir
        if (Cache::has($blockKey)) {
            $blockUntil = Carbon::parse(Cache::get($blockKey));

            if (now()->lt($blockUntil)) {
                $remaining = $blockUntil->diffForHumans(null, true);
                return back()->withErrors([
                    'error' => "Too many login attempts. Try again in $remaining."
                ]);
            } else {
                // Reset blokir dan lanjutkan
                Cache::forget($blockKey);
            }
        }

        return $next($request);
    }

    public static function recordFailedAttempt(Request $request)
    {
        $ip = $request->ip();
        $attemptsKey = 'login_attempts_' . $ip;
        $blockKey = 'login_block_until_' . $ip;

        $attempts = Cache::get($attemptsKey, 0) + 1;
        Cache::put($attemptsKey, $attempts, now()->addDays(1)); // Simpan 1 hari

        // Cek apakah saat ini kelipatan 5 (misal 5, 10, 15, ...)
        if ($attempts % 5 === 0) {
            $level = min(intval($attempts / 5), 7); // Maksimal level 7
            $duration = (new self)->levels[$level];
            $blockUntil = now()->addSeconds($duration);

            Cache::put($blockKey, $blockUntil->toDateTimeString(), $duration);

            return $duration;
        }

        return null;
    }

    public static function resetAttempts(Request $request)
    {
        $ip = $request->ip();
        Cache::forget('login_attempts_' . $ip);
        Cache::forget('login_block_until_' . $ip);
    }
}
