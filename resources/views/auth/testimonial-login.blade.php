<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Basic Meta Tags -->
    <title>Sign In | Taste of Indonesia</title>
    <meta name="description" content="Login to Taste of Indonesia and continue your culinary journey across Australia. Discover authentic Indonesian restaurants, cultural events, and connect with the Indonesian community.">
    <meta name="keywords" content="Taste of Indonesia login, Indonesian food Australia, sign in Taste of Indonesia, ICAV, ATDAG Canberra, Indonesian culinary community">
    <meta name="author" content="Taste of Indonesia">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sign In | Taste of Indonesia">
    <meta property="og:description" content="Login to Taste of Indonesia to explore authentic Indonesian restaurants, join culinary events, and connect with Indonesian food lovers in Australia.">
    <meta property="og:image" content="{{ asset('assets/images/logo/Logo-ICAV.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Taste of Indonesia">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Sign In | Taste of Indonesia">
    <meta name="twitter:description" content="Sign in to your Taste of Indonesia account and continue your journey discovering authentic Indonesian flavors in Australia.">
    <meta name="twitter:image" content="{{ asset('assets/images/logo/Logo-ICAV.png') }}">

    <!-- Additional SEO -->
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#FFD700">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'indonesian-red': '#C41E3A',
                        'indonesian-gold': '#FFD700',
                        'warm-orange': '#FF6B35',
                        'spice-brown': '#8B4513',
                        'traditional-red': '#DC143C',
                        'deep-red': '#B22222',
                        'golden-yellow': '#DAA520',
                        'forest-green': '#228B22',
                        'ocean-blue': '#006994'
                    },
                    fontFamily: {
                        'playfair': ['Playfair Display', 'serif'],
                        'poppins': ['Poppins', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif']
                    },
                    backgroundImage: {
                        'indonesian-gradient': 'linear-gradient(135deg, #C41E3A 0%, #FF6B35 25%, #FFD700 50%, #228B22 75%, #006994 100%)',
                        'warm-gradient': 'linear-gradient(135deg, #C41E3A 0%, #FF6B35 50%, #FFD700 100%)',
                        'cultural-pattern': "url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 60 60\"><defs><pattern id=\"batik\" patternUnits=\"userSpaceOnUse\" width=\"30\" height=\"30\"><circle cx=\"15\" cy=\"15\" r=\"2\" fill=\"%23ffffff\" opacity=\"0.15\"/><path d=\"M5,5 Q15,10 25,5 Q35,15 25,25 Q15,20 5,25 Q-5,15 5,5\" fill=\"none\" stroke=\"%23ffffff\" stroke-width=\"0.5\" opacity=\"0.1\"/></pattern></defs><rect width=\"60\" height=\"60\" fill=\"url(%23batik)\"/></svg>')"
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'fade-in': 'fadeIn 1s ease-out',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'ripple': 'ripple 0.6s linear'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            }
                        },
                        slideUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(30px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        glow: {
                            '0%': {
                                box - shadow: '0 0 20px rgba(255, 215, 0, 0.5)'
                            },
                            '100%': {
                                box - shadow: '0 0 30px rgba(255, 215, 0, 0.8)'
                            }
                        },
                        ripple: {
                            '0%': {
                                transform: 'scale(0)',
                                opacity: '1'
                            },
                            '100%': {
                                transform: 'scale(4)',
                                opacity: '0'
                            }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .glass-morphism {
            backdrop-filter: blur(25px);
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
        }

        .enhanced-glass {
            backdrop-filter: blur(20px) saturate(180%);
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.2) 0%,
                    rgba(255, 255, 255, 0.1) 100%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .floating-label {
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            transform-origin: left top;
        }

        .input-focused .floating-label {
            transform: translateY(-24px) scale(0.85);
            color: #FFD700;
            font-weight: 500;
        }

        .premium-input {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .premium-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 215, 0, 0.6);
            box-shadow:
                0 0 0 3px rgba(255, 215, 0, 0.2),
                0 8px 25px rgba(255, 215, 0, 0.15);
        }

        .btn-indonesian {
            background: linear-gradient(135deg, #C41E3A 0%, #FF6B35 50%, #FFD700 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .btn-indonesian::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .btn-indonesian:hover::before {
            left: 100%;
        }

        .btn-indonesian:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow:
                0 15px 35px rgba(196, 30, 58, 0.4),
                0 5px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-indonesian:active {
            transform: translateY(-1px) scale(1.01);
        }

        .logo-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
            border: 2px solid rgba(255, 215, 0, 0.3);
            animation: float 6s ease-in-out infinite, glow 2s ease-in-out infinite alternate;
        }

        .animated-bg {
            background:
                linear-gradient(135deg, #C41E3A 0%, #FF6B35 25%, #FFD700 50%, #228B22 75%, #006994 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .cultural-overlay {
            background-image:
                radial-gradient(circle at 20% 20%, rgba(255, 215, 0, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(196, 30, 58, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(255, 107, 53, 0.15) 0%, transparent 50%);
        }

        .pattern-overlay {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="indonesian-pattern" patternUnits="userSpaceOnUse" width="50" height="50"><circle cx="25" cy="25" r="3" fill="%23ffffff" opacity="0.1"/><path d="M10,10 Q25,15 40,10 Q50,25 40,40 Q25,35 10,40 Q0,25 10,10" fill="none" stroke="%23ffffff" stroke-width="0.8" opacity="0.08"/><rect x="20" y="20" width="10" height="10" fill="%23ffffff" opacity="0.05" rx="2"/></pattern></defs><rect width="100" height="100" fill="url(%23indonesian-pattern)"/></svg>');
        }

        .ripple-effect {
            position: relative;
            overflow: hidden;
        }

        .ripple-effect::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        .social-btn {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .social-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .footer-blur {
            backdrop-filter: blur(20px) saturate(180%);
            background: rgba(0, 0, 0, 0.2);
        }

        /* Responsive improvements */
        @media (max-width: 640px) {
            .glass-morphism {
                margin: 1rem;
                padding: 1.5rem;
            }

            .logo-container {
                padding: 0.75rem;
                margin-bottom: 1.5rem;
            }

            .logo-container img {
                height: 2.5rem;
            }
        }

        @media (max-height: 700px) {
            .min-h-screen {
                min-height: 100vh;
                padding-top: 2rem;
                padding-bottom: 6rem;
            }
        }

        /* Loading animation */
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .btn-loading .loading-spinner {
            display: inline-block;
        }

        .btn-loading .btn-text {
            display: none;
        }
    </style>
</head>

<body class="min-h-screen font-inter overflow-x-hidden">
    <!-- Enhanced Animated Background -->
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 animated-bg"></div>
        <div class="absolute inset-0 pattern-overlay"></div>
        <div class="absolute inset-0 cultural-overlay"></div>

        <!-- Floating particles -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white rounded-full animate-float" style="animation-delay: 0s;"></div>
            <div class="absolute top-1/3 right-1/4 w-1 h-1 bg-indonesian-gold rounded-full animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-1/4 left-1/3 w-1.5 h-1.5 bg-white rounded-full animate-float" style="animation-delay: 4s;"></div>
            <div class="absolute top-2/3 right-1/3 w-1 h-1 bg-white rounded-full animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-1/3 right-1/4 w-2 h-2 bg-indonesian-gold rounded-full animate-float" style="animation-delay: 3s;"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4 py-20">
        <div class="w-full max-w-md">
            <!-- Enhanced Logo Section -->
            <div class="text-center mb-8 animate-slide-up">
                <div class="logo-container inline-flex items-center justify-center rounded-3xl p-4 mb-6">
                    <img src="{{ asset('assets/images/logo/Logo-ICAV.png') }}"
                        alt="ICAV Logo"
                        class="h-12 mx-2 transition-transform duration-300 hover:scale-110">
                    <img src="{{ asset('assets/images/logo/Logo-Atdag-Canberra.png') }}"
                        alt="ATDAG Logo"
                        class="h-14 mx-2 transition-transform duration-300 hover:scale-110">
                </div>
                <h1 class="text-4xl lg:text-5xl font-playfair font-bold text-white mb-3 drop-shadow-lg">
                    Taste of Indonesia
                </h1>
                <p class="text-white/90 text-base font-medium drop-shadow-md">
                    Discover Authentic Indonesian Flavors
                </p>
                <div class="w-24 h-1 bg-indonesian-gold mx-auto mt-4 rounded-full opacity-80"></div>
            </div>

            <!-- Enhanced Login Form -->
            <div class="enhanced-glass rounded-3xl p-8 lg:p-10 shadow-2xl animate-slide-up" style="animation-delay: 0.2s;">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-playfair font-semibold text-white mb-3 drop-shadow-md">
                        Welcome Back
                    </h2>
                    <p class="text-white/80 text-base font-medium">
                        Sign in to continue your culinary journey
                    </p>
                </div>

                <form method="POST" action="{{ route('testimonial.login') }}" class="space-y-6" id="loginForm">
                    @csrf

                    <!-- Enhanced Error/Success Messages -->
                    @if ($errors->any())
                    <div class="bg-red-500/20 border border-red-400/30 rounded-xl p-4 text-red-100 text-sm text-center backdrop-blur-sm animate-slide-up">
                        <i class="bi bi-exclamation-triangle-fill mr-2"></i>
                        {{ $errors->first() }}
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="bg-green-500/20 border border-green-400/30 rounded-xl p-4 text-green-100 text-sm text-center backdrop-blur-sm animate-slide-up">
                        <i class="bi bi-check-circle-fill mr-2"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Enhanced Username Field -->
                    <div class="relative group">
                        <div class="relative">
                            <input type="text"
                                name="username"
                                id="username"
                                class="premium-input w-full h-16 bg-white/10 border border-white/25 rounded-xl px-5 pr-14 text-white text-base placeholder-transparent focus:outline-none transition-all duration-300"
                                placeholder="Username"
                                value="{{ old('username') }}"
                                required>
                            <label for="username"
                                class="floating-label absolute left-5 top-1/2 -translate-y-1/2 text-white/80 text-base pointer-events-none font-medium">
                                Username
                            </label>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 text-white/70 transition-colors duration-300 group-hover:text-indonesian-gold">
                                <i class="bi bi-person-fill text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Password Field -->
                    <div class="relative group">
                        <div class="relative">
                            <input type="password"
                                name="password"
                                id="password"
                                class="premium-input w-full h-16 bg-white/10 border border-white/25 rounded-xl px-5 pr-14 text-white text-base placeholder-transparent focus:outline-none transition-all duration-300"
                                placeholder="Password"
                                required>
                            <label for="password"
                                class="floating-label absolute left-5 top-1/2 -translate-y-1/2 text-white/80 text-base pointer-events-none font-medium">
                                Password
                            </label>
                            <button type="button"
                                onclick="togglePassword()"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-white/70 hover:text-indonesian-gold transition-colors duration-300 focus:outline-none">
                                <i class="bi bi-eye-slash-fill text-lg" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Enhanced Login Button -->
                    <button type="submit"
                        class="btn-indonesian ripple-effect w-full h-16 text-white font-semibold text-lg rounded-xl shadow-lg focus:outline-none focus:ring-4 focus:ring-indonesian-gold/30 transition-all duration-300 relative overflow-hidden">
                        <span class="btn-text flex items-center justify-center">
                            <i class="bi bi-box-arrow-in-right mr-3 text-xl"></i>
                            Sign In
                        </span>
                        <div class="loading-spinner"></div>
                    </button>

                    <!-- Enhanced Divider -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/25"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-6 bg-transparent text-white/80 font-medium">or continue with</span>
                        </div>
                    </div>

                    <!-- Enhanced Google Login Button -->
                    <a href="{{ route('google.redirect') }}"
                        class="social-btn w-full h-16 rounded-xl text-white font-medium flex items-center justify-center transition-all duration-300 hover:scale-[1.02] group">
                        <svg class="w-6 h-6 mr-4 group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24">
                            <path fill="#EA4335" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span class="text-base">Continue with Google</span>
                    </a>

                    <!-- Enhanced Register Link -->
                    <div class="text-center pt-6">
                        <p class="text-white/90 text-base">
                            Don't have an account?
                            <a href="{{ route('testimonial.register') }}"
                                class="text-indonesian-gold hover:text-yellow-300 font-semibold transition-all duration-300 underline decoration-dotted underline-offset-4 hover:underline-offset-2 ml-2">
                                Create Account
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Enhanced Additional Info -->
            <div class="text-center mt-8 animate-slide-up" style="animation-delay: 0.4s;">
                <p class="text-white/80 text-sm font-medium drop-shadow-md">
                    🇮🇩 Connecting Indonesian food lovers across Australia 🇦🇺
                </p>
            </div>
        </div>
    </div>

    <!-- Enhanced Footer -->
    <footer class="fixed bottom-0 left-0 right-0 z-20 footer-blur border-t border-white/20">
        <div class="container mx-auto px-4 py-4">
            <div class="text-center">
                <p class="text-white/90 text-sm font-medium">
                    Copyright © 2025
                    <span class="font-bold text-indonesian-gold">Taste of Indonesia</span>.
                    All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Enhanced toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'bi bi-eye-fill text-lg';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'bi bi-eye-slash-fill text-lg';
            }
        }

        // Enhanced floating label functionality
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');

            inputs.forEach(input => {
                const container = input.closest('.relative');

                function updateLabel() {
                    if (input.value.trim() !== '' || input === document.activeElement) {
                        container.classList.add('input-focused');
                    } else {
                        container.classList.remove('input-focused');
                    }
                }

                input.addEventListener('focus', updateLabel);
                input.addEventListener('blur', updateLabel);
                input.addEventListener('input', updateLabel);

                // Check initial state
                updateLabel();
            });

            // Form submission loading state
            const form = document.getElementById('loginForm');
            const submitBtn = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function() {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            });
        });

        // Enhanced ripple effect
        document.querySelectorAll('.ripple-effect').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Smooth scroll to top on page load
        window.addEventListener('load', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Auto-hide alerts with enhanced animation
        setTimeout(() => {
            const alerts = document.querySelectorAll('[class*="bg-red-500"], [class*="bg-green-500"]');
            alerts.forEach(alert => {
                alert.style.transition = 'all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1)';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 6000);

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }
        `;
        document.head.appendChild(style);

        // Improved responsive handling
        function handleResize() {
            const vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        }

        window.addEventListener('resize', handleResize);
        handleResize();

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.type !== 'submit') {
                const form = e.target.closest('form');
                if (form) {
                    const inputs = Array.from(form.querySelectorAll('input'));
                    const currentIndex = inputs.indexOf(e.target);
                    const nextInput = inputs[currentIndex + 1];

                    if (nextInput) {
                        nextInput.focus();
                    } else {
                        form.querySelector('button[type="submit"]').click();
                    }
                }
            }
        });
    </script>
</body>

</html>