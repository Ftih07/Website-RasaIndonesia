<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Taste of Indonesia</title>

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
</head>

<body class="body-fixed">
    <!-- Overlay Countdown -->
    <div id="countdown-overlay" class="overlay">
        <div class="countdown-container">
            <!-- LOGO SECTION -->
            <div class="logo-section">
                <img src="assets/images/logo/Logo-Atdag-Canberra-background.png" alt="Atase Perdagangan Canberra" />
                <img src="assets/images/logo/Logo-ICAV-background.png" alt="ICAV" />
            </div>

            <!-- LAUNCHING TEXT -->
            <p class="launching-text">LAUNCHING SOON WEBSITE</p>

            <!-- TITLE -->
            <h1 class="title">
                <span class="highlight">Taste</span> of Indonesia
            </h1>

            <!-- COUNTDOWN -->
            <div id="countdown"></div>

            <!-- BUTTONS -->
            <div class="buttons">
                <button id="enter-button" class="btn btn-enter" onclick="hideCountdown()">
                    Enter Website
                </button>
                <a href="#" class="btn btn-try" onclick="hideCountdown()">
                    Try Now
                </a>
            </div>

            <!-- DESCRIPTION -->
            <p class="description">
                Taste of Indonesia is a web-based platform that provides information
                about various stores and restaurants that serve Indonesian food across
                Australia.
            </p>

            <!-- EVENT INFO -->
            <div class="event-info">
                <span>📅 22–23 March <br> 10 AM–4 PM</span> |
                <span>📍 Queen Victoria Market C &amp; D Shed</span> |
                <span>📦 Indonesia Street Food Festival</span>
            </div>

            <!-- COLLABORATION -->
            <p class="collaboration">
                In collaboration with <br />
                MELBOURNE FOOD &amp; WINE SPECIAL EVENTS 2025
            </p>
        </div>
    </div>


    <!-- start of header  -->
    <header class="site-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header-logo">
                        <a href="{{ route('home') }}" class="decoration-none">
                            <span class="text-#FF8243">Taste</span> of Indonesia
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="main-navigation">
                        <button class="menu-toggle"><span></span><span></span></button>
                        <nav class="header-menu">
                            <ul class="menu food-nav-menu">
                                <li><a href="#home">Home</a></li>
                                <li><a href="#about">About Us</a></li>
                                <li><a href="#menu">Store & Restaurant</a></li>
                                <li><a href="#gallery">Gallery</a></li>
                                <li><a href="#qna">QnA</a></li>
                                <li><a href="#calendar">Calendar</a></li>
                                <li><a href="#news">News</a></li>
                                <li><a href="#contact">Contact Us</a></li>
                                <li>
                                    @guest('testimonial')
                                    <!-- Jika belum login -->
                                    <button class="button-filter" type="button" onclick="window.location.href='{{ route('testimonial.login') }}'">
                                        Login
                                    </button>
                                    @else
                                    <!-- Jika sudah login -->
                                    <div class="profile-dropdown">
                                        <!-- Foto Profil -->
                                        <div class="profile-image" onclick="toggleDropdown()">
                                            <img src="{{ auth('testimonial')->user()->profile_picture 
                ? asset('storage/' . auth('testimonial')->user()->profile_picture) 
                : asset('assets/images/default-profile.png') }}"
                                                alt="Profile"
                                                style="width: 40px; height: 40px; border-radius: 50%; cursor: pointer;">
                                        </div>


                                        <!-- Dropdown Menu -->
                                        <div class="dropdown-menu" id="dropdownMenu" style="display: none;">
                                            <a href="{{ route('testimonial.profile.edit') }}">Edit Profile</a>
                                            <form method="POST" action="{{ route('testimonial.logout') }}">
                                                @csrf
                                                <button type="submit" style="background: none; border: none; color: red; cursor: pointer; text-align: center;">Logout</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endguest
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header ends  -->

    <div id="viewport">
        <div id="js-scroll-content">

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
                                    <p>Find a store or restaurant that serves Indonesian foods in Australia.</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="banner-img-wp">
                                    <!-- Background Image Section -->
                                    <div class="banner-img" style="background-image: url(https://d1vbn70lmn1nqe.cloudfront.net/prod/wp-content/uploads/2024/07/16062938/Ragam-Makanan-Khas-Indonesia-yang-Lezat-dan-Kaya-Nutrisi.jpg.webp);">
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
                                    <p class="sec-sub-title mb-3">category</p>
                                    <h2 class="h2-title">Find Food<br>Category Easily</h2>
                                    <div class="sec-title-shape mb-4">
                                        <img src="assets/images/title-shape.svg" alt="Title Shape">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Food Category Information -->
                        <div class="book-table-info">
                            <div class="row align-items-center">
                                <!-- Authentic Category -->
                                <div class="col-lg-4">
                                    <div class="call-now-side table-title text-center">
                                        <i class="uil uil-coffee icon"></i>
                                        <h3>Authentic</h3>
                                    </div>
                                </div>
                                <!-- Halal Category -->
                                <div class="col-lg-4">
                                    <div class="call-now text-center">
                                        <i class="uil uil-moon icon"></i>
                                        <h3>Halal</h3>
                                    </div>
                                </div>
                                <!-- Traditional Category -->
                                <div class="col-lg-4">
                                    <div class="call-now-side table-title text-center">
                                        <i class="uil uil-utensils icon"></i>
                                        <h3>Traditional</h3>
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
                                <p>Taste of Indonesia is a culinary guide specifically designed to introduce the rich flavors of Indonesia in Australia. This website serves as a bridge for Indonesian food lovers who long for authentic cuisine in the land of Kangaroos.</p>
                                <p>We've gathered information on restaurants, cafes, and shops that serve Indonesian specialties, from rendang to satay to market snacks. Not only that, we also provide reviews, recommendations, and guides to help you find the best places that serve authentic Indonesian delights.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 m-auto">
                            <!-- About Us Video Section -->
                            <div class="about-video">
                                <div class="about-video-img" style="background-image: url(https://blog.bankmega.com/wp-content/uploads/2022/11/Makanan-Khas-Tradisional.jpg);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section: Store & Restaurant List -->
            <section style="background-image: url(assets/images/menu-bg.png);" class="our-menu section bg-light repeat-img" id="menu">
                <div class="sec-wp">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Section Title -->
                                <div class="sec-title text-center mb-5">
                                    <p class="sec-sub-title mb-3">Store & Restaurant</p>
                                    <h2 class="h2-title">Find List of <span>Store & Restaurant Here!</span></h2>
                                    <div class="sec-title-shape mb-4">
                                        <img src="assets/images/title-shape.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Map Section -->
                        <section class="about-sec section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-8 m-auto">
                                        <div class="about-video">
                                            <div class="scrapping-map">
                                                <div id="map" style="width: 100%; height: 500px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                            <li class="filter" data-filter=".store">
                                                <img src="assets/images/toko.png" alt="" class="icon-filter">
                                                Store
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

                        <!-- Store and Restaurant Listings -->
                        <div class="menu-list-row">
                            <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                                @foreach($businesses as $business)
                                <div class="col-lg-4 col-sm-6 dish-box-wp all {{ strtolower($business->type->title ?? 'all') }}" data-cat="{{ strtolower($business->type->title ?? 'all') }}">
                                    <div class="dish-box text-center">
                                        <!-- Business Logo -->
                                        <div class="dist-img">
                                            <img src="{{ $business->logo ? asset('storage/' . $business->logo) : asset('assets/images/logo/logo.png') }}" alt="{{ $business->name_business }}">
                                        </div>
                                        <!-- Business Rating -->
                                        <div class="dish-rating">
                                            {{ number_format($business->average_rating, 1) }}
                                            <i class="uil uil-star"></i>
                                        </div>
                                        <!-- Business Title -->
                                        <div class="dish-title">
                                            <h3 class="h3-title">{{ $business->name }}</h3>
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
                                                <p>{{ $business->address }}</p>
                                            </div>
                                            <div class="info-item">
                                                <i class="uil uil-utensils"></i>
                                                <p>
                                                    @foreach ($business->food_categories as $category)
                                                    {{ $category->title }}{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>

                                        <hr>
                                        <!-- Business Actions -->
                                        <div class="menu-tab text-center">
                                            <ul>
                                                <div class="filter-active-data"></div>
                                                <li class="filter-data active">
                                                    <a href="{{ route('business.show', $business->id) }}">
                                                        <img src="assets/images/icon-all.png" alt="Filter All" class="icon-filter">
                                                        Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ $business->location }}" target="_blank">
                                                        <img src="assets/images/toko.png" alt="Filter Toko" class="icon-filter">
                                                        Maps
                                                    </a>
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
                                            style="background-image: url('{{ asset('storage/' . $gallery->image) }}')">
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
                                    <a href="{{ route('news.show', $item->slug) }}" class="view-all-button-news">Read More</a>
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
                <a href="{{ route('news.index') }}" class="view-all-button-news-view-all">View All</a>
            </div>


            <!-- Contact Want to add your business  -->
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
                                                <h2 class="h2-title">Want to add your business?</h2>
                                                <p>Please contact us and tell us the details of your business.
                                                </p>
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

            <!-- footer starts  -->
            <footer class="site-footer">
                <div class="top-footer section">
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="footer-info">
                                        <div class="footer-logo">
                                            <div class="header-logo">
                                                <a href="index.html" class="decoration-none">
                                                    <span class="text-#FF8243">Taste </span>of Indonesia
                                                </a>
                                            </div>
                                        </div>
                                        <p>Taste of Indonesia is a culinary guide specifically designed to introduce the rich flavors of Indonesia in Australia. This website serves as a bridge for Indonesian food lovers who long for authentic cuisine in the land of Kangaroos.
                                        </p>
                                        <div class="social-icon">
                                            <ul>
                                                <li>
                                                    <a href="https://web.facebook.com/TradeAttache?_rdc=1&_rdr#" target="_blank">
                                                        <i class="uil uil-facebook-f"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.instagram.com/atdag_canberra/" target="_blank">
                                                        <i class="uil uil-instagram"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.youtube.com/@atdag_canberra" target="_blank">
                                                        <i class="uil uil-youtube"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.tiktok.com/@atdag_canberra" target="_blank">
                                                        <i class="fab fa-tiktok"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="footer-flex-box">
                                        <div class="footer-menu food-nav-menu">
                                            <h3 class="h3-title">Site Navigation</h3>
                                            <ul class="column-2">
                                                <li><a href="#home" class="footer-active-menu">Home</a></li>
                                                <li><a href="#about">About Us</a></li>
                                                <li><a href="#menu">Store & Restaurant</a></li>
                                                <li><a href="#gallery">Gallery</a></li>
                                                <li><a href="#qna">QnA</a></li>
                                                <li><a href="#contact">Contact Us</a></li>
                                            </ul>
                                        </div>
                                        <div class="footer-menu">
                                            <h3 class="h3-title">Contact Support</h3>
                                            <ul>
                                                <div class="info-container">
                                                    <a href="https://tanya-atdag.au/en/" target="_blank">
                                                        <div class="info-item">
                                                            <i class="uil uil-globe"></i>
                                                            <p>tanya-atdag.au</p>
                                                        </div>
                                                    </a>
                                                    <a href="mailto:atase.perdagangan@gmail.com">
                                                        <div class="info-item">
                                                            <i class="uil uil-envelope"></i>
                                                            <p>atase.perdagangan@gmail.com</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <div class="copyright-text">
                                    <p>Copyright &copy; 2025 <span class="name">Taste </span>of Indonesia. All Rights Reserved.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button class="scrolltop"><i class="uil uil-angle-up"></i></button>
                    </div>
                </div>
            </footer>
        </div>
    </div>





    <!-- jquery  -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <!-- bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/popper.min.js"></script>

    <!-- fontawesome  -->
    <script src="assets/js/font-awesome.min.js"></script>

    <!-- swiper slider  -->
    <script src="assets/js/swiper-bundle.min.js"></script>

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
         * Countdown Timer Script
         * This script manages a countdown timer until a specified launch date.
         * Once the countdown reaches zero, it displays an "Enter Website" button and auto-hides after 3 seconds.
         */

        let autoHideTimer; // Variable to store the auto-hide timer

        /**
         * Updates the countdown timer on the page.
         * When the countdown reaches zero, it displays a message and starts an auto-hide timer.
         */
        function updateCountdown() {
            const launchDate = new Date('March 22, 2025 11:00:00 GMT+11').getTime(); // Set the launch date
            const now = new Date().getTime(); // Get the current time
            const timeLeft = launchDate - now; // Calculate remaining time

            if (timeLeft <= 0) {
                // When the countdown is finished
                document.getElementById('countdown').innerText = "The website is live!";
                document.getElementById('enter-button').style.display = 'inline-block'; // Show enter button
                startAutoHide(); // Start auto-hide timer (3 seconds)
            } else {
                // Calculate time units
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                // Update the countdown display
                document.getElementById('countdown').innerText = `${days}d ${hours}h ${minutes}m ${seconds}s`;

                // Repeat the function every second
                setTimeout(updateCountdown, 1000);
            }
        }

        /**
         * Starts an auto-hide timer for the countdown overlay (3 seconds after countdown ends).
         */
        function startAutoHide() {
            if (!autoHideTimer) { // Ensure timer starts only once
                autoHideTimer = setTimeout(() => {
                    hideCountdown();
                }, 3000);
            }
        }

        /**
         * Hides the countdown overlay.
         */
        function hideCountdown() {
            document.getElementById('countdown-overlay').style.display = 'none';
        }

        /**
         * Event listener for the "Try Now" button.
         * Clicking this button immediately hides the countdown overlay and cancels auto-hide timer.
         */
        document.querySelector('.btn.btn-try').addEventListener('click', (e) => {
            e.preventDefault(); // Prevent default button action
            clearTimeout(autoHideTimer); // Cancel auto-hide timer if active
            hideCountdown();
        });

        /**
         * Event listener for the "Enter Website" button.
         * Clicking this button immediately hides the countdown overlay and cancels auto-hide timer.
         */
        document.getElementById('enter-button').addEventListener('click', () => {
            clearTimeout(autoHideTimer); // Cancel auto-hide timer if active
            hideCountdown();
        });

        // Start the countdown when the script loads
        updateCountdown();
    </script>

    <script>
        /**
         * Dropdown Toggle Script
         * 
         * This script handles the opening and closing of a dropdown menu when the profile image is clicked.
         * It also ensures the dropdown closes when clicking outside of it.
         */

        /**
         * Toggles the visibility of the dropdown menu.
         */
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        /**
         * Event listener to close the dropdown when clicking outside of the dropdown area.
         */
        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const profileImage = document.querySelector('.profile-image');

            // Check if the clicked area is outside the profile image
            if (!profileImage.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>

    <script>
        /**
         * Google Maps Integration with User Location and Nearby Businesses
         * This script initializes a Google Map, detects the user's location, and fetches nearby businesses.
         */
        function initMap() {
            // Default map location (Australia)
            const defaultLocation = {
                lat: -25.6545305,
                lng: 133.9214759
            };

            // Initialize the map
            const map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 4,
            });

            // Add a button to get the user's location
            addLocationButton(map);

            /**
             * Adds a "My Location" button to the map.
             */
            function addLocationButton(map) {
                const locationButton = document.createElement("button");

                locationButton.textContent = "📍 My Location";
                locationButton.classList.add("custom-map-control-button");

                map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(locationButton);

                locationButton.addEventListener("click", () => {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const userLocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };

                                map.setCenter(userLocation);
                                map.setZoom(15);
                            },
                            () => {
                                alert("Fail to get location.");
                            }
                        );
                    } else {
                        alert("Your browser doesn't have a Geolocation.");
                    }
                });
            }

            // Try to get the user's location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    console.log("User Location:", userLocation);

                    map.setCenter(userLocation);
                    map.setZoom(14);

                    // Add a blue marker for the user's location
                    const userMarker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: "Your Location",
                        icon: {
                            url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png", // Marker biru
                        }
                    });

                    // Add a circle around the user's location
                    const userCircle = new google.maps.Circle({
                        strokeColor: "#007bff",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: "#007bff",
                        fillOpacity: 0.35,
                        map,
                        center: userLocation,
                        radius: 300,
                    });

                    // Fetch nearby businesses
                    fetchNearbyBusinesses(userLocation, map);

                }, () => {
                    console.warn("User's location cannot be accessed, switching to default location.");
                    fetchNearbyBusinesses(null, map);
                });
            } else {
                console.warn("Geolocation is not supported by this browser.");
                fetchNearbyBusinesses(null, map);
            }
        }

        /**
         * Fetches nearby businesses and adds markers to the map.
         */
        function fetchNearbyBusinesses(location, map) {
            let url = "/api/nearby-businesses";

            if (location && location.lat && location.lng) {
                url += `?lat=${location.lat}&lng=${location.lng}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log("Data from API:", data);

                    if (!Array.isArray(data) || data.length === 0) {
                        console.warn("Store & Restaurant data is empty or the format is incompatible.");
                        return;
                    }

                    data.forEach(business => {
                        if (business.latitude && business.longitude) {
                            console.log("Adding marker in:", business.name); // Debugging

                            const marker = new google.maps.Marker({
                                position: {
                                    lat: parseFloat(business.latitude),
                                    lng: parseFloat(business.longitude),
                                },
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

                            /**
                             * Opens Google Maps with directions from the user's location to a given destination.
                             */
                            window.getDirections = function(lat, lng) {
                                if ("geolocation" in navigator) {
                                    navigator.geolocation.getCurrentPosition(
                                        (position) => {
                                            const userLat = position.coords.latitude;
                                            const userLng = position.coords.longitude;
                                            const url = `https://www.google.com/maps/dir/${userLat},${userLng}/${lat},${lng}`;
                                            window.open(url, "_blank");
                                        },
                                        (error) => {
                                            console.error("Error to get the location: ", error);
                                            alert("Failed to get your location. Please turn on location permission.");
                                        }
                                    );
                                } else {
                                    alert("Geolocation is not supported by this browser.");
                                }
                            };


                            const infoWindow = new google.maps.InfoWindow({
                                content: `
                                        <div class="card-marker">
                                            <div class="gallery-swiper">
                                                <div class="swiper-container">
                                                    <div class="swiper-wrapper">
                                                        ${business.galleries.map(gallery => `
                                                            <div class="swiper-slide">
                                                                <img src="${gallery.image}" alt="${gallery.title}" />
                                                            </div>
                                                        `).join('')}
                                                    </div>
                                                    <!-- Pagination kustom -->
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
                                                <div class="info">${business.type && business.type.title ? business.type.title : 'N/A'}</div>
                                                    <div class="buttons-maps">
                                                    <a
                                                        href="/business/${business.id}"
                                                        target="_blank"
                                                        class="btn-maps btn-details"
                                                    >
                                                        Details
                                                    </a>
                                                    <button
                                                        onclick="getDirections(${business.latitude}, ${business.longitude})"
                                                        class="btn-maps btn-route"
                                                    >
                                                        Directions
                                                    </button>
                                                    <a
                                                        href="https://www.google.com/maps?q=${business.latitude},${business.longitude}"
                                                        target="_blank"
                                                        class="btn-maps btn-view-map"
                                                    >
                                                        View in Google Maps
                                                    </a>
                                                    </div>
                                            </div>
                                        </div>
                                    `,
                                maxWidth: 300,
                            });

                            new google.maps.event.addListener(marker, 'click', function() {
                                setTimeout(() => {
                                    new Swiper('.swiper-container', {
                                        navigation: {
                                            nextEl: '.swiper-button-next',
                                            prevEl: '.swiper-button-prev',
                                        },
                                        loop: true,
                                    });
                                }, 500);
                            });

                            function renderStars(rating) {
                                const stars = Math.round(rating);
                                const fullStars = '&#9733;'.repeat(stars);
                                const emptyStars = '&#9734;'.repeat(5 - stars);
                                return `${fullStars}${emptyStars}`;
                            }

                            marker.addListener("click", () => {
                                infoWindow.open(map, marker);
                            });
                        }
                    });
                })
                .catch(error => {
                    console.error("Error failed to get data from store & restaurant:", error);
                });
        }

        /**
         * Generates star ratings based on a given number.
         */
        function renderStars(rating) {
            const stars = Math.round(rating);
            return "★".repeat(stars) + "☆".repeat(5 - stars);
        }

        // Initialize the map when the page loads
        window.onload = initMap;
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap"></script>

</body>

</html>