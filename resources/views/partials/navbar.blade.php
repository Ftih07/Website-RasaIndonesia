<style>
    .navbar-brand-text {
        color: #FF8243 !important;
        font-weight: bold;
        font-size: 1.5rem;
        text-decoration: none;
    }

    .navbar-nav .nav-link {
        color: #333 !important;
        font-weight: 500;
        padding: 0.5rem 1rem !important;
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        color: #FF8243 !important;
        transform: translateY(-2px);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .dropdown-item {
        padding: 0.75rem 1.5rem;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #FF8243;
        color: black !important;
    }

    .btn-login {
        background-color: #FF8243;
        border: none;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        background-color: #e6753b;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 130, 67, 0.3);
    }

    .profile-dropdown img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #FF8243;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .profile-dropdown img:hover {
        transform: scale(1.1);
    }

    .notification-icon {
        position: relative;
        color: #333;
        font-size: 1.2rem;
        padding: 0.5rem;
        text-decoration: none;
    }

    .notification-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        background-color: #dc3545;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .navbar-toggler {
        border: none;
        padding: 0.25rem 0.5rem;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    .glass-navbar {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        background-color: rgba(255, 255, 255, 0.6);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: background-color 0.3s ease, backdrop-filter 0.3s ease;
    }

    .custom-navbar {
        background-color: transparent;
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
    }

    .custom-navbar.scrolled {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        padding: 1rem;
    }

    /* Mobile & Tablet Responsive Styles */
    @media (max-width: 991px) {
        .navbar-nav {
            padding-top: 1rem;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 12px;
            margin-top: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-item {
            text-align: center;
            margin: 0.25rem 0;
            padding: 0 1rem;
        }

        .navbar-nav .nav-link {
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            margin: 0.25rem 0;
        }

        .dropdown-menu {
            position: static !important;
            transform: none !important;
            box-shadow: none;
            border: none;
            background-color: rgba(255, 130, 67, 0.1);
            border-radius: 8px;
            margin-top: 0.5rem;
        }

        .navbar-nav .dropdown-menu .dropdown-item {
            text-align: left;
            padding: 0.5rem 1.5rem;
        }

        .btn-login {
            width: 100%;
            margin: 0.5rem 0;
            padding: 0.75rem 1.5rem;
        }

        .notification-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.75rem;
            margin: 0.25rem 0;
            border-radius: 8px;
            background-color: rgba(255, 130, 67, 0.1);
        }

        .profile-dropdown {
            display: flex;
            justify-content: center;
            padding: 0.5rem 0;
        }

        .navbar-brand-text {
            font-size: 1.25rem;
        }

        .custom-navbar {
            padding: 0.5rem 1rem;
        }

        .custom-navbar.scrolled {
            padding: 0.75rem 1rem;
        }

        /* Fix untuk dropdown menu di mobile */
        .navbar-nav .nav-item.dropdown .dropdown-menu {
            display: none;
        }

        .navbar-nav .nav-item.dropdown.show .dropdown-menu {
            display: block;
        }
    }

    /* Tablet specific adjustments */
    @media (min-width: 768px) and (max-width: 991px) {
        .navbar-nav {
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }

        .navbar-nav .nav-item {
            margin: 0.25rem 0.5rem;
        }

        .ms-auto {
            margin-top: 1rem !important;
            width: 100%;
            justify-content: center;
        }
    }

    /* Small mobile adjustments */
    @media (max-width: 576px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .navbar-brand-text {
            font-size: 1.1rem;
        }

        .navbar-nav {
            margin-top: 0.5rem;
            padding: 0.75rem;
        }

        .notification-badge {
            width: 16px;
            height: 16px;
            font-size: 0.6rem;
        }

        .profile-dropdown img {
            width: 35px;
            height: 35px;
        }
    }

    /* Smooth transitions */
    .navbar-collapse {
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        background-color: rgba(255, 130, 67, 0.1);
        border-radius: 8px;
    }

    @media (max-width: 991px) {
        .navbar-nav .nav-link:hover {
            transform: none;
            background-color: rgba(255, 130, 67, 0.15);
        }
    }
</style>

<nav class="navbar navbar-expand-lg fixed-top custom-navbar">
    <div class="container">
        <!-- Brand -->
        <div class="col-lg-2">
            <div class="header-logo">
                <a href="{{ route('home') }}" class="decoration-none">
                    <span class="text-#FF8243">Taste</span> of Indonesia
                </a>
            </div>
        </div>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="uil uil-bars fs-3"></i> 
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>

                <!-- About Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        About
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('home') }}#about">About Us</a></li>
                        <li><a class="dropdown-item" href="{{ route('home') }}#gallery">Gallery</a></li>
                        <li><a class="dropdown-item" href="{{ route('home') }}#qna">QnA</a></li>
                    </ul>
                </li>

                <!-- Services Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Services
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('tokorestoran') }}">Store & Restaurant</a></li>
                        <li><a class="dropdown-item" href="{{ route('home') }}#calendar">Calendar</a></li>
                        <li><a class="dropdown-item" href="{{ route('news.index') }}">News</a></li>
                    </ul>
                </li>

                <!-- Contact -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
                </li>
            </ul>

            <!-- Right Side Navigation -->
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Authentication -->
                @guest
                <li class="nav-item">
                    <button class="btn btn-login" type="button" onclick="window.location.href='{{ route('testimonial.login') }}'">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </li>
                @else

                <!-- Business Actions for Customers -->
                @if (auth()->user()->hasRole('customer'))
                @php
                $user = auth()->user();
                $hasBusiness = $user->business !== null;
                $hasPendingClaim = $user->businessClaim && $user->businessClaim->status === 'pending';
                @endphp

                @if (!$hasBusiness && !$hasPendingClaim)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Business
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('business.register') }}">
                                <i class="fas fa-plus-circle me-2"></i>Create Business
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('business.claim') }}">
                                <i class="fas fa-hand-paper me-2"></i>Claim Business
                            </a></li>
                    </ul>
                </li>
                @endif
                @endif

                <!-- Dashboard for Sellers -->
                @if (auth()->user()->hasRole('seller'))
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                @endif

                <!-- Notifications -->
                @php
                $unread = auth()->user()->notifications()->where('is_read', false)->count();
                @endphp
                <li class="nav-item">
                    <a href="{{ route('notifications.index') }}" class="notification-icon">
                        <i class="fas fa-bell"></i>
                        @if ($unread > 0)
                        <span class="notification-badge">{{ $unread }}</span>
                        @endif
                    </a>
                </li>

                <!-- User Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="profile-dropdown">
                            <img src="{{ auth()->user()->profile_image
                                    ? asset('storage/' . auth()->user()->profile_image)
                                    : asset('assets/images/default-profile.png') }}"
                                alt="Profile">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('testimonial.profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('testimonial.logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<script>
    // Scroll effect for navbar
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.custom-navbar');
        if (window.scrollY > 10) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Mobile dropdown handling
    document.addEventListener('DOMContentLoaded', function() {
        // Handle mobile dropdown clicks
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

        dropdownToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                if (window.innerWidth <= 991) {
                    e.preventDefault();
                    const parentItem = this.closest('.nav-item');
                    const isOpen = parentItem.classList.contains('show');

                    // Close all other dropdowns
                    document.querySelectorAll('.nav-item.dropdown.show').forEach(function(item) {
                        if (item !== parentItem) {
                            item.classList.remove('show');
                        }
                    });

                    // Toggle current dropdown
                    if (isOpen) {
                        parentItem.classList.remove('show');
                    } else {
                        parentItem.classList.add('show');
                    }
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 991) {
                const isClickInsideDropdown = e.target.closest('.nav-item.dropdown');
                if (!isClickInsideDropdown) {
                    document.querySelectorAll('.nav-item.dropdown.show').forEach(function(item) {
                        item.classList.remove('show');
                    });
                }
            }
        });

        // Handle navbar collapse on mobile link click
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link:not(.dropdown-toggle)');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991 && navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                        toggle: true
                    });
                }
            });
        });
    });
</script>