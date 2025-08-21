@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 flex items-center justify-center p-4">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-10 left-10 w-20 h-20 bg-orange-400 rounded-full"></div>
        <div class="absolute top-32 right-16 w-16 h-16 bg-amber-400 rounded-full"></div>
        <div class="absolute bottom-20 left-20 w-24 h-24 bg-orange-300 rounded-full"></div>
        <div class="absolute bottom-32 right-10 w-18 h-18 bg-yellow-400 rounded-full"></div>
    </div>

    <div class="relative w-full max-w-lg">
        <!-- Main Login Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl border border-orange-100 overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-8 py-6 text-center">
                <!-- Logo/Icon -->
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-3">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zM6 7a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-1">Partner Login</h1>
                <p class="text-orange-100 text-sm">Manage your Indonesian culinary offerings</p>
            </div>

            <!-- Form Section -->
            <div class="px-8 py-8">
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 font-medium">
                                {{ $errors->first() }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('partner.login.submit') }}" class="space-y-6">
                    @csrf

                    <!-- Username/Email Field -->
                    <div class="form-group">
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                </svg>
                                Username / Email
                            </span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                class="form-control w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Enter your username or email"
                                required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                Password
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                id="password"
                                name="password"
                                class="form-control w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 focus:ring focus:ring-orange-200 transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Enter your password"
                                required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="btn btn-primary w-full bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-orange-200">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Login to Dashboard
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Footer Links -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Need help?
                        <a href="#" class="font-medium text-orange-600 hover:text-orange-500 transition-colors duration-200">
                            Contact Support
                        </a>
                    </p>
                </div>
            </div>

            <!-- Bottom Accent -->
            <div class="h-2 bg-gradient-to-r from-orange-400 via-amber-400 to-yellow-400"></div>
        </div>

        <!-- Additional Info Card -->
        <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-orange-100">
            <div class="flex items-center justify-center space-x-4 text-sm text-gray-600">
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                    <span>Secure Login</span>
                </div>
                <div class="w-px h-4 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                    <span>24/7 Support</span>
                </div>
                <div class="w-px h-4 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-purple-400 rounded-full mr-2"></div>
                    <span>Fast Access</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Additional custom styles for enhanced effects */
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.1);
    }

    .btn-primary:hover {
        box-shadow: 0 10px 25px rgba(251, 146, 60, 0.3);
    }

    /* Subtle animation for the background circles */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .absolute.inset-0>div {
        animation: float 6s ease-in-out infinite;
    }

    .absolute.inset-0>div:nth-child(2) {
        animation-delay: -2s;
    }

    .absolute.inset-0>div:nth-child(3) {
        animation-delay: -4s;
    }

    .absolute.inset-0>div:nth-child(4) {
        animation-delay: -1s;
    }
</style>
@endsection