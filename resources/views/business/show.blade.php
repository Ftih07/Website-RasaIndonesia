<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Rasa Indonesia</title>

    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootstrap  -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- for swiper slider  -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">

    <!-- fancy box  -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">

    <!-- custom css  -->
    @vite('resources/css/app.css')

</head>

<body>

    <body class="body-fixed">
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
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('home') }}#about">About Us</a></li>
                                    <li><a href="{{ route('home') }}#menu">Store & Restaurant</a></li>
                                    <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
                                    <li><a href="{{ route('home') }}#qna">QnA</a></li>
                                    <li><a href="{{ route('home') }}#contact">Contact Us</a></li>
                                </ul>
                            </nav>
                            <div class="header-right">
                                <form action="#" class="header-search-form for-des">
                                    <input type="search" class="form-input" placeholder="Search Here...">
                                    <button type="submit">
                                        <i class="uil uil-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header ends  -->

        <div id="viewport">
            <div id="js-scroll-content">

                <section class="two-col-sec section">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-5">
                                <div class="sec-img mt-5">
                                    <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name_business }}" class="w-5 h-5 rounded-full">
                                </div>
                            </div>
                            <div class="col-lg-7">

                                <div class="sec-text-hero">
                                    <h2>{{ $business->name }}</h2>
                                    <h3>{{ $business->type->title ?? 'N/A' }}
                                        -
                                        @foreach ($business->food_categories as $category)
                                        {{ $category->title }}{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </h3>
                                    <p>{{ $business->description }}</p>
                                </div>

                                <div class="container-hero">
                                    <div class="card">
                                        <div class="circle">
                                            <img src="{{ asset('assets/images/icon/location.png') }}">
                                        </div>
                                        <div class="content">
                                            <h2>Address</h2>
                                            <p>{{ $business->address }}</p>
                                        </div>
                                    </div>
                                    <div class="large-box">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.3390005077414!2d115.21261681420613!3d-8.670458193758882!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd240f6c6a264c5%3A0xd1d0e7b94c42a8b8!2sMinistry%20of%20Trade%20of%20The%20Republic%20of%20Indonesia!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" allowfullscreen="" loading="lazy"></iframe>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

                <section class="book-table section bg-light">
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
                                        <p class="sec-sub-title mb-3">{{ $business->name }}</p>
                                        <h2 class="h2-title">Bussines Overview</h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="book-table-info">
                                <div class="row align-items-center">

                                    <!-- Open Hours -->
                                    <div class="col-lg-4">
                                        <div class="table-title text-center">
                                            @if(!empty($business->open_hours))
                                            @foreach($business->open_hours as $day => $hours)
                                            <h3>{{ ucfirst($day) }}</h3>
                                            <p>{{ $hours }}</p>
                                            @endforeach
                                            @else
                                            <p>Open hours are not available.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Social Media -->
                                    <div class="col-lg-4">
                                        <div class="call-now text-center">
                                            <div class="media-sosial">
                                                <div class="icon-container">
                                                    @if(!empty($business->media_social))
                                                    @foreach($business->media_social as $media)
                                                    <div class="icon-medsos">
                                                        @switch($media['platform'])
                                                        @case('website')
                                                        <a href="{{ $media['link'] }}" target="_blank">
                                                            <img src="{{ asset('assets/images/icon/globe.png') }}" alt="Globe Icon">
                                                        </a>
                                                        @break
                                                        @case('instagram')
                                                        <a href="{{ $media['link'] }}" target="_blank">
                                                            <img src="{{ asset('assets/images/icon/instagram.png') }}" alt="Instagram Icon">
                                                        </a>
                                                        @break
                                                        @case('facebook')
                                                        <a href="{{ $media['link'] }}" target="_blank">
                                                            <img src="{{ asset('assets/images/icon/facebook.png') }}" alt="Facebook Icon">
                                                        </a>
                                                        @break
                                                        @case('twitter')
                                                        <a href="{{ $media['link'] }}" target="_blank">
                                                            <img src="{{ asset('assets/images/icon/twitter.png') }}" alt="Twitter Icon">
                                                        </a>
                                                        @break
                                                        @endswitch
                                                    </div>
                                                    @endforeach
                                                    @else
                                                    <p>No social media links available.</p>
                                                    @endif
                                                </div>

                                                <h3>Media Sosial</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Services -->
                                    <div class="col-lg-4">
                                        <div class="table-title text-center">
                                            <h3>Services</h3>
                                            @if(!empty($business->services))
                                            <p>{{ implode(', ', $business->services) }}</p>
                                            @else
                                            <p>No services available.</p>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </section>

                <section style="background-image: url(assets/images/menu-bg.png);"
                    class="our-menu section bg-light repeat-img" id="menu">
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="sec-title text-center mb-5">
                                        <p class="sec-sub-title mb-3">{{ $business->name }}</p>
                                        <h2 class="h2-title">Menu Catalog</h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-tab-wp">
                                <div class="row">
                                    <div class="col-lg-12 m-auto">
                                        <div class="menu-tab text-center">
                                            <ul class="filters">
                                                <div class="filter-active"></div>
                                                <li class="filter" data-filter=".all">
                                                    <img src="{{ asset('assets/images/menu-1.png') }}" alt="" class="icon-filter">
                                                    All
                                                </li>
                                                <li class="filter" data-filter=".makanan">
                                                    <img src="{{ asset('assets/images/icon/makanan.png') }}" alt="" class="icon-filter">
                                                    Foods
                                                </li>
                                                <li class="filter" data-filter=".minuman">
                                                    <img src="{{ asset('assets/images/icon/minuman.png') }}" alt="" class="icon-filter">
                                                    Drinks
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="menu-list-row">
                                <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                                    @foreach($business->products as $menu)
                                    <div class="col-lg-4 col-sm-6 dish-box-wp all {{ $menu->type }}" data-cat="{{ $menu->type }}">
                                        <div class="dish-box text-center">
                                            <div class="dist-img">
                                                <img src="{{ asset('storage/' . $menu->image) }}" alt="">
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title">{{ $menu->name }}</h3>
                                                <p>{{ $business->name }}</p>
                                            </div>
                                            <div class="dish-info">
                                                <ul>
                                                    <li>
                                                        <p>Type</p>
                                                        <b>{{ $menu->type }}</b>
                                                    </li>
                                                    <li>
                                                        <p>Serving</p>
                                                        <b>{{ $menu->serving }}</b>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dist-bottom-row">
                                                <ul>
                                                    <li>
                                                        <b>${{ $menu->price }}</b>
                                                    </li>
                                                    <li>
                                                        <button class="dish-add-btn">
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section class="newsletter-sec section pt-0">
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 m-auto">
                                    <div class="newsletter-box text-center back-img white-text"
                                        style="background-image: url({{ asset('assets/images/satay.jpg') }});">
                                        <div class="bg-overlay dark-overlay"></div>
                                        <div class="sec-wp">
                                            <div class="newsletter-box-text">
                                                <h2 class="h2-title">Get in Touch with This Business</h2>
                                                <p>If you want to place an order or want to find out more about this business</p>
                                            </div>
                                            <div class="contact-icons">
                                                @if(!empty($business->contact))
                                                @foreach($business->contact as $contact)
                                                @switch($contact['type'])
                                                @case('email')
                                                <a href="mailto:{{ $contact['details'] }}" target="_blank">
                                                    <i class="uil uil-envelope"></i>
                                                </a>
                                                @break
                                                @case('wa')
                                                <a href="https://wa.me/{{ $contact['details'] }}" target="_blank">
                                                    <i class="uil uil-whatsapp"></i>
                                                </a>
                                                @break
                                                @case('telp')
                                                <a href="tel:{{ $contact['details'] }}">
                                                    <i class="uil uil-phone"></i>
                                                </a>
                                                @break
                                                @case('telegram')
                                                <a href="https://t.me/{{ $contact['details'] }}" target="_blank">
                                                    <i class="uil uil-telegram"></i>
                                                </a>
                                                @break
                                                @endswitch
                                                @endforeach
                                                @else
                                                <p>No contact information available.</p>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
                                        <p class="sec-sub-title mb-3">{{ $business->name }}</p>
                                        <div class="about_us">
                                            <h2>Berikut adalah</h2>
                                            <h2>
                                                Galeri dari <span class="rasa-text">{{ $business->type->title ?? 'N/A' }}</span> {{ $business->name }}
                                            </h2>
                                        </div>
                                        <div class="sec-title-shape mb-4">
                                            <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-10 m-auto">
                                    <div class="book-table-img-slider" id="icon">
                                        @foreach($business->galleries as $gallery)
                                        <div class="swiper-wrapper">
                                            <a href="{{ asset('storage/' . $gallery->image) }}" data-fancybox="table-slider"
                                                class="book-table-img back-img swiper-slide"
                                                style="background-image: url({{ asset('storage/' . $gallery->image) }})"></a>
                                        </div>
                                        @endforeach
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

                <section class="testimonials section bg-light">
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="sec-title text-center mb-5">
                                        <p class="sec-sub-title mb-3">{{ $business->name }}</p>
                                        <h2 class="h2-title">testimonials</h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="assets/images/title-shape.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach($business->testimonials as $testimonial)
                                    <div class="swiper-slide">
                                        <div class="testimonials-box">
                                            <div class="testimonial-box-top">
                                                <div class="testimonials-box-img back-img"
                                                    style="background-image: url({{ asset('assets/images/testimonials/t1.jpg') }});">
                                                </div>
                                                <div class="star-rating-wp">
                                                    <div class="star-rating">
                                                        <span class="star-rating__fill" style="width:{{ $testimonial->rating * 20 }}%"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="testimonials-box-text">
                                                <h3 class="h3-title">{{ $testimonial->name }}</h3>
                                                <p>{{ $testimonial->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <!-- Add Pagination -->
                                <div class="swiper-pagination"></div>
                                <!-- Add Navigation -->
                                <div class="swiper-button-wp">
                                    <div class="swiper-button-prev swiper-button">
                                        <i class="uil uil-angle-left"></i>
                                    </div>
                                    <div class="swiper-button-next swiper-button">
                                        <i class="uil uil-angle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section style="background-image: url(assets/images/menu-bg.png);"
                    class="our-menu section bg-light repeat-img" id="menu">
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="sec-title text-center mb-5">
                                        <p class="sec-sub-title mb-3">Store & Restaurant</p>
                                        <h2 class="h2-title">Find Another<span>Store & Restaurant in Here!</span></h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="assets/images/title-shape.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter section tetap sama -->
                            <div class="menu-tab-wp">
                                <div class="row">
                                    <div class="col-lg-12 m-auto">
                                        <div class="menu-tab text-center">
                                            <ul class="filters">
                                                <div class="filter-active"></div>
                                                <li class="filter" data-filter=".all, .breakfast, .lunch, .dinner">
                                                    <img src="assets/images/icon-all.png" alt="Filter All" class="icon-filter">
                                                    All
                                                </li>
                                                <li class="filter" data-filter=".breakfast">
                                                    <img src="assets/images/toko.png" alt="Store Filtes" class="icon-filter">
                                                    Store
                                                </li>
                                                <li class="filter" data-filter=".lunch">
                                                    <img src="assets/images/restoran.png" alt="Restaurant Filters" class="icon-filter">
                                                    Restaurant
                                                </li>
                                                <li>
                                                    <form action="#" class="header-search-form for-des">
                                                        <input type="search" class="form-input" placeholder="Search Here...">
                                                        <button type="submit">
                                                            <i class="uil uil-search"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menampilkan restoran lainnya -->
                            <div class="menu-list-row">
                                <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                                    @foreach($otherBusinesses as $otherBusiness)
                                    <div class="col-lg-4 col-sm-6 dish-box-wp breakfast" data-cat="breakfast">
                                        <div class="dish-box text-center">
                                            <div class="dist-img">
                                                <img src="{{ asset('storage/' . $otherBusiness->logo) }}" alt="{{ $otherBusiness->name }}">
                                            </div>
                                            <div class="dish-rating">
                                                {{ number_format($otherBusiness->average_rating, 1) }}
                                                <i class="uil uil-star"></i>
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title">{{ $otherBusiness->name }}</h3>
                                                <p>{{ $otherBusiness->type->title ?? 'N/A' }}</p>
                                            </div>
                                            <div class="info-container">
                                                <div class="info-item">
                                                    <i class="uil uil-location-point"></i>
                                                    <p>{{ $otherBusiness->address }}</p>
                                                </div>
                                                <div class="info-item">
                                                    <i class="uil uil-utensils"></i>
                                                    <p>
                                                        @foreach ($otherBusiness->food_categories as $category)
                                                        {{ $category->title }}{{ !$loop->last ? ', ' : '' }}
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="menu-tab text-center">
                                                <ul class="">
                                                    <li class="filter-data active">
                                                        <a href="{{ route('business.show', $otherBusiness->id) }}">
                                                            <img src="assets/images/icon-all.png" alt="Filter All" class="icon-filter">
                                                            Details
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="{{ $otherBusiness->location }}" target="_blank">
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

                            <div class="button-container">
                                <a href="{{ route('tokorestoran') }}" class="view-all-button">View All</a>
                            </div>
                        </div>
                    </div>
                </section>


                <div class="bg-pattern bg-light repeat-img"
                    style="background-image: url(assets/images/blog-pattern-bg.png);">

                    <section class="newsletter-sec section pt-0">
                        <div class="sec-wp">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-8 m-auto">
                                        <div class="newsletter-box text-center back-img white-text"
                                            style="background-image: url({{ asset('assets/images/news.jpg') }});">
                                            <div class="bg-overlay dark-overlay"></div>
                                            <div class="sec-wp">
                                                <div class="newsletter-box-text">
                                                    <h2 class="h2-title">Want to add your business?</h2>
                                                    <p>Please contact us and tell us details about your business.</p>
                                                </div>
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

                <!-- footer starts  -->
                <footer class="site-footer" id="contact">
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
                                                        <a href="#">
                                                            <i class="uil uil-facebook-f"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="uil uil-instagram"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="uil uil-youtube"></i>
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
                                                    <li><a href="#about">Home</a></li>
                                                    <li><a href="#about">About Us</a></li>
                                                    <li><a href="#menu">Store & Restaurant</a></li>
                                                    <li><a href="#gallery">Gallery</a></li>
                                                    <li><a href="#blog">QnA</a></li>
                                                    <li><a href="#contact">Contact Us</a></li>
                                                </ul>
                                            </div>
                                            <div class="footer-menu">
                                                <h3 class="h3-title">Contact Support</h3>
                                                <ul>
                                                    <div class="info-container">
                                                        <div class="info-item">
                                                            <i class="uil uil-location-point"></i>
                                                            <p>tanya-atdag.au</p>
                                                        </div>
                                                        <div class="info-item">
                                                            <i class="uil uil-utensils"></i>
                                                            <p>+62021858171</p>
                                                        </div>
                                                        <div class="info-item">
                                                            <i class="uil uil-utensils"></i>
                                                            <p>tanya-atdag.au@gmail.com</p>
                                                        </div>
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
                                        <p>Copyright &copy; 2025 <span class="name">Taste</span> of Indonesia. All Rights Reserved.
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
        <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
        <!-- bootstrap -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>

        <!-- fontawesome  -->
        <script src="{{ asset('assets/js/font-awesome.min.js') }}"></script>

        <!-- swiper slider  -->
        <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>

        <!-- mixitup -- filter  -->
        <script src="{{ asset('assets/js/jquery.mixitup.min.js') }}"></script>

        <!-- fancy box  -->
        <script src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>

        <!-- parallax  -->
        <script src="{{ asset('assets/js/parallax.min.js') }}"></script>

        <!-- gsap  -->
        <script src="{{ asset('assets/js/gsap.min.js') }}"></script>

        <!-- scroll trigger  -->
        <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
        <!-- scroll to plugin  -->
        <script src="{{ asset('assets/js/ScrollToPlugin.min.js') }}"></script>
        <!-- rellax  -->
        <!-- <script src="{{ asset('assets/js/rellax.min.js') }}"></script> -->
        <!-- <script src="{{ asset('assets/js/rellax-custom.js') }}"></script> -->
        <!-- smooth scroll  -->
        <script src="{{ asset('assets/js/smooth-scroll.js') }}"></script>
        <!-- custom js  -->
        <script src="{{ asset('assets/main.js') }}"></script>

        <script>
            var swiper = new Swiper('.swiper-container', {
                slidesPerView: 4, // Tampilkan 4 testimonial
                spaceBetween: 30, // Jarak antar testimonial
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    1024: {
                        slidesPerView: 3, // Tampilan 3 testimonial pada layar besar
                    },
                    768: {
                        slidesPerView: 2, // Tampilan 2 testimonial pada layar medium
                    },
                    480: {
                        slidesPerView: 1, // Tampilan 1 testimonial pada layar kecil
                    }
                }
            });
        </script>




    </body>
</body>

</html>