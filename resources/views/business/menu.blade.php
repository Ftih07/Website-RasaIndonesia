<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taste of Indonesia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootstrap  -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- for swiper slider  -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">

    <!-- fancy box  -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">

    <!-- custom css  -->
    <link rel="stylesheet" href="{{ asset('assets/css/show.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>



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

    <!-- Catalogue Menu  -->
    <section style="background-image: url(assets/images/menu-bg.png);"
        class="our-menu section bg-light repeat-img" id="menu">
        <div class="book-table-shape">
            <img src="{{ asset('assets/images/table-leaves-shape.png') }}" alt="">
        </div>

        <div class="book-table-shape book-table-shape2">
            <img src="{{ asset('assets/images/table-leaves-shape.png') }}" alt="">
        </div>

        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center mb-4">
                        <div class="logo-container">
                            <img src="{{ asset('assets/images/logo/Logo-ICAV.png') }}" alt="Logo 1" class="logo mx-3" style="width: 80px; height: auto;">
                            <img src="{{ asset('assets/images/logo/Logo-Atdag-Canberra.png') }}" alt="Logo 2" class="logo mx-3" style="width: 120px; height: auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">{{ $business->name }}</p>
                            <h2 class="h2-title">All Catalogue Menu</h2>
                            <div class="sec-title-shape mb-4">
                                <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="catalogue-list">
                    <a href="{{ asset('storage/' . $business->menu) }}" target="_blank" class="catalogue-link">
                        <ion-icon name="document-outline"></ion-icon> Catalogue List
                    </a>
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
                                    <li class="filter" data-filter=".food">
                                        <img src="{{ asset('assets/images/icon/makanan.png') }}" alt="" class="icon-filter">
                                        Foods
                                    </li>
                                    <li class="filter" data-filter=".drink">
                                        <img src="{{ asset('assets/images/icon/minuman.png') }}" alt="" class="icon-filter">
                                        Drinks
                                    </li>
                                    <!-- Search Field -->
                                    <li class="filter">
                                        <input type="text" id="search-keyword" class="form-control" placeholder="Search Here" value="{{ request('keyword') }}">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Your existing menu list markup -->
                <div class="menu-list-row">
                    <div class="row g-xxl-5 bydefault_show-menu" id="menu-list">
                        @foreach($menus as $menu)
                        <div class="col-lg-4 col-sm-6 dish-box-wp all {{ $menu->type }}" data-cat="{{ $menu->type }}" data-name="{{ strtolower($menu->name) }}">
                            <div class="dish-box text-center" data-menu-id="{{ $menu->id }}">
                                <div class="dist-img">
                                    <img src="{{ $menu->image ? asset('storage/' . $menu->image) : ($business->logo ? asset('storage/' . $business->logo) : asset('assets/images/logo/logo.png')) }}"
                                        alt="{{ $menu->name }}">
                                </div>
                                <div class="dish-title">
                                    <h3 class="h3-title">{{ $menu->name }}</h3>
                                    <p>{{ $business->name }}</p>
                                </div>
                                <div class="dish-info">
                                    <ul>
                                        <li>
                                            <p>Type</p>
                                            <b>{{ ucfirst($menu->type) }}</b>
                                        </li>

                                        <li>
                                            <p>Serving</p>
                                            <b>{{ $menu->serving ?? '-' }}</b>
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
                                                <i class="fa fa-expand-alt"></i>
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


    <!-- Product Detail Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold" id="productModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Product Image Section with Overlay -->
                        <div class="col-lg-5 position-relative product-image-container">
                            <div class="product-image-wrapper">
                                <img id="modal-product-image" src="" alt="Product Image" class="product-main-image">
                            </div>
                        </div>

                        <!-- Product Details Section -->
                        <div class="col-lg-7">
                            <div class="product-details-scroll">
                                <div class="p-4 p-lg-5">

                                    <!-- Price -->
                                    <div class="mb-4">
                                        <span class="badge bg-orange mb-2 featured-badge">Menu</span>
                                        <h2 id="modal-product-name" class="product-title mb-1"></h2>
                                        <p id="modal-product-business" class=""></p>
                                        <h3 id="modal-product-price" class="text-orange fw-bold mb-0 price-tag"></h3>
                                    </div>

                                    <!-- Product Highlights -->
                                    <div class="product-highlights mb-4">
                                        <div class="row g-3">
                                            <div class="col-6 col-md-4">
                                                <div class="highlight-card">
                                                    <div class="highlight-icon">
                                                        <i class="fas fa-utensils"></i>
                                                    </div>
                                                    <div class="highlight-info">
                                                        <span class="highlight-label">Type</span>
                                                        <p id="modal-product-type" class="highlight-value"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="highlight-card">
                                                    <div class="highlight-icon">
                                                        <i class="fas fa-users"></i>
                                                    </div>
                                                    <div class="highlight-info">
                                                        <span class="highlight-label">Serving</span>
                                                        <p id="modal-product-serving" class="highlight-value"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Description -->
                                    <div class="product-description mb-4">
                                        <h5 class="section-title">Description</h5>
                                        <p id="modal-product-desc" class="description-text"></p>
                                    </div>

                                    <!-- Product Variants -->
                                    <div id="variants-section" class="product-variants mb-4">
                                        <h5 class="section-title">Variants & Complements</h5>
                                        <div id="modal-product-variants" class="row g-3">
                                            <!-- Variants will be added here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order and Reserve  -->
    <section class="body-order">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="sec-title text-center mb-5">
                        <p class="sec-sub-title mb-3">{{ $business->name }}</p>
                        <div class="about_us">
                            <h2>Delivery and</h2>
                            <h2>
                                Reservation Services
                            </h2>
                        </div>
                        <div class="sec-title-shape mb-4">
                            <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-order-reserve">
            <div class="order-reserve-wrapper">
                <!-- ORDER SECTION -->
                <div class="feature-card order-card">
                    <div class="feature-header">
                        <div class="icon-container-order-reserve">
                            <i class="bi bi-bag-check"></i>
                        </div>
                        <h3>Order Your Food</h3>
                    </div>

                    @if (!empty($business->order))
                    <!-- Order platforms available -->
                    <div class="content-wrapper">
                        <div class="card-body">
                            @if (is_array($business->order) && count($business->order))
                            <div class="platforms-grid">
                                @foreach ($business->order as $item)
                                <a href="{{ $item['link'] ?? '#' }}" target="_blank" class="platform-item">
                                    <div class="platform-icon">
                                        <img src="{{ asset('images/platforms/' . strtolower($item['platform']) . '.png') }}" alt="{{ $item['platform'] ?? 'Unknown' }}">
                                    </div>
                                    <div class="platform-info">
                                        <h6>
                                            {{ $item['platform'] ?? 'Not Available' }}
                                            @if(!empty($item['name']))
                                            - {{ $item['name'] }}
                                            @endif
                                        </h6>
                                        <span class="platform-label">Order Now</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            @else
                            <div class="empty-state">
                                <i class="bi bi-bag-x"></i>
                                <p>No order options available</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <!-- Order not available -->
                    <div class="content-wrapper">
                        <div class="empty-state">
                            <i class="bi bi-bag-dash"></i>
                            <p>Online ordering not available</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- DIVIDER -->
                <div class="section-divider">
                    <div class="divider-line"></div>
                    <div class="divider-circle">
                        <span>OR</span>
                    </div>
                    <div class="divider-line"></div>
                </div>

                <!-- RESERVE SECTION -->
                <div class="feature-card reserve-card">
                    <div class="feature-header">
                        <div class="icon-container-order-reserve">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h3>Make a Reservation</h3>
                    </div>

                    @if (!empty($business->reserve))
                    <!-- Reserve platforms available -->
                    <div class="content-wrapper">
                        <div class="card-body">
                            @if (is_array($business->reserve) && count($business->reserve))
                            <div class="platforms-grid">
                                @foreach ($business->reserve as $item)
                                <a href="{{ $item['link'] ?? '#' }}" target="_blank" class="platform-item">
                                    <div class="platform-icon">
                                        <img src="{{ asset('images/platforms/' . strtolower($item['platform']) . '.png') }}" alt="{{ $item['platform'] ?? 'Unknown' }}">
                                    </div>
                                    <div class="platform-info">
                                        <h6>
                                            {{ $item['platform'] ?? 'Not Available' }}
                                            @if(!empty($item['name']))
                                            - {{ $item['name'] }}
                                            @endif
                                        </h6>
                                        <span class="platform-label">Reserve Now</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            @else
                            <div class="empty-state">
                                <i class="bi bi-bag-x"></i>
                                <p>No reservation options available</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <!-- Reserve not available -->
                    <div class="content-wrapper">
                        <div class="empty-state">
                            <i class="bi bi-bag-dash"></i>
                            <p>Online reservations not available</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <br>
    <br>

    <!-- Contact Want to add your business  -->
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

    <script
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script
        nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
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
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById('search-keyword');
            const menuItems = document.querySelectorAll('#menu-list .dish-box-wp');

            searchInput.addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();

                menuItems.forEach(item => {
                    const name = item.dataset.name;
                    if (name.includes(keyword)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <!-- JavaScript for Menu and Modal Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Make sure we have the menu data available in JavaScript
            const menuData = @json($menus);
            const businessData = {
                name: '{{ $business->name }}',
                logo: '{{ $business->logo }}'
            };

            // Add Font Awesome if not already included
            if (!document.querySelector('link[href*="font-awesome"]')) {
                const fontAwesome = document.createElement('link');
                fontAwesome.rel = 'stylesheet';
                fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
                document.head.appendChild(fontAwesome);
            }

            // Add click event listeners to all dish boxes
            document.querySelectorAll('.dish-box-wp').forEach(item => {
                const box = item.querySelector('.dish-box');
                const addBtn = item.querySelector('.dish-add-btn');
                const menuId = box.getAttribute('data-menu-id');

                // Make the entire dish box clickable
                box.addEventListener('click', function(e) {
                    if (!e.target.closest('.dish-add-btn')) {
                        openProductModal(menuId);
                    }
                });

                // Also handle the add button clicks separately
                if (addBtn) {
                    addBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        openProductModal(menuId);
                    });
                }
            });

            // Function to open modal and populate data
            function openProductModal(menuId) {
                const menu = menuData.find(m => m.id == menuId);
                if (!menu) {
                    console.error('Menu not found:', menuId);
                    return;
                }

                // Populate main product details
                document.getElementById('modal-product-name').textContent = menu.name;
                document.getElementById('modal-product-business').textContent = businessData.name;

                // Price with currency formatting
                document.getElementById('modal-product-price').textContent = '$' + menu.price;

                // Format product type and details
                document.getElementById('modal-product-type').textContent = menu.type.charAt(0).toUpperCase() + menu.type.slice(1);
                document.getElementById('modal-product-serving').textContent = menu.serving || '-';

                // Description with fallback
                const description = menu.desc || 'A delicious offering from our kitchen. Prepared with the finest ingredients to satisfy your cravings.';
                document.getElementById('modal-product-desc').textContent = description;

                // Handle image with enhanced error handling
                const imgSrc = menu.image ?
                    `/storage/${menu.image}` :
                    (businessData.logo ? `/storage/${businessData.logo}` : '/assets/images/logo/logo.png');

                const productImage = document.getElementById('modal-product-image');
                productImage.src = imgSrc;
                productImage.onerror = function() {
                    this.src = '/assets/images/logo/logo.png';
                };

                // Variants handling with enhanced UI
                const variantsContainer = document.getElementById('modal-product-variants');
                const variantsSection = document.getElementById('variants-section');
                variantsContainer.innerHTML = '';

                if (menu.variants && menu.variants.length > 0) {
                    variantsSection.style.display = 'block';
                    menu.variants.forEach(variant => {
                        const variantElem = document.createElement('div');
                        variantElem.className = 'col-md-6';
                        variantElem.innerHTML = `
                    <div class="variant-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="variant-name">${variant.name}</span>
                            </div>
                            <div>
                                <span class="variant-price text-orange">$${variant.price}</span>
                            </div>
                        </div>
                    </div>
                `;
                        variantsContainer.appendChild(variantElem);
                    });
                } else {
                    variantsSection.style.display = 'none';
                }

                // Fix for Bootstrap modal z-index
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                    backdrop.style.zIndex = "1050";
                });

                document.getElementById('productModal').style.zIndex = "1055";

                // Show modal
                const productModal = new bootstrap.Modal(document.getElementById('productModal'));
                productModal.show();

                // After modal is shown, adjust the height of scrollable content to match image height
                productModal._element.addEventListener('shown.bs.modal', function() {
                    setTimeout(() => {
                        const imageHeight = document.querySelector('.product-main-image').offsetHeight;
                        document.querySelector('.product-details-scroll').style.maxHeight = `${imageHeight}px`;
                    }, 100);
                });

                // Handle window resize
                window.addEventListener('resize', function() {
                    if (document.getElementById('productModal').classList.contains('show')) {
                        const imageHeight = document.querySelector('.product-main-image').offsetHeight;
                        document.querySelector('.product-details-scroll').style.maxHeight = `${imageHeight}px`;
                    }
                });
            }
        });
    </script>

</body>

</html>