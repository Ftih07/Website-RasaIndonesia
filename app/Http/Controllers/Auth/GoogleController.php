<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Role;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(str()->random(16)), // random password
            ]
        );

        // Assign role if belum ada
        if (!$user->roles()->where('name', 'customer')->exists()) {
            $role = Role::where('name', 'customer')->first();
            $user->roles()->attach($role);
        }

        Auth::login($user, true);

        return redirect()->route('home')->with('success', 'Login with Google successful!');
    }
}
