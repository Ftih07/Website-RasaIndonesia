<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Http\Middleware\LoginThrottle;

class TestimonialAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.testimonial-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,email|max:255',
            'password' => 'required|min:3|confirmed', // Tambahkan konfirmasi password
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->username,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'contact' => $request->contact,
        ]);

        $role = Role::where('name', 'customer')->first();
        $user->roles()->attach($role->id);

        return redirect()->route('testimonial.login')->with('success', 'Account registered successfully!');
    }

    public function showLoginForm()
    {
        return view('auth.testimonial-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->username)
            ->orWhere('name', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $seconds = LoginThrottle::recordFailedAttempt($request);

            $message = 'Username atau password salah.';
            if ($seconds !== null) {
                $message .= ' Coba lagi dalam ' . now()->addSeconds($seconds)->diffForHumans(null, true) . '.';
            }

            return back()->withErrors(['error' => $message]);
        }

        // Cek role
        if (!$user->roles()->whereIn('name', ['customer', 'seller'])->exists()) {
            return back()->withErrors(['error' => 'Anda tidak memiliki akses.']);
        }

        // Login berhasil, reset percobaan
        LoginThrottle::resetAttempts($request);

        Auth::login($user, true);
        session(['auth_token_created' => now()]);

        return redirect()->route('home')->with('success', 'Login berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('testimonial.login');
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('auth.testimonial-profile-edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:3|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->username;
        $user->contact = $request->contact;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        // Redirect ke home dengan flash message sukses
        return redirect('/')
            ->with('success', 'Profile updated successfully!');
    }
}
