<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta charset="UTF-8">
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
    <!-- custom css  -->
    @vite('resources/css/tokorestoran.css')

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
                                    <li><a href="#">Store & Restaurant</a></li>
                                    <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
                                    <li><a href="{{ route('home') }}#qna">QnA</a></li>
                                    <li><a href="{{ route('home') }}#contact">Contact Us</a></li>
                                    <li> @guest('testimonial')
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

                <section style="background-image: url(assets/images/menu-bg.png);" class="our-menu section bg-light repeat-img" id="menu">
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-center mb-4">
                                    <div class="logo-container">
                                        <img src="{{ asset('assets/images/logo/Logo-ICAV.png') }}" alt="Logo 1" class="logo mx-3" style="width: 80px; height: auto;">
                                        <img src="{{ asset('assets/images/logo/Logo-Atdag-Canberra.png') }}" alt="Logo 2" class="logo mx-3" style="width: 100px; height: auto;">
                                    </div>
                                </div>
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

                            <!-- Filters -->
                            <div class="menu-tab-wp">
                                <div class="row">
                                    <div class="col-lg-12 m-auto">
                                        <div class="menu-tab text-center">
                                            <ul class="filters">
                                                <!-- Dropdown for Food Categories -->
                                                <li class="filter">
                                                    <select id="food-category" class="form-select">
                                                        <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Categories</option>
                                                        @foreach ($foodCategories as $category)
                                                        <option value="{{ strtolower($category->title) }}"
                                                            {{ request('category') == strtolower($category->title) ? 'selected' : '' }}>
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

                                                <!-- Dropdown for Types -->
                                                <li class="filter">
                                                    <select id="business-type" class="form-select">
                                                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                                                        @foreach ($businessTypes as $type)
                                                        <option value="{{ strtolower($type->title) }}"
                                                            {{ request('type') == strtolower($type->title) ? 'selected' : 's' }}>
                                                            {{ $type->title }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </li>

                                                <!-- Search Field -->
                                                <li class="filter">
                                                    <input type="text" id="search-keyword" class="form-control" placeholder="Search Here"
                                                        value="{{ request('keyword') }}">
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

                            <!-- Store and Restaurant Items -->
                            <div class="menu-list-row">
                                @if($businesses->isEmpty())
                                <div class="alert alert-warning text-center">
                                    Data not found
                                </div>
                                @else
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
                                @endif
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
                                                        <span class="text-#FF8243">Taste</span> of Indonesia
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
                                                    <li><a href="{{ route('home') }}">Home</a></li>
                                                    <li><a href="{{ route('home') }}#about">About Us</a></li>
                                                    <li><a href="#" class="footer-active-menu">Store & Restaurant</a></li>
                                                    <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
                                                    <li><a href="{{ route('home') }}#blog">QnA</a></li>
                                                    <li><a href="{{ route('home') }}#contact">Contact Us</a></li>
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

    </body>
</body>

</html>