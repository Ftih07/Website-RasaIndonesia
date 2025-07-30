<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Profile | Taste of Indonesia</title>

    <meta name="description" content="Update your profile information on Taste of Indonesia. Keep your account up to date.">
    <meta property="og:title" content="Edit Profile | Taste of Indonesia">
    <meta property="og:description" content="Update your profile information on Taste of Indonesia.">
    <meta property="og:image" content="{{ asset('assets/images/logo/logo.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <style>
        :root {
            --indonesian-gold: #FF8000;
            --indonesian-brown: #fb923c;
            --indonesian-cream: #FDF6E3;
            --indonesian-warm-white: #FEFBF6;
            --indonesian-text: #6B5B47;
            --indonesian-light-brown: #fb923c;
            --indonesian-accent: #fb923c;
            --shadow-warm: rgba(139, 69, 19, 0.1);
            --shadow-soft: rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--indonesian-warm-white) 0%, var(--indonesian-cream) 100%);
            min-height: 100vh;
        }

        /* Floating background elements */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--indonesian-gold), var(--indonesian-brown));
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 70%;
            left: 80%;
            animation-delay: 2s;
        }

        .floating-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 40%;
            left: 5%;
            animation-delay: 4s;
        }

        .floating-shape:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 85%;
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-20px) rotate(120deg);
            }

            66% {
                transform: translateY(-10px) rotate(240deg);
            }
        }

        /* Glass effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px rgba(139, 69, 19, 0.1);
        }

        .glass-header {
            background: linear-gradient(135deg, rgba(255, 128, 0, 0.9), rgba(251, 146, 60, 0.9));
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Form animations */
        .form-group {
            animation: slideInUp 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.3s;
        }

        .form-group:nth-child(4) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(5) {
            animation-delay: 0.5s;
        }

        .form-group:nth-child(6) {
            animation-delay: 0.6s;
        }

        @keyframes slideInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Input focus effects */
        .form-input {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: var(--indonesian-gold);
            box-shadow: 0 0 0 3px rgba(255, 128, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Button hover effects */
        .btn-indonesian {
            background: linear-gradient(135deg, var(--indonesian-gold), var(--indonesian-brown));
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-indonesian::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-indonesian:hover::before {
            left: 100%;
        }

        .btn-indonesian:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255, 128, 0, 0.3);
        }

        /* File upload styling */
        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-upload-input {
            position: absolute;
            left: -9999px;
        }

        .file-upload-button {
            background: linear-gradient(135deg, rgba(255, 128, 0, 0.8), rgba(251, 146, 60, 0.8));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 128, 0, 0.2);
        }

        /* Profile image effects */
        .profile-image {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px var(--shadow-warm);
        }

        .profile-image:hover {
            transform: scale(1.05) rotate(2deg);
            border-color: var(--indonesian-gold);
            box-shadow: 0 15px 40px rgba(255, 128, 0, 0.2);
        }

        /* Logo container glass effect */
        .logo-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        /* Password toggle animation */
        .password-toggle {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: var(--indonesian-gold);
            transform: scale(1.1);
        }

        /* Success message animation */
        .success-message {
            animation: successSlide 0.5s ease-out;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        @keyframes successSlide {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Main card entrance animation */
        .main-card {
            animation: cardEntrance 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(50px) scale(0.95);
        }

        @keyframes cardEntrance {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--indonesian-cream);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--indonesian-gold), var(--indonesian-brown));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(var(--indonesian-brown), var(--indonesian-gold));
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'indonesian-gold': '#FF8000',
                        'indonesian-brown': '#fb923c',
                        'indonesian-cream': '#FDF6E3',
                        'indonesian-warm-white': '#FEFBF6',
                        'indonesian-text': '#6B5B47',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'playfair': ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="font-poppins">
    <!-- Floating background shapes -->
    <div class="floating-shapes">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>

    <!-- Main Section -->
    <section class="min-h-screen flex items-center justify-center px-4 py-12 relative z-10">
        <div class="main-card glass-card rounded-3xl overflow-hidden max-w-2xl w-full shadow-2xl">
            <!-- Header with glass effect -->
            <div class="glass-header text-white p-8 text-center">
                <div class="logo-container rounded-2xl p-4 mb-6 mx-auto max-w-fit shadow-lg">
                    <img src="{{ asset('assets/images/logo/Logo-ICAV.png') }}" alt="Logo 1" class="h-12 md:h-16 mx-3 inline-block">
                    <img src="{{ asset('assets/images/logo/Logo-Atdag-Canberra.png') }}" alt="Logo 2" class="h-12 md:h-16 mx-3 inline-block">
                </div>
                <h2 class="text-3xl md:text-4xl font-bold font-poppins">Edit Profile</h2>
                <p class="text-white/80 mt-2">Update your information</p>
            </div>

            <!-- Form Body -->
            <div class="p-8 md:p-10">
                @if (session('success'))
                <div class="success-message rounded-xl p-4 mb-6 text-green-700 font-medium">
                    <i class="uil uil-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('testimonial.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Username -->
                    <div class="form-group">
                        <label class="block text-indonesian-text font-semibold mb-3 text-sm md:text-base">
                            <i class="uil uil-user mr-2 text-indonesian-gold"></i>Username
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="username"
                                value="{{ old('username', $user->name) }}"
                                required
                                class="form-input w-full pl-12 pr-4 py-4 rounded-xl border-0 text-indonesian-text placeholder-indonesian-text/50 focus:outline-none"
                                placeholder="Enter your username" />
                            <i class="uil uil-user absolute left-4 top-1/2 transform -translate-y-1/2 text-indonesian-gold"></i>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="block text-indonesian-text font-semibold mb-3 text-sm md:text-base">
                            <i class="uil uil-lock mr-2 text-indonesian-gold"></i>New Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-input w-full pl-12 pr-12 py-4 rounded-xl border-0 text-indonesian-text placeholder-indonesian-text/50 focus:outline-none"
                                placeholder="Enter new password" />
                            <i class="uil uil-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-indonesian-gold"></i>
                            <i class="uil uil-eye-slash password-toggle absolute right-4 top-1/2 transform -translate-y-1/2 text-indonesian-text/60"
                                id="togglePassword"
                                onclick="togglePassword('password', 'togglePassword')"></i>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="form-group">
                        <label class="block text-indonesian-text font-semibold mb-3 text-sm md:text-base">
                            <i class="uil uil-phone mr-2 text-indonesian-gold"></i>Contact
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="contact"
                                value="{{ old('contact', $user->contact) }}"
                                required
                                class="form-input w-full pl-12 pr-4 py-4 rounded-xl border-0 text-indonesian-text placeholder-indonesian-text/50 focus:outline-none"
                                placeholder="Enter your contact number" />
                            <i class="uil uil-phone absolute left-4 top-1/2 transform -translate-y-1/2 text-indonesian-gold"></i>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label class="block text-indonesian-text font-semibold mb-3 text-sm md:text-base">
                            <i class="uil uil-map-marker mr-2 text-indonesian-gold"></i>Address
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="address"
                                value="{{ old('address', $user->address) }}"
                                required
                                class="form-input w-full pl-12 pr-4 py-4 rounded-xl border-0 text-indonesian-text placeholder-indonesian-text/50 focus:outline-none"
                                placeholder="Enter your address" />
                            <i class="uil uil-map-marker absolute left-4 top-1/2 transform -translate-y-1/2 text-indonesian-gold"></i>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label class="block text-indonesian-text font-semibold mb-3 text-sm md:text-base">
                            <i class="uil uil-lock mr-2 text-indonesian-gold"></i>Confirm Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-input w-full pl-12 pr-12 py-4 rounded-xl border-0 text-indonesian-text placeholder-indonesian-text/50 focus:outline-none"
                                placeholder="Confirm your password" />
                            <i class="uil uil-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-indonesian-gold"></i>
                            <i class="uil uil-eye-slash password-toggle absolute right-4 top-1/2 transform -translate-y-1/2 text-indonesian-text/60"
                                id="togglePasswordConfirm"
                                onclick="togglePassword('password_confirmation', 'togglePasswordConfirm')"></i>
                        </div>
                    </div>

                    <!-- Profile Picture -->
                    <div class="form-group text-center">
                        <label class="block text-indonesian-text font-semibold mb-4 text-sm md:text-base">
                            <i class="uil uil-camera mr-2 text-indonesian-gold"></i>Update Profile Picture
                        </label>

                        <div class="mb-6">
                            <img
                                id="profilePreview"
                                src="{{ auth()->user()->profile_image
                                    ? asset('storage/' . auth()->user()->profile_image)
                                    : asset('assets/images/default-profile.png') }}"
                                alt="Profile Picture"
                                class="profile-image w-28 h-28 md:w-32 md:h-32 rounded-full object-cover mx-auto" />
                        </div>

                        <div class="file-upload-wrapper">
                            <input
                                type="file"
                                name="profile_picture"
                                accept="image/*"
                                id="profile_picture"
                                class="file-upload-input"
                                onchange="previewImage(event)" />
                            <label for="profile_picture" class="file-upload-button inline-block px-6 py-3 rounded-xl text-white font-semibold">
                                <i class="uil uil-camera mr-2"></i>Choose Photo
                            </label>
                        </div>
                    </div>

                    <div class="form-group pt-4 flex flex-col gap-3">
                        <!-- Update Button -->
                        <button type="submit"
                            class="w-full py-4 px-8 rounded-xl text-white font-bold text-lg transition-all duration-300 relative overflow-hidden bg-gradient-to-r from-orange-500 to-orange-400 shadow-md hover:shadow-xl hover:scale-[1.02]">
                            <i class="uil uil-check-circle mr-2"></i>
                            Update Profile
                        </button>

                        <!-- Cancel Button -->
                        <button type="button" onclick="window.history.back();"
                            class="w-full py-4 px-8 rounded-xl font-bold text-lg transition-all duration-300 relative overflow-hidden border-2 border-orange-400 text-orange-500 bg-white hover:bg-orange-50 hover:scale-[1.02]">
                            <i class="uil uil-times-circle mr-2"></i>
                            Cancel
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16 relative z-10">
        <div class="container mx-auto px-4">
            <div class="border-t border-gray-700 py-8">
                <div class="text-center">
                    <p class="text-gray-300">
                        Copyright &copy; 2025 <span class="text-indonesian-gold font-bold">Taste </span>of Indonesia. All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById('profilePreview');
                preview.src = reader.result;
                preview.classList.add('animate-pulse');
                setTimeout(() => preview.classList.remove('animate-pulse'), 500);
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.className = toggleIcon.className.replace('uil-eye-slash', 'uil-eye');
            } else {
                passwordInput.type = "password";
                toggleIcon.className = toggleIcon.className.replace('uil-eye', 'uil-eye-slash');
            }
        }

        // Add entrance animations
        document.addEventListener('DOMContentLoaded', function() {
            // Stagger form group animations
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                setTimeout(() => {
                    group.style.animationDelay = `${index * 0.1}s`;
                }, 100);
            });

            // Add floating animation to shapes
            const shapes = document.querySelectorAll('.floating-shape');
            shapes.forEach((shape, index) => {
                shape.style.animationDelay = `${index * 0.5}s`;
            });
        });

        // Add input focus animation
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>

</html>