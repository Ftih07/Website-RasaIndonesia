<?php

namespace App\Http\Controllers;

use App\Models\TestimonialUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import authentication support
use Illuminate\Support\Facades\Hash; // Import Hash for password encryption

class TestimonialAuthController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.testimonial-register');
    }
 
    // Handle the registration process
    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'username' => 'required|unique:testimonial_users,username|max:255', // Username must be unique
            'password' => 'required|min:3', // Password must have at least 3 characters
        ]);

        // Insert the new user into the testimonial_users table
        \DB::table('testimonial_users')->insert([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect to the login page with a success message
        return redirect()->route('testimonial.login')->with('success', 'Account registered successfully!');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.testimonial-login');
    }

    // Show the login form
    public function login(Request $request)
    {
        // Validate login credentials
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt to log in using the 'testimonial' guard
        if (auth()->guard('testimonial')->attempt($request->only('username', 'password'))) {
            // If successful, redirect to the home page
            return redirect()->route('home')->with('success', 'You are now logged in!');
        }

        // If login fails, return to the login page with an error message
        return back()->withErrors(['error' => 'Invalid username or password']);
    }

    // Handle user logout
    public function logout()
    {
        Auth::guard('testimonial')->logout(); // Log out the user from the 'testimonial' guard
        return redirect()->route('testimonial.login'); // Redirect to the login page
    }

    // Show the profile edit form
    public function editProfile()
    {
        $user = auth('testimonial')->user(); // Get the authenticated user
        return view('auth.testimonial-profile-edit', compact('user')); // Pass user data to the view
    }

    // Handle profile update
    public function updateProfile(Request $request)
    {
        $user = auth('testimonial')->user(); // Get the authenticated user

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:3|confirmed', // Password update is optional
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow only image files
        ]);

        // Update the username
        $user->username = $request->username;

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Hash and store the new password
        }

        // Update profile picture if a new file is uploaded
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $path = $file->store('profile_pictures', 'public'); // Store the uploaded image in the 'public' disk
            $user->profile_picture = $path; // Save the file path in the database
        }

        // Save the updated user information
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
