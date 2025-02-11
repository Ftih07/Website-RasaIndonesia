<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Rasa Indonesia</title>
    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootstrap  -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- for swiper slider  -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

    <!-- fancy box  -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
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
                                    <li><a href="#home">Home</a></li>
                                    <li><a href="#about">About Us</a></li>
                                    <li><a href="#menu">Store & Restaurant</a></li>
                                    <li><a href="#gallery">Gallery</a></li>
                                    <li><a href="#qna">QnA</a></li>
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
                <section class="main-banner" id="home">
                    <div class="js-parallax-scene">
                        <div class="banner-shape-1 w-100" data-depth="0.30">
                            <img src="assets/images/berry.png" alt="">
                        </div>
                        <div class="banner-shape-2 w-100" data-depth="0.25">
                            <img src="assets/images/leaf.png" alt="">
                        </div>
                    </div>
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 mb-4 logo">
                                    <!-- Tambahkan logo di sini -->
                                    <img src="assets/images/logo/Logo-ICAV.png" alt="Logo 1" class="logo mx-3" style="width: 160px; height: auto;">
                                    <img src="assets/images/logo/Logo-Atdag-Canberra.png" alt="Logo 2" class="logo mx-3" style="width: 240px; height: auto;">
                                </div>
                                <div class="col-lg-6">
                                    <div class="banner-text">
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
                                        <div class="banner-img" style="background-image: url(https://d1vbn70lmn1nqe.cloudfront.net/prod/wp-content/uploads/2024/07/16062938/Ragam-Makanan-Khas-Indonesia-yang-Lezat-dan-Kaya-Nutrisi.jpg.webp);">
                                        </div>
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
                                        <p class="sec-sub-title mb-3">category</p>
                                        <h2 class="h2-title">Find Food<br>Category Easily</h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="assets/images/title-shape.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                            </div>


                        </div>
                    </div>

                </section>

                <section class="about-sec section" id="about">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sec-title text-center mb-5">
                                    <p class="sec-sub-title mb-3">About Us</p>
                                    <div class="about_us">
                                        <h2>What is</h2>
                                        <h2>
                                            <span class="rasa-text">Taste </span>of Indonesia?
                                        </h2>
                                    </div>
                                    <div class="sec-title-shape mb-4">
                                        <img src="assets/images/title-shape.svg" alt="">
                                    </div>
                                    <p>Taste of Indonesia is a culinary guide specifically designed to introduce the rich flavors of Indonesia in Australia. This website serves as a bridge for Indonesian food lovers who long for authentic cuisine in the land of Kangaroos. </p>
                                    <p>We've gathered information on restaurants, cafes and shops that serve Indonesian specialties, from rendang to satay to market snacks. Not only that, we also provide reviews, recommendations and guides to help you find the best places that serve authentic Indonesian delights.</p>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 m-auto">
                                <div class="about-video">
                                    <div class="about-video-img" style="background-image: url(https://blog.bankmega.com/wp-content/uploads/2022/11/Makanan-Khas-Tradisional.jpg);">
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
                                        <h2 class="h2-title">Find List of<span>Store & Restaurant Here!</span></h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="assets/images/title-shape.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
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

                            <!-- Store and Restaurant Items -->
                            <div class="menu-list-row">
                                <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                                    @foreach($businesses as $business)
                                    <div class="col-lg-4 col-sm-6 dish-box-wp all {{ strtolower($business->type->title ?? 'all') }}"
                                        data-cat="{{ strtolower($business->type->title ?? 'all') }}">
                                        <div class="dish-box text-center">
                                            <div class="dist-img">
                                                <img src="{{ $business->logo ? asset('storage/' . $business->logo) : asset('assets/images/logo/logo.png') }}"
                                                    alt="{{ $business->name_business }}">
                                            </div>
                                            <div class="dish-rating">
                                                {{ number_format($business->average_rating, 1) }}
                                                <i class="uil uil-star"></i>
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title">{{ $business->name }}</h3>
                                                <p>{{ $business->type->title ?? 'N/A' }}</p> <!-- Asumsi ada relasi type -->
                                            </div>
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
                                            <div class="menu-tab text-center">
                                                <ul>
                                                    <div class="filter-active-data"></div>
                                                    <li class="filter-data active">
                                                        <a href="{{ route('business.show', $business->id) }}">
                                                            <img src="assets/images/icon-all.png" alt="Filter All" class="icon-filter">
                                                            Details
                                                        </a>
                                                    </li>
                                                    <li class="">
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


                <div class="bg-pattern bg-light repeat-img"
                    style="background-image: url(assets/images/blog-pattern-bg.png);">

                    <section class="newsletter-sec section pt-0" id="contact">
                        <div class="sec-wp">
                            <div class="container">
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
                                                        <a href="https://tanya-atdag.au/en/" target="_blank">
                                                            <div class="info-item">
                                                                <i class="uil uil-phone"></i>
                                                                <p>+62021858171</p>
                                                            </div>
                                                        </a>
                                                        <a href="https://tanya-atdag.au/en/" target="_blank">
                                                            <div class="info-item">
                                                                <i class="uil uil-envelope"></i>
                                                                <p>tanya-atdag.au@gmail.com</p>
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
            function toggleDropdown() {
                const menu = document.getElementById('dropdownMenu');
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            }

            // Menutup dropdown saat klik di luar area dropdown
            window.addEventListener('click', function(event) {
                const dropdown = document.getElementById('dropdownMenu');
                const profileImage = document.querySelector('.profile-image');
                if (!profileImage.contains(event.target)) {
                    dropdown.style.display = 'none';
                }
            });
        </script>

        <script>
            function initMap() {
                // Inisialisasi peta dengan posisi default (Melbourne)
                const defaultLocation = {
                    lat: -25.6545305,
                    lng: 133.9214759
                };

                const map = new google.maps.Map(document.getElementById("map"), {
                    center: defaultLocation,
                    zoom: 4,
                });

                addLocationButton(map);

                function addLocationButton(map) {
                    const locationButton = document.createElement("button");

                    locationButton.textContent = "📍 Lokasi Saya";
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
                                    alert("Gagal mendapatkan lokasi.");
                                }
                            );
                        } else {
                            alert("Browser Anda tidak mendukung geolokasi.");
                        }
                    });
                }


                // Coba dapatkan lokasi pengguna
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        console.log("User Location:", userLocation);

                        // Pindahkan peta ke lokasi pengguna
                        map.setCenter(userLocation);
                        map.setZoom(14);

                        // Tambahkan marker biru untuk lokasi pengguna
                        const userMarker = new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: "Your Location",
                            icon: {
                                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png", // Marker biru
                            }
                        });

                        // Tambahkan lingkaran transparan di sekitar lokasi pengguna
                        const userCircle = new google.maps.Circle({
                            strokeColor: "#007bff",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: "#007bff",
                            fillOpacity: 0.35,
                            map,
                            center: userLocation,
                            radius: 300, // Radius dalam meter
                        });

                        // Ambil data bisnis terdekat dari backend
                        fetchNearbyBusinesses(userLocation, map);

                    }, () => {
                        console.warn("Lokasi pengguna tidak dapat diakses, menggunakan lokasi default.");
                        fetchNearbyBusinesses(null, map);
                    });
                } else {
                    console.warn("Geolocation tidak didukung oleh browser ini.");
                    fetchNearbyBusinesses(null, map);
                }
            }

            // Fungsi untuk mengambil bisnis terdekat berdasarkan lokasi
            function fetchNearbyBusinesses(location, map) {
                let url = "/api/nearby-businesses";

                // Cek apakah location tersedia
                if (location && location.lat && location.lng) {
                    url += `?lat=${location.lat}&lng=${location.lng}`;
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Data dari API:", data); // Debugging

                        if (!Array.isArray(data) || data.length === 0) {
                            console.warn("Data restoran kosong atau format tidak sesuai");
                            return;
                        }

                        data.forEach(business => {
                            if (business.latitude && business.longitude) {
                                console.log("Menambahkan marker:", business.name); // Debugging

                                const marker = new google.maps.Marker({
                                    position: {
                                        lat: parseFloat(business.latitude),
                                        lng: parseFloat(business.longitude),
                                    },
                                    map: map,
                                    title: business.name,
                                    label: {
                                        text: business.name, // Nama bisnis di samping marker
                                        color: "#fff", // Warna merah (bisa diganti)
                                        fontSize: "14px",
                                        fontWeight: "bold",
                                        className: "marker-label", // Tambahkan kelas CSS untuk styling tambahan
                                    },
                                });



                                // Pastikan ini ada di bagian paling atas atau sebelum tombol digunakan
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
                                                console.error("Error mendapatkan lokasi: ", error);
                                                alert("Gagal mendapatkan lokasi Anda. Pastikan izin lokasi diaktifkan.");
                                            }
                                        );
                                    } else {
                                        alert("Geolokasi tidak didukung di browser Anda.");
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
                                                    <!-- Tombol navigasi -->
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
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
                                                <div class="details-button">
                                                    <a href="/business/${business.id}" target="_blank" class="btn-details">
                                                        Details
                                                    </a>
                                                </div>
                                                <div class="map-buttons">
                                                    <!-- Tombol untuk rute dari lokasi user ke bisnis -->
                                                    <button onclick="getDirections(${business.latitude}, ${business.longitude})" class="btn-route">
                                                        Rute ke sini
                                                    </button>
                                                    <!-- Tombol untuk lihat lokasi di Google Maps -->
                                                    <a href="https://www.google.com/maps?q=${business.latitude},${business.longitude}" target="_blank" class="btn-view-map">
                                                        Lihat di Google Maps
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `,
                                    maxWidth: 300,
                                });

                                // Fungsi untuk mendapatkan rute ke lokasi bisnis




                                // Inisialisasi Swiper setelah info window terbuka
                                new google.maps.event.addListener(marker, 'click', function() {
                                    setTimeout(() => {
                                        new Swiper('.swiper-container', {
                                            navigation: {
                                                nextEl: '.swiper-button-next',
                                                prevEl: '.swiper-button-prev',
                                            },
                                            loop: true,
                                        });
                                    }, 500); // Tunggu hingga DOM tersedia
                                });


                                // Helper function untuk render bintang
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
                        console.error("Error mengambil data restoran:", error);
                    });
            }


            // Fungsi render rating bintang
            function renderStars(rating) {
                const stars = Math.round(rating);
                return "★".repeat(stars) + "☆".repeat(5 - stars);
            }

            // Inisialisasi peta setelah halaman dimuat
            window.onload = initMap;
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap"></script>

    </body>
</body>

</html>