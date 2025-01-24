<?php

namespace App\Http\Controllers;

use App\Models\TestimonialUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TestimonialAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.testimonial-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:testimonial_users,username|max:255',
            'password' => 'required|min:3',
        ]);

        // Simpan data pengguna ke tabel testimonial_users
        \DB::table('testimonial_users')->insert([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect ke halaman login dengan pesan sukses
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

        if (auth()->guard('testimonial')->attempt($request->only('username', 'password'))) {
            // Jika berhasil login, arahkan ke halaman home
            return redirect()->route('home')->with('success', 'You are now logged in!');
        }

        // Jika login gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors(['error' => 'Invalid username or password']);
    }



    public function logout()
    {
        Auth::guard('testimonial')->logout();
        return redirect()->route('testimonial.login');
    }

    public function editProfile()
    {
        $user = auth('testimonial')->user();
        return view('auth.testimonial-profile-edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth('testimonial')->user();

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:3|confirmed', // Validasi password opsional
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update username
        $user->username = $request->username;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update profile picture jika diupload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
