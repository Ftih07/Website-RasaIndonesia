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

                <div class="menu-list-row">
                    <div class="row g-xxl-5 bydefault_show-menu" id="menu-list">
                        @foreach($menus as $menu)
                        <div class="col-lg-4 col-sm-6 dish-box-wp all {{ $menu->type }}" data-cat="{{ $menu->type }}" data-name="{{ strtolower($menu->name) }}">
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
                                            <b>{{ ucfirst($menu->type) }}</b>
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

    <div class="body-order">
        <div class="container-order">
            <div class="section-order">
                <h3>Tap to Order Your Foods</h3>
                @if (!empty($business->order))
                <button class="btn-order" data-bs-toggle="modal" data-bs-target="#orderModal">Order Now</button>
                @else
                <div class="btn-order disabled">Order Unavailable</div>
                @endif
            </div>

            @if (!empty($business->reserve))
            <div class="divider"></div>

            <div class="section-order">
                <h3>Tap to Make a Reservation</h3>
                <button class="btn-order" data-bs-toggle="modal" data-bs-target="#reserveModal">Reserve</button>
            </div>
            @endif
        </div>
    </div>

    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-3 shadow border-0 overflow-hidden">
                <!-- Compact Header with wave design -->
                <div class="position-relative">
                    <div class="modal-header bg-gradient-primary text-white border-bottom-0 py-3">
                        <h5 class="modal-title fw-bold ms-2">Choose Your Delivery Platform</h5>
                        <button type="button" class="btn-close btn-close-white me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" class="wave-divider">
                        <path fill="#ffffff" fill-opacity="1" d="M0,32L80,37.3C160,43,320,53,480,48C640,43,800,27,960,24C1120,21,1280,32,1360,37.3L1440,43L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                    </svg>
                </div>

                <!-- Body with responsive platforms grid -->
                <div class="modal-body p-3 pt-0">
                    @if (!empty($business->order) && is_array($business->order))
                    <div class="row g-3 py-1">
                        @foreach ($business->order as $item)
                        <div class="col-md-6 col-12">
                            <a href="{{ $item['link'] }}" target="_blank" class="platform-card d-flex flex-column flex-sm-row align-items-center p-3 text-decoration-none text-dark border rounded-3 h-100 position-relative hover-shadow">
                                <div class="platform-icon rounded-circle p-2 bg-light mb-2 mb-sm-0 me-sm-3">
                                    <img src="{{ asset('images/platforms/' . strtolower($item['platform']) . '.png') }}" alt="{{ $item['platform'] }}" class="platform-img">
                                </div>
                                <div class="text-center text-sm-start mb-2 mb-sm-0">
                                    <h6 class="platform-name fw-bold mb-0">{{ $item['platform'] }}</h6>
                                    <p class="text-muted small mb-0 d-none d-sm-block">Fast delivery, easy tracking</p>
                                </div>
                                <div class="ms-auto mt-2 mt-sm-0 order-badge-container">
                                    <span class="badge rounded-pill px-3 py-2" style="background-color: #f8b500; color: white;">Order Now</span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-bag-x display-5 text-muted"></i>
                        <h5 class="fw-bold text-muted mt-2">No Order Options Available</h5>
                    </div>
                    @endif
                </div>

                <!-- Compact Footer -->
                <div class="modal-footer bg-light border-top py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reserve Modal -->
    <div class="modal fade" id="reserveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-3 shadow border-0 overflow-hidden">
                <!-- Compact Header with wave design -->
                <div class="position-relative">
                    <div class="modal-header bg-gradient-primary text-white border-bottom-0 py-3">
                        <h5 class="modal-title fw-bold ms-2">Choose Your Delivery Platform</h5>
                        <button type="button" class="btn-close btn-close-white me-1" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" class="wave-divider">
                        <path fill="#ffffff" fill-opacity="1" d="M0,32L80,37.3C160,43,320,53,480,48C640,43,800,27,960,24C1120,21,1280,32,1360,37.3L1440,43L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                    </svg>
                </div>

                <!-- Body with responsive platforms grid -->
                <div class="modal-body p-3 pt-0">
                    @if (!empty($business->reserve) && is_array($business->reserve))
                    <div class="row g-3 py-1">
                        @foreach ($business->reserve as $item)
                        <div class="col-md-6 col-12">
                            <a href="{{ $item['link'] }}" target="_blank" class="platform-card d-flex flex-column flex-sm-row align-items-center p-3 text-decoration-none text-dark border rounded-3 h-100 position-relative hover-shadow">
                                <div class="platform-icon rounded-circle p-2 bg-light mb-2 mb-sm-0 me-sm-3">
                                    <img src="{{ asset('images/platforms/' . strtolower($item['platform']) . '.png') }}" alt="{{ $item['platform'] }}" class="platform-img">
                                </div>
                                <div class="text-center text-sm-start mb-2 mb-sm-0">
                                    <h6 class="platform-name fw-bold mb-0">{{ $item['platform'] }}</h6>
                                    <p class="text-muted small mb-0 d-none d-sm-block">Reserve ahead, skip the line</p>
                                </div>
                                <div class="ms-auto mt-2 mt-sm-0 order-badge-container">
                                    <span class="badge rounded-pill px-3 py-2" style="background-color: #f8b500; color: white;">Reserve Now</span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-bag-x display-5 text-muted"></i>
                        <h5 class="fw-bold text-muted mt-2">No Reserve Options Available</h5>
                    </div>
                    @endif
                </div>

                <!-- Compact Footer -->
                <div class="modal-footer bg-light border-top py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
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


</body>

</html>