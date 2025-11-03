<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Taste of Indonesia Australia - Authentic Indonesian Food Guide, Restaurants & Shops</title>
    <meta name="description" content="Discover authentic Indonesian food in Australia. Find local Indonesian restaurants, halal eateries, traditional dishes, shops, events, and news on Taste of Indonesia. Your guide to Indonesian cuisine Down Under!">
    <meta name="keywords" content="Indonesian food Australia, Indonesian restaurants, halal Indonesian food, Taste of Indonesia, Indonesian cuisine, Indonesian shops">
    <meta name="author" content="Taste of Indonesia">
    <meta name="copyright" content="Taste of Indonesia Australia">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://tasteofindonesia.com.au/">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/logo.png') }}">

    <!-- Theme Color -->
    <meta name="theme-color" content="#e63946">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Taste of Indonesia Australia">
    <meta property="og:url" content="https://tasteofindonesia.com.au/">
    <meta property="og:title" content="Taste of Indonesia Australia - Authentic Indonesian Food Guide, Restaurants & Shops">
    <meta property="og:description" content="Discover authentic Indonesian food in Australia. Find local Indonesian restaurants, halal eateries, traditional dishes, shops, events, and news on Taste of Indonesia. Your guide to Indonesian cuisine Down Under!">
    <meta property="og:image" content="https://tasteofindonesia.com.au/assets/images/logo/logo.png">
    <meta property="og:image:alt" content="Taste of Indonesia Logo with Indonesian food spread">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://tasteofindonesia.com.au/">
    <meta name="twitter:title" content="Taste of Indonesia Australia - Authentic Indonesian Food Guide, Restaurants & Shops">
    <meta name="twitter:description" content="Discover authentic Indonesian food in Australia. Find local Indonesian restaurants, halal eateries, traditional dishes, shops, events, and news on Taste of Indonesia. Your guide to Indonesian cuisine Down Under!">
    <meta name="twitter:image" content="https://tasteofindonesia.com.au/assets/images/logo/logo.png">
    <meta name="twitter:image:alt" content="Taste of Indonesia Logo with Indonesian food spread">

    <!-- Hreflang -->
    <link rel="alternate" href="https://tasteofindonesia.com.au/" hreflang="en-au" />

    <!-- Structured Data -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Taste of Indonesia Australia",
            "url": "https://tasteofindonesia.com.au",
            "logo": "https://tasteofindonesia.com.au/assets/images/logo/logo.png",
            "sameAs": [
                "https://web.facebook.com/profile.php?id=61575256322990",
                "https://www.instagram.com/tasteofindonesia.com.au/"
            ]
        }
    </script>

    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- bootstrap  -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- for swiper slider  -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

    <!-- fancy box  -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <!-- custom css  -->
    <link rel="stylesheet" href="assets/css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="body-fixed">
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}', // Spasi dihilangkan
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    @endif
    
    @include('partials.navbar')

    <!-- Hero - Main Banner -->
    <section class="main-banner" id="home">
        <div class="js-parallax-scene">
            <!-- Parallax effect elements -->
            <div class="banner-shape-1 w-100" data-depth="0.30">
                <img src="assets/images/berry.png" alt="Berry Shape">
            </div>
            <div class="banner-shape-2 w-100" data-depth="0.25">
                <img src="assets/images/leaf.png" alt="Leaf Shape">
            </div>
        </div>
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-4 logo">
                        <!-- Logos Section -->
                        <img src="assets/images/logo/Logo-ICAV.png" alt="ICAV Logo" class="logo mx-3" style="width: 160px; height: auto;">
                        <img src="assets/images/logo/Logo-Atdag-Canberra.png" alt="Atdag Canberra Logo" class="logo mx-3" style="width: 240px; height: auto;">
                    </div>
                    <div class="col-lg-6">
                        <div class="banner-text">
                            <!-- Main Banner Text -->
                            <h1 class="h1-title">
                                Welcome to Website
                                <span>Taste</span>
                                <br> of Indonesia.
                            </h1>
                            <p>Discover authentic Indonesian food and grocery products in Australia.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner-img-wp">
                            <div class="banner-img banner-img-1"
                                style="background-image: url('{{ asset('assets/images/home/hero/hero.png') }}');">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Food Category -->
    <section class="book-table section bg-light">
        <!-- Decorative Shapes for Aesthetic Design -->
        <div class="book-table-shape">
            <img src="assets/images/table-leaves-shape.png" alt="Decorative Shape">
        </div>
        <div class="book-table-shape book-table-shape2">
            <img src="assets/images/table-leaves-shape.png" alt="Decorative Shape">
        </div>

        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Section Title -->
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">Explore Categories</p>
                            <h2 class="h2-title">Find Indonesian<br>Foods & Products Easily</h2>
                            <div class="sec-title-shape mb-4">
                                <img src="assets/images/title-shape.svg" alt="Title Shape">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Food Category Information -->
                <div class="book-table-info">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="call-now-side table-title text-center">
                                <i class="uil uil-coffee icon"></i>
                                <h3>Authentic</h3>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="call-now text-center">
                                <i class="uil uil-moon icon"></i>
                                <h3>Halal</h3>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="call-now-side table-title text-center">
                                <i class="uil uil-utensils icon"></i>
                                <h3>Traditional</h3>
                            </div>
                        </div>
                    </div>

                    <!-- row tambahan untuk produk shop -->
                    <div class="row align-items-center mt-4">
                        <div class="col-lg-4">
                            <div class="category-mini-divider"></div>
                            <div class="call-now-side text-center">
                                <i class="uil uil-pizza-slice icon"></i>
                                <h3>Snacks & Biscuits</h3>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="category-mini-divider"></div>
                            <div class="call-now text-center">
                                <i class="uil uil-restaurant icon"></i>
                                <h3>Noodles</h3>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="category-mini-divider"></div>
                            <div class="call-now-side text-center">
                                <i class="uil uil-coffee icon"></i>
                                <h3>Beverages</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: About Us -->
    <section class="about-sec section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Section Title -->
                    <div class="sec-title text-center mb-5">
                        <p class="sec-sub-title mb-3">About Us</p>
                        <div class="about_us">
                            <h2>What is</h2>
                            <h2>
                                <span class="rasa-text">Taste </span>of Indonesia?
                            </h2>
                        </div>
                        <div class="sec-title-shape mb-4">
                            <img src="assets/images/title-shape.svg" alt="Title Shape">
                        </div>
                        <!-- Description of Taste of Indonesia -->
                        <p>
                            Taste of Indonesia is your one-stop guide to authentic Indonesian culture in Australia — from food and beverages to unique products and specialty shops.
                        </p>
                        <p>
                            We connect you with Indonesian restaurants, cafés, grocery stores, and online shops offering traditional dishes, snacks, and handmade goods. You’ll also find reviews, recommendations, and shopping tips to make it easy to experience Indonesia’s rich flavors and products wherever you are.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="about-video">
                        <div class="about-video-img-wrap">
                            <div class="about-video-img"
                                style="background-image: url('{{ asset('assets/images/home/about-us/images.png') }}');">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Shop & Restaurant List -->
    <section style="background-image: url(assets/images/menu-bg.png);" class="our-menu section bg-light repeat-img" id="menu">
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Section Title -->
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">Shop & Restaurant</p>
                            <h2 class="h2-title">Find List of <span>Shop & Restaurant Here!</span></h2>
                            <div class="sec-title-shape mb-4">
                                <img src="assets/images/title-shape.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map -->
                <section class="about-sec section">
                    <div class="scrapping-map-wrapper">

                        <div class="how-to-use">
                            <div class="tutorial-header">
                                <h4 class="tutorial-title">How to Use</h4>
                                <p class="tutorial-subtitle">
                                    Discover amazing Indonesian cuisine near you with our
                                    interactive map. Follow these simple steps to get started!
                                </p>
                            </div>

                            <div class="tutorial-grid">
                                <div class="tutorial-item">
                                    <span class="tutorial-icon">📍</span>
                                    <h4>Find Your Location</h4>
                                    <p>
                                        Click <b>My Location</b> to detect your current
                                        position. Allow location permission when prompted for
                                        the best experience.
                                    </p>
                                </div>

                                <div class="tutorial-item">
                                    <span class="tutorial-icon">📏</span>
                                    <h4>Set Your Radius</h4>
                                    <p>
                                        Choose a <b>Radius</b> (5km, 10km, or 20km) to filter
                                        and discover Indonesian restaurants within your
                                        preferred distance.
                                    </p>
                                </div>

                                <div class="tutorial-item">
                                    <span class="tutorial-icon">🗺️</span>
                                    <h4>Explore Details</h4>
                                    <p>
                                        Click any marker to view restaurant details, customer
                                        ratings, photo galleries, and authentic Indonesian
                                        cuisine offerings.
                                    </p>
                                </div>

                                <div class="tutorial-item">
                                    <span class="tutorial-icon">🚗</span>
                                    <h4>Get Directions</h4>
                                    <p>
                                        Use the <b>Directions</b> button to open navigation in
                                        your preferred maps app and find the quickest route to
                                        your chosen restaurant.
                                    </p>
                                </div>
                            </div>

                            <div class="permission-section">
                                <h3 class="permission-title">🔐 Enable Location Permission</h3>
                                <p class="permission-subtitle">
                                    Follow these steps to allow location access for the best map
                                    experience:
                                </p>

                                <div class="permission-grid">
                                    <div class="permission-device">
                                        <div class="device-header">
                                            <span class="device-icon">📱</span>
                                            <h4 class="device-title">Mobile Device</h4>
                                        </div>
                                        <ol class="permission-steps">
                                            <li>
                                                Tap the <b>lock icon</b> or
                                                <b>site info icon</b> in your browser's address
                                                bar
                                            </li>
                                            <li>
                                                Select <b>Permissions</b>, <b>Site settings</b>,
                                                or <b>Page info</b>
                                            </li>
                                            <li>
                                                Find <b>Location</b> and change it to
                                                <b>Allow</b> or <b>Enable</b>
                                            </li>
                                            <li>
                                                Refresh the page and click
                                                <b>My Location</b> again
                                            </li>
                                        </ol>
                                    </div>

                                    <div class="permission-device">
                                        <div class="device-header">
                                            <span class="device-icon">💻</span>
                                            <h4 class="device-title">Desktop Browser</h4>
                                        </div>
                                        <ol class="permission-steps">
                                            <li>
                                                Click the <b>lock icon</b> or
                                                <b>shield icon</b> in the browser address bar
                                            </li>
                                            <li>
                                                Look for <b>Location permissions</b> in the
                                                dropdown menu
                                            </li>
                                            <li>
                                                Select <b>Allow</b> or <b>Always allow</b> for
                                                this site
                                            </li>
                                            <li>
                                                Reload the page and try the location feature
                                                again
                                            </li>
                                        </ol>
                                    </div>
                                </div>

                                <div class="quick-tips">
                                    <h4>💡 Quick Tips</h4>
                                    <p>
                                        If you're still having issues, try clearing your browser
                                        cache, checking if location services are enabled on your
                                        device, or using a different browser. Most modern
                                        browsers support location services for a better user
                                        experience.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="filter-bar">
                            <div class="filter-group">
                                <label for="radius-select">Radius:</label>
                                <select id="radius-select" class="form-select form-select-sm">
                                    <option value="5">5 km</option>
                                    <option value="10" selected>10 km</option>
                                    <option value="20">20 km</option>
                                </select>
                            </div>
                            <button id="stop-location" class="btn-show-all">
                                🔄 Show All
                            </button>
                        </div>

                        <div id="map" style="width: 100%; height: 500px; border-radius: 10px; overflow: hidden;"></div>
                    </div>
                </section>

                <!-- Category Filters -->
                <div class="menu-tab-wp">
                    <div class="row">
                        <div class="col-lg-12 m-auto">
                            <div class="menu-tab text-center">
                                <ul class="filters">
                                    <div class="filter-active"></div>
                                    <li class="filter" data-filter=".all">
                                        <img src="assets/images/icon-all.png" alt="" class="icon-filter">
                                        All
                                    </li>
                                    <li class="filter" data-filter=".shop">
                                        <img src="assets/images/toko.png" alt="" class="icon-filter">
                                        Shop
                                    </li>
                                    <li class="filter" data-filter=".restaurant">
                                        <img src="assets/images/restoran.png" alt="" class="icon-filter">
                                        Restaurant
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shop and Restaurant Listings -->
                <div class="menu-list-row">
                    <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                        @foreach($businesses as $business)
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
                                    <h3 class="h3-title d-inline-block">
                                        {{ $business->name }}
                                    </h3>
                                    <br>

                                    {{-- Status buka/tutup toko --}}
                                    @if ($business->is_open)
                                    <span class="badge bg-primary text-light ms-2" style="font-size: 0.7rem;">
                                        Open Now
                                    </span>
                                    @else
                                    <span class="badge bg-secondary text-light ms-2" style="font-size: 0.7rem;">
                                        Closed Now
                                    </span>
                                    @endif

                                    {{-- Status order di platform --}}
                                    @if ($business->orders_status === 'approved')
                                    <span class="badge bg-success text-light ms-2" style="font-size: 0.7rem;">
                                        Order Available
                                    </span>
                                    @elseif ($business->orders_status === 'pending')
                                    <span class="badge bg-warning text-dark ms-2" style="font-size: 0.7rem;">
                                        Order Pending
                                    </span>
                                    @else
                                    <span class="badge bg-dark text-light ms-2" style="font-size: 0.7rem;">
                                        Not Accepting Orders
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
                        @endforeach
                    </div>
                </div>

                <!-- View All Button -->
                <div class="button-container">
                    <a href="{{ route('tokorestoran') }}" class="view-all-button">View All</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery  -->
    <section class="book-table section bg-light" id="gallery">
        <div class="book-table-shape">
            <img src="assets/images/table-leaves-shape.png" alt="">
        </div>

        <div class="book-table-shape book-table-shape2">
            <img src="assets/images/table-leaves-shape.png" alt="">
        </div>

        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">Gallery</p>
                            <div class="about_us">
                                <h2>Here is the</h2>
                                <h2>
                                    Gallery <span class="rasa-text"> Taste </span>of Indonesia
                                </h2>
                            </div>
                            <div class="sec-title-shape mb-4">
                                <img src="assets/images/title-shape.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="book-table-img-slider" id="icon">
                            <div class="swiper-wrapper">
                                @foreach($galleries as $gallery)
                                <a href="{{ asset('storage/' . $gallery->image) }}" data-fancybox="table-slider"
                                    class="book-table-img back-img swiper-slide"
                                    style="background-image: url('{{ asset('storage/' . $gallery->image) }}')"
                                    loading="lazy">
                                </a>
                                @endforeach
                            </div>
                            <div class="swiper-button-wp">
                                <div class="swiper-button-prev swiper-button">
                                    <i class="uil uil-angle-left"></i>
                                </div>
                                <div class="swiper-button-next swiper-button">
                                    <i class="uil uil-angle-right"></i>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- QnA  -->
    <section class="faq-sec section-repeat-img" style="background-image: url(assets/images/faq-bg.png);" id="qna">
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">qna</p>
                            <h2 class="h2-title">Frequently Asked <span>Questions</span></h2>
                            <div class="sec-title-shape mb-4">
                                <img src="assets/images/title-shape.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-row">
                    @foreach($qna as $qna)
                    <div class="faq-box">
                        <h4 class="h4-title">{{ $qna->question }}</h4>
                        <p>{{ $qna->answer }}</p>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

    </section>

    <!-- Calendar  -->
    <section class="faq-sec section bg-light" id="calendar">
        <div class="row">
            <div class="col-lg-12">
                <div class="sec-title text-center mb-5">
                    <p class="sec-sub-title mb-3">CALENDAR OF EVENTS</p>
                    <div class="about_us">
                        <h2>Calendar of </h2>
                        <h2>
                            Events<span class="rasa-text"> Taste </span>of Indonesia
                        </h2>
                    </div>
                    <div class="sec-title-shape mb-4">
                        <img src="assets/images/title-shape.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($events->count())
    <section id="tranding" class="calendar section bg-light">
        <div class="container-card-calendar">
            <div class="swiper tranding-slider">
                <div class="swiper-wrapper">
                    <!-- Slide-start -->
                    @foreach ($events as $event)
                    <div class="swiper-slide tranding-slide">
                        <div class="tranding-slide-img">
                            <img src="{{ asset('storage/' . $event->image_events) }}" alt="Tranding" />
                        </div>
                        <div class="tranding-slide-content">
                            <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="link-calendar">
                                <h1 class="food-price">{{ $event->type_events }}</h1>
                                <div class="desc">
                                    <div class="location">
                                        <i class="fa-solid fa-location-dot"></i> {{ $event->place_name }}
                                    </div>
                                    <div class="title-calendar">{{ $event->title }}</div>
                                    <div class="time">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('j F Y - \a\t gA') }}
                                        to
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('gA') }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach

                    <!-- Slide-end -->

                </div>

                <div class="swiper-button-wp-calendar">
                    <div class="swiper-button-prev swiper-button">
                        <i class="uil uil-angle-left"></i>
                    </div>
                    <div class="swiper-button-next swiper-button">
                        <i class="uil uil-angle-right"></i>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    @else
    <section class="faq-sec section bg-light text-center">
        <h3>No upcoming events for now. Stay tuned!</h3>
    </section>
    @endif

    <!-- News  -->
    <section class="faq-sec section-repeat-img" style="background-image: url(assets/images/faq-bg.png);" id="news">
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">news</p>
                            <div class="about_us">
                                <h2>News About </h2>
                                <h2>
                                    <span class="rasa-text"> Taste </span>of Indonesia
                                </h2>
                            </div>
                            <div class="sec-title-shape mb-4">
                                <img src="assets/images/title-shape.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="collection">
        <div class="swiper-container mySwiper">
            <div class="swiper-wrapper">
                @foreach ($news as $item)
                <div class="content-news swiper-slide">
                    <img src="{{ asset('storage/' . $item->image_news) }}" alt="{{ $item->title }}">
                    <div class="text-content">
                        <h3>{{ Str::limit(strip_tags($item->title), 20) }}</h3>
                        <p>{{ Str::limit(strip_tags($item->desc), 100) }}</p>
                        <div class="button-container-news">
                            <a href="{{ route('news.show', $item->slug) }}" class="view-all-button-news">
                                Read More <span class="visually-hidden">about {{ $item->title }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="swiper-button-wp-news">
                <div class="swiper-button-prev swiper-button">
                    <i class="uil uil-angle-left"></i>
                </div>
                <div class="swiper-button-next swiper-button">
                    <i class="uil uil-angle-right"></i>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <div class="button-container-news-view-all">
        <a href="{{ route('news.index') }}" class="view-all-button-news-view-all">
            View All <span class="visually-hidden">news articles</span>
        </a>
    </div>

    <!-- Contact Customer Service -->
    <div class="bg-pattern bg-light repeat-img"
        style="background-image: url(assets/images/blog-pattern-bg.png);">

        <section class="newsletter-sec section pt-0" id="contact">
            <div class="sec-wp">
                <div class="container-calendar">
                    <div class="row">
                        <div class="col-lg-8 m-auto">
                            <div class="newsletter-box text-center back-img white-text"
                                style="background-image: url(assets/images/news.jpg);">
                                <div class="bg-overlay dark-overlay"></div>
                                <div class="sec-wp">
                                    <div class="newsletter-box-text">
                                        <h2 class="h2-title">Contact Customer Service</h2>
                                        <p>If you have any questions or need assistance,
                                            please reach out to our customer service team.</p>
                                    </div>
                                    <div class="contact-icons">
                                        <a href="https://web.facebook.com/TradeAttache?_rdc=1&_rdr#" target="_blank">
                                            <i class="uil uil-facebook-f"></i>
                                        </a>
                                        <a href="https://www.instagram.com/atdag_canberra/" target="_blank">
                                            <i class="uil uil-instagram"></i>
                                        </a>
                                        <a href="https://www.youtube.com/@atdag_canberra" target="_blank">
                                            <i class="uil uil-youtube"></i>
                                        </a>
                                        <a href="https://www.tiktok.com/@atdag_canberra" target="_blank">
                                            <i class="fab fa-tiktok"></i>
                                        </a>
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

    <script src="assets/js/jquery-3.5.1.min.js" defer></script>
    <script src="assets/js/bootstrap.min.js" defer></script>
    <script src="assets/js/popper.min.js" defer></script>

    <script src="assets/js/font-awesome.min.js" defer></script>

    <script src="assets/js/swiper-bundle.min.js" defer></script>

    <script src="assets/js/jquery.mixitup.min.js" defer></script>

    <script src="assets/js/jquery.fancybox.min.js" defer></script>

    <script src="assets/js/parallax.min.js" defer></script>

    <script src="assets/js/gsap.min.js" defer></script>

    <script src="assets/js/ScrollTrigger.min.js" defer></script>
    <script src="assets/js/ScrollToPlugin.min.js" defer></script>
    <script src="assets/js/smooth-scroll.js" defer></script>
    <script src="assets/main.js" defer></script>

    <script>
        let map; // 🔹 Global supaya bisa diakses semua function
        let markers = [];
        let userMarker = null;
        let userCircle = null;
        let directionsService;
        let directionsRenderer;

        function initMap() {
            const defaultLocation = {
                lat: -25.6545305,
                lng: 133.9214759
            };

            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 4,
            });

            // Tambahkan ini supaya directions bisa dipakai
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                map
            });

            addLocationButton(map);

            // 🔹 Kalau ada lokasi tersimpan → load marker
            const savedLocation = localStorage.getItem("userLocation");
            if (savedLocation) {
                const userLocation = JSON.parse(savedLocation);
                addUserMarkerAndCircle(userLocation, map);
                fetchNearbyBusinesses(userLocation, map);
            } else {
                fetchNearbyBusinesses(null, map); // 🔹 Default tampilkan semua
            }

            // 🔹 Event ganti radius (kalau ada lokasi user)
            document.getElementById("radius-select").addEventListener("change", () => {
                const savedLoc = localStorage.getItem("userLocation");
                if (!savedLoc) return;
                const userLocation = JSON.parse(savedLoc);
                addUserMarkerAndCircle(userLocation, map);
                fetchNearbyBusinesses(userLocation, map);
            });

            // 🔹 Tombol Show All
            document.getElementById("stop-location").addEventListener("click", () => {
                localStorage.removeItem("userLocation"); // Hapus lokasi tersimpan

                if (userMarker) userMarker.setMap(null);
                if (userCircle) userCircle.setMap(null);

                fetchNearbyBusinesses(null, map); // Ambil semua bisnis
            });
        }

        function addUserMarkerAndCircle(location, map) {
            const radius = parseInt(document.getElementById("radius-select").value) * 1000;

            if (userMarker) userMarker.setMap(null);
            if (userCircle) userCircle.setMap(null);

            userMarker = new google.maps.Marker({
                position: location,
                map,
                title: "Your Location",
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                }
            });

            userCircle = new google.maps.Circle({
                strokeColor: "#007bff",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#007bff",
                fillOpacity: 0.2,
                map,
                center: location,
                radius: radius
            });

            // ✅ Biar map otomatis nge-zoom sesuai radius
            const bounds = userCircle.getBounds();
            if (bounds) {
                map.fitBounds(bounds);
            }
        }

        function addLocationButton(map) {
            const locationButton = document.createElement("button");
            locationButton.textContent = "📍 My Location";
            locationButton.classList.add("custom-map-control-button");
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(locationButton);

            locationButton.addEventListener("click", () => {
                Swal.fire({
                    title: "Use your location?",
                    text: "We will use your location to show nearby businesses.",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes, use it",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const userLocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };

                                localStorage.setItem("userLocation", JSON.stringify(userLocation));

                                addUserMarkerAndCircle(userLocation, map);
                                fetchNearbyBusinesses(userLocation, map);
                            },
                            () => Swal.fire("Failed", "Unable to retrieve your location.", "error")
                        );
                    } else {
                        Swal.fire("Error", "Your browser does not support geolocation.", "error");
                    }
                });
            });
        }

        function fetchNearbyBusinesses(location, map) {
            // 🔹 Hapus marker lama
            markers.forEach(marker => marker.setMap(null));
            markers = [];

            let url = "/api/nearby-businesses";
            if (location && location.lat && location.lng) {
                const radius = document.getElementById("radius-select").value;
                url += `?lat=${location.lat}&lng=${location.lng}&radius=${radius}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log("Data from API:", data);

                    if (!Array.isArray(data) || data.length === 0) {
                        console.warn("No businesses found.");
                        return;
                    }

                    const bounds = new google.maps.LatLngBounds();

                    data.forEach(business => {
                        if (!business.latitude || !business.longitude) return;

                        const position = {
                            lat: parseFloat(business.latitude),
                            lng: parseFloat(business.longitude),
                        };

                        // 🔹 Tombol Order hanya muncul kalau status approved
                        const orderButton = (business.orders_status ?? business.ordersStatus ?? '').toLowerCase() === 'approved' ?
                            `<a href="/business/${business.slug}/menu" class="btn-maps btn-order">Order Now</a>` :
                            ''; // kalau bukan approved, jangan tampilkan apa-apa

                        const marker = new google.maps.Marker({
                            position,
                            map: map,
                            title: business.name,
                            label: {
                                text: business.name,
                                color: "#fff",
                                fontSize: "14px",
                                fontWeight: "bold",
                                className: "marker-label",
                            },
                        });

                        markers.push(marker);
                        bounds.extend(position);

                        const infoWindow = new google.maps.InfoWindow({
                            content: `
                            <div class="card-marker">
                                <div class="gallery-swiper">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            ${business.galleries.map(g => `
                                                <div class="swiper-slide">
                                                    <img src="${g.image}" alt="${g.title}" />
                                                </div>
                                            `).join('')}
                                        </div>
                                        <div class="swiper-pagination-maps"></div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-title">${business.name}</div>
                                    <div class="rating">
                                        ${renderStars(business.average_rating)}
                                        <span>${business.average_rating.toFixed(1)}</span>
                                        <span>(${business.total_responses} reviews)</span>
                                    </div>
                                    <div class="info">${business.type?.title || 'N/A'}</div>
                                    <div class="buttons-maps">
                                        <a href="/business/${business.slug}" target="_blank" class="btn-maps btn-details">Details</a>
                                        ${orderButton}
                                        <button onclick="getDirections(${business.latitude}, ${business.longitude})" class="btn-maps btn-route">Directions</button>
                                        <a href="https://www.google.com/maps?q=${business.latitude},${business.longitude}" target="_blank" class="btn-maps btn-view-map">View in Google Maps</a>
                                    </div>
                                </div>
                            </div>
                        `,
                            maxWidth: 300,
                        });

                        marker.addListener("click", () => {
                            infoWindow.open(map, marker);
                            setTimeout(() => {
                                new Swiper('.swiper-container', {
                                    pagination: {
                                        el: '.swiper-pagination-maps',
                                        clickable: true
                                    },
                                    loop: true,
                                });
                            }, 500);
                        });
                    });

                    // 🔹 Kalau tidak ada lokasi → auto fit semua marker
                    if (!location && data.length > 0) {
                        map.fitBounds(bounds);
                    }
                })
                .catch(error => console.error("Error fetching businesses:", error));
        }

        function getDirections(destLat, destLng) {
            const savedLoc = localStorage.getItem("userLocation");

            if (!savedLoc) {
                Swal.fire({
                    icon: "warning",
                    title: "Location not found",
                    text: "Please enable your location first before viewing directions."
                });
                return;
            }

            const userLocation = JSON.parse(savedLoc);
            const request = {
                origin: userLocation,
                destination: {
                    lat: parseFloat(destLat),
                    lng: parseFloat(destLng)
                },
                travelMode: google.maps.TravelMode.DRIVING,
            };

            directionsService.route(request, (result, status) => {
                if (status === "OK") {
                    directionsRenderer.setDirections(result);
                } else {
                    console.warn("Directions API failed:", status);
                    // 🔹 Fallback: Open Google Maps directly
                    const url = `https://www.google.com/maps/dir/${userLocation.lat},${userLocation.lng}/${destLat},${destLng}`;
                    window.open(url, "_blank");
                }
            });
        }

        /**
         * Generates star ratings based on a given number.
         */
        function renderStars(rating) {
            const stars = Math.round(rating);
            const fullStars = '&#9733;'.repeat(stars);
            const emptyStars = '&#9734;'.repeat(5 - stars);
            return `${fullStars}${emptyStars}`;
        }

        // Initialize the map when the page loads
        window.onload = initMap;
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap"></script>

</body>

</html>