<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Indonesian Shops & Restaurants in Australia | Taste of Indonesia</title>
    <meta name="description" content="Find the best Indonesian restaurants and shops in Australia. Explore halal food spots, grocery stores, and authentic Indonesian cuisine near you.">
    <meta name="keywords" content="Indonesian restaurants Australia, Indonesian shops, halal Indonesian food, Indonesian groceries, Taste of Indonesia">
    <meta name="author" content="Taste of Indonesia">
    <meta name="copyright" content="Taste of Indonesia Australia">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://tasteofindonesia.com.au/store-and-restaurant">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/logo.png') }}">

    <!-- Theme Color -->
    <meta name="theme-color" content="#e63946">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Taste of Indonesia Australia">
    <meta property="og:url" content="https://tasteofindonesia.com.au/store-and-restaurant">
    <meta property="og:title" content="Indonesian shops & Restaurants in Australia | Taste of Indonesia">
    <meta property="og:description" content="Find the best Indonesian restaurants and shops in Australia. Explore halal food spots, grocery shops, and authentic Indonesian cuisine near you.">
    <meta property="og:image" content="https://tasteofindonesia.com.au/assets/images/logo/logo.png">
    <meta property="og:image:alt" content="Taste of Indonesia Logo with Indonesian food spread">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://tasteofindonesia.com.au/store-and-restaurant">
    <meta name="twitter:title" content="Indonesian Stores & Restaurants in Australia | Taste of Indonesia">
    <meta name="twitter:description" content="Find the best Indonesian restaurants and stores in Australia. Explore halal food spots, grocery stores, and authentic Indonesian cuisine near you.">
    <meta name="twitter:image" content="https://tasteofindonesia.com.au/assets/images/logo/logo.png">
    <meta name="twitter:image:alt" content="Taste of Indonesia Logo with Indonesian food spread">

    <!-- Hreflang -->
    <link rel="alternate" href="https://tasteofindonesia.com.au/store-and-restaurant" hreflang="en-au" />

    <!-- Structured Data -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebPage",
            "name": "Indonesian Stores & Restaurants in Australia | Taste of Indonesia",
            "url": "https://tasteofindonesia.com.au/store-and-restaurant",
            "description": "Find the best Indonesian restaurants and stores in Australia. Explore halal food spots, grocery stores, and authentic Indonesian cuisine near you.",
            "publisher": {
                "@type": "Organization",
                "name": "Taste of Indonesia Australia",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://tasteofindonesia.com.au/assets/images/logo/logo.png"
                }
            }
        }
    </script>

    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootstrap  -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- fancy box  -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
    <!-- custom css  -->
    <link rel="stylesheet" href="assets/css/tokorestoran.css">

</head>

<body>

    <body class="body-fixed">
        @include('partials.navbar')

        <div id="viewport">
            <div id="js-scroll-content">

                <!-- shops & Restaurant Section -->
                <section style="background-image: url(assets/images/menu-bg.png);" class="our-menu section bg-light repeat-img" id="menu">
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <!-- Logo Section -->
                                <div class="col-lg-12 text-center mb-4">
                                    <div class="logo-container">
                                        <img src="{{ asset('assets/images/logo/Logo-ICAV.png') }}" alt="Logo 1" class="logo mx-3" style="width: 80px; height: auto;">
                                        <img src="{{ asset('assets/images/logo/Logo-Atdag-Canberra.png') }}" alt="Logo 2" class="logo mx-3" style="width: 100px; height: auto;">
                                    </div>
                                </div>
                                <!-- Section Title -->
                                <div class="col-lg-12">
                                    <div class="sec-title text-center mb-5">
                                        <p class="sec-sub-title mb-3">Shop & Restaurant</p>
                                        <h2 class="h2-title">Find List of<span>Shop & Restaurant Here!</span></h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="assets/images/title-shape.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filters Section -->
                            <div class="menu-tab-wp">
                                <div class="row">
                                    <div class="col-lg-12 m-auto">
                                        <div class="menu-tab text-center">
                                            <ul class="filters">

                                                <!-- Dropdown for Country -->
                                                <li class="filter">
                                                    <select id="country" class="form-select">
                                                        <option value="all" {{ request('country') == 'all' ? 'selected' : '' }}>All Countries</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                                            {{ $country }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </li>

                                                <!-- Dropdown for City -->
                                                <li class="filter">
                                                    <select id="city" class="form-select">
                                                        <option value="all" {{ request('city') == 'all' ? 'selected' : '' }}>All Cities</option>
                                                        @foreach ($cities as $city)
                                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                                            {{ $city }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </li>

                                                <!-- Dropdown for Food Categories -->
                                                <li class="filter">
                                                    <select id="food-category" class="form-select">
                                                        <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Categories</option>
                                                        @foreach ($foodCategories as $category)
                                                        <option value="{{ strtolower($category->title) }}" {{ request('category') == strtolower($category->title) ? 'selected' : '' }}>
                                                            {{ $category->title }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </li>

                                                <!-- Dropdown for Sorting -->
                                                <li class="filter">
                                                    <select id="sort-order" class="form-select">
                                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                                    </select>
                                                </li>

                                                <!-- Dropdown for Business Types -->
                                                <li class="filter">
                                                    <select id="business-type" class="form-select">
                                                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                                                        @foreach ($businessTypes as $type)
                                                        <option value="{{ strtolower($type->title) }}" {{ request('type') == strtolower($type->title) ? 'selected' : '' }}>
                                                            {{ $type->title }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </li>

                                                <!-- Dropdown for Orders Status -->
                                                <li class="filter">
                                                    <select id="orders-status" class="form-select">
                                                        <option value="all" {{ request('orders_status') == 'all' ? 'selected' : '' }}>All Status</option>
                                                        <option value="approved" {{ request('orders_status') == 'approved' ? 'selected' : '' }}>Open Order</option>
                                                    </select>
                                                </li>

                                                <!-- Search Field -->
                                                <li class="filter">
                                                    <input type="text" id="search-keyword" class="form-control" placeholder="Search Here" value="{{ request('keyword') }}">
                                                </li>

                                                <!-- Search Button -->
                                                <li class="filter">
                                                    <button id="search-button" class="btn btn-primary">Search Data</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shop and Restaurant Listings -->
                            <div class="menu-list-row">
                                <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                                    @forelse($businesses as $business)
                                    <div class="col-lg-4 col-sm-6 dish-box-wp all {{ strtolower($business->type->title ?? 'all') }}" data-cat="{{ strtolower($business->type->title ?? 'all') }}">
                                        <div class="dish-box text-center">
                                            <!-- Business Logo -->
                                            <div class="dist-img">
                                                <img src="{{ $business->logo ? asset('storage/' . $business->logo) : asset('assets/images/logo/logo.png') }}" alt="{{ $business->name_business }}" loading="lazy">
                                            </div>
                                            <!-- Business Rating -->
                                            <div class="dish-rating">
                                                {{ number_format($business->average_rating, 1) }}
                                                <i class="uil uil-star"></i>
                                            </div>
                                            <!-- Business Title -->
                                            <div class="dish-title">
                                                <h3 class="h3-title">
                                                    {{ $business->name }}
                                                </h3>
                                                @if ($business->orders_status === 'approved')
                                                <span class="badge bg-success text-light" style="font-size: 0.7rem; margin-left: 5px;">
                                                    Open Order
                                                </span>
                                                @endif
                                                <!-- Menampilkan Unique Code -->
                                                <a href="{{ asset('storage/' . $business->document) }}" target="_blank">
                                                    <p>{{ $business->unique_code ?? '' }}</p>
                                                </a>
                                                <p>{{ $business->type->title ?? 'N/A' }}</p>
                                            </div>
                                            <!-- Business Info -->
                                            <div class="info-container">
                                                <div class="info-item">
                                                    <i class="uil uil-location-point"></i>
                                                    <div>
                                                        @if($business->address)
                                                        <p>{{ $business->address }}</p>
                                                        @if($business->pickupLocations->count() > 0)
                                                        <small class="text-muted">
                                                            Pickup locations available at:
                                                            @foreach($business->pickupLocations as $pickup)
                                                            {{ $pickup->name }}@if(!$loop->last), @endif
                                                            @endforeach
                                                        </small>
                                                        @endif
                                                        @elseif($business->pickupLocations->count() > 0)
                                                        <p>
                                                            <small class="text-muted">
                                                                No main address available. Pickup locations available at:
                                                            </small>
                                                            @foreach($business->pickupLocations as $pickup)
                                                            {{ $pickup->name }}@if(!$loop->last), @endif
                                                            @endforeach
                                                        </p>
                                                        @else
                                                        <p>No address available</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="info-item">
                                                    <i class="uil uil-utensils"></i>
                                                    <p>
                                                        @forelse ($business->food_categories as $category)
                                                        {{ $category->title }}{{ !$loop->last ? ', ' : '' }}
                                                        @empty
                                                        <span class="text-muted" style="font-size: 0.85rem;">
                                                            No categories available
                                                        </span>
                                                        @endforelse
                                                    </p>
                                                </div>
                                            </div>

                                            <hr>
                                            <!-- Business Actions -->
                                            <div class="menu-tab text-center">
                                                <ul>
                                                    <div class="filter-active-data"></div>
                                                    <li class="filter-data active">
                                                        <a href="{{ route('business.show', $business->slug) }}">
                                                            <img src="assets/images/icon-all.png" alt="Filter All" class="icon-filter">
                                                            Details
                                                        </a>
                                                    </li>
                                                    <li>
                                                        @if ($business->orders_status === 'approved')
                                                        <a href="{{ route('business.menu', $business->slug) }}"
                                                            class="cta-button order-now">
                                                            <img src="/assets/images/order.png" alt="Order Now" class="icon-filter">
                                                            Order
                                                        </a>
                                                        @else
                                                        <a href="{{ $business->location }}" target="_blank"
                                                            class="cta-button maps-link">
                                                            <img src="/assets/images/toko.png" alt="Filter Store" class="icon-filter">
                                                            Maps
                                                        </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    {{-- Tampilan jika tidak ada data --}}
                                    <div class="col-12">
                                        <div class="alert alert-warning text-center py-4">
                                            <h5 class="mt-3 mb-0">No business found for this filter.</h5>
                                            <small class="text-muted">Try changing your search filters.</small>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact Section -->
                <div class="bg-pattern bg-light repeat-img" style="background-image: url(assets/images/blog-pattern-bg.png);">

                    <section class="newsletter-sec section pt-0" id="contact">
                        <div class="sec-wp">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-8 m-auto">
                                        <!-- Newsletter Box -->
                                        <div class="newsletter-box text-center back-img white-text" style="background-image: url(assets/images/news.jpg);">
                                            <div class="bg-overlay dark-overlay"></div>
                                            <div class="sec-wp">
                                                <!-- Contact Information -->
                                                <div class="newsletter-box-text">
                                                    <h2 class="h2-title">Want to add your business?</h2>
                                                    <p>Please contact us and tell us details about your business.</p>
                                                </div>
                                                <!-- Contact Icons -->
                                                <div class="contact-icons">
                                                    <a href="https://wa.me/your-number" target="_blank"><i class="uil uil-whatsapp"></i></a>
                                                    <a href="mailto:your-email@example.com"><i class="uil uil-envelope"></i></a>
                                                    <a href="https://instagram.com/your-profile" target="_blank"><i class="uil uil-instagram"></i></a>
                                                    <a href="https://facebook.com/your-profile" target="_blank"><i class="uil uil-facebook"></i></a>
                                                    <a href="tel:+1234567890"><i class="uil uil-phone"></i></a>
                                                    <a href="https://t.me/your-profile" target="_blank"><i class="uil uil-telegram"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                @include('partials.footer')

            </div>
        </div>

        <!-- jquery  -->
        <script src="assets/js/jquery-3.5.1.min.js"></script>
        <!-- bootstrap -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/popper.min.js"></script>

        <!-- fontawesome  -->
        <script src="assets/js/font-awesome.min.js"></script>

        <!-- mixitup -- filter  -->
        <script src="assets/js/jquery.mixitup.min.js"></script>

        <!-- fancy box  -->
        <script src="assets/js/jquery.fancybox.min.js"></script>

        <!-- parallax  -->
        <script src="assets/js/parallax.min.js"></script>

        <!-- gsap  -->
        <script src="assets/js/gsap.min.js"></script>

        <!-- scroll trigger  -->
        <script src="assets/js/ScrollTrigger.min.js"></script>
        <!-- scroll to plugin  -->
        <script src="assets/js/ScrollToPlugin.min.js"></script>
        <!-- rellax  -->
        <!-- <script src="assets/js/rellax.min.js"></script> -->
        <!-- <script src="assets/js/rellax-custom.js"></script> -->
        <!-- smooth scroll  -->
        <script src="assets/js/smooth-scroll.js"></script>
        <!-- custom js  -->
        <script src="assets/main.js"></script>

        <script>
            /**
             * Dropdown Menu Script
             * This script handles the visibility of a dropdown menu when a profile image is clicked.
             * It also ensures that the dropdown closes when clicking outside of the menu.
             */

            /**
             * Toggles the visibility of the dropdown menu.
             * If the menu is visible, it hides it; otherwise, it shows it.
             */
            function toggleDropdown() {
                const menu = document.getElementById('dropdownMenu');
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            }

            /**
             * Closes the dropdown menu when clicking outside of it.
             */
            window.addEventListener('click', function(event) {
                const dropdown = document.getElementById('dropdownMenu');
                const profileImage = document.querySelector('.profile-image');

                // Check if the click is outside the profile image and dropdown menu
                if (!profileImage.contains(event.target)) {
                    dropdown.style.display = 'none';
                }
            });
        </script>

    </body>
</body>

</html>