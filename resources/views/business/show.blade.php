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

    <!-- header ends  -->
    <section class="two-col-sec section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="sec-img mt-5">
                        <img src="{{ $business->logo ? asset('storage/' . $business->logo) : asset('assets/images/logo/logo.png') }}"
                            alt="{{ $business->name_business }}">

                        <!-- Menampilkan Unique Code -->
                        <a href="{{ asset('storage/' . $business->document) }}" target="_blank">
                            <p>{{ $business->unique_code ?? '' }}</p>
                        </a>

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
                        <p>Updated On: {{ \Carbon\Carbon::parse($business->updated_at)->format('D F d, Y \a\t gA') }}</p>
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
                            <iframe src="{{ $business->iframe_url }}" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Business Overview  -->
    <section class="book-table section bg-light">
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
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">{{ $business->name }}</p>
                            <h2 class="h2-title">Business Overview</h2>
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
                                        <div class="grid-icons">
                                            @foreach($business->media_social as $media)
                                            <div class="icon-medsos">
                                                @switch($media['platform'])
                                                @case('website')
                                                <a href="{{ $media['link'] }}" target="_blank">
                                                    <i class="uil uil-globe icon-orange"></i>
                                                </a>
                                                @break
                                                @case('instagram')
                                                <a href="{{ $media['link'] }}" target="_blank">
                                                    <i class="uil uil-instagram icon-orange"></i>
                                                </a>
                                                @break
                                                @case('facebook')
                                                <a href="{{ $media['link'] }}" target="_blank">
                                                    <i class="uil uil-facebook icon-orange"></i>
                                                </a>
                                                @break
                                                @case('twitter')
                                                <a href="{{ $media['link'] }}" target="_blank">
                                                    <i class="uil uil-twitter icon-orange"></i>
                                                </a>
                                                @break
                                                @case('tiktok')
                                                <a href="{{ $media['link'] }}" target="_blank">
                                                    <i class="uil uil-music icon-orange"></i>
                                                </a>
                                                @break
                                                @case('youtube')
                                                <a href="{{ $media['link'] }}" target="_blank">
                                                    <i class="uil uil-youtube icon-orange"></i>
                                                </a>
                                                @break
                                                @endswitch

                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <p>No social media links available.</p>
                                        @endif
                                    </div>

                                    <h3>Media Social</h3>
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

    <!-- Catalogue Menu  -->
    <section style="background-image: url(assets/images/menu-bg.png);"
        class="our-menu section bg-light repeat-img" id="menu">
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">{{ $business->name }}</p>
                            <h2 class="h2-title">Catalogue Menu</h2>
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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="menu-list-row">
                    <div class="row g-xxl-5 bydefault_show-menu" id="menu">
                        @foreach($latestMenus as $menu)
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

                <div class="text-center mt-4">
                    <a href="{{ route('business.menu', $business->slug) }}" target="_blank" class="viewAllBtn">View All</a>
                </div>

            </div>
        </div>
    </section>

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

    <!-- Contact business  -->
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
                                <h2>Here is the</h2>
                                <h2>
                                    Gallery of <span class="rasa-text"> {{ $business->name }}</span>
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
                            <div class="swiper-wrapper">
                                @foreach($business->galleries as $gallery)

                                <a href="{{ asset('storage/' . $gallery->image) }}" data-fancybox="table-slider"
                                    class="book-table-img back-img swiper-slide"
                                    style="background-image: url({{ asset('storage/' . $gallery->image) }})"></a>
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

    <!-- Testimonial -->
    <section class="testimonials section bg-light">
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">{{ $business->name }}</p>
                            <h2 class="h2-title">Testimonials</h2>
                            <div class="sec-title-shape mb-4">
                                <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                            </div>
                            <p class="sec-sub-title mb-3"></p>
                        </div>

                    </div>
                </div>
                <div class="menu-tab-wp">
                    <div class="row">
                        <div class="col-lg-12 m-auto">
                            <div class="menu-tab text-center">
                                <ul class="filters">
                                    <form method="GET" action="{{ route('business.show', ['slug' => $business->slug]) }}">
                                        <li class="sort">
                                            <label for="rating" class="label">Filter by Rating:</label>
                                            <select name="rating" id="rating" class="form-select">
                                                <option value="">All</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Star</option>
                                                    @endfor
                                            </select>
                                        </li>

                                        <li class="sort">
                                            <label for="order" class="label">Sort by:</label>
                                            <select name="order" id="order" class="form-select">
                                                <option value="newest" {{ request('order') == 'newest' ? 'selected' : '' }}>Newest</option>
                                                <option value="oldest" {{ request('order') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                            </select>
                                        </li>

                                        <li class="sort">
                                            <button type="submit" class="button-filter">Apply Filter</button>
                                        </li>
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-container team-slider">
                    @if($testimonials->isEmpty())
                    <div class="alert alert-warning text-center">
                        Data not found
                    </div>
                    @else
                    <div class="swiper-wrapper">
                        @foreach($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="testimonials-box">
                                <div class="testimonial-box-top">
                                    <div class="testimonials-box-img back-img"
                                        style="background-image: url({{ $testimonial->photo_url }});">
                                    </div>

                                    <div class="star-rating-wp">
                                        <div class="star-rating">
                                            <span class="star-rating__fill" style="width:{{ $testimonial->rating * 20 }}%"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonials-box-text">
                                    <h3 class="h3-title">
                                        {{ isset($testimonial->testimonial_user) ? $testimonial->testimonial_user->username : $testimonial->name }}
                                    </h3>

                                    <div class="testimonial-date">
                                        <span class="date-icon"><i class="uil uil-calendar-alt"></i></span>
                                        <span class="date-text">{{ \Carbon\Carbon::parse($testimonial->publishedAtDate)->format('M d, Y') }}</span>
                                        <span class="time-text">{{ \Carbon\Carbon::parse($testimonial->publishedAtDate)->format('g:i A') }}</span>
                                    </div>

                                    <p class="testimonial-description" data-description="{{ $testimonial->description }}">
                                        {{ $testimonial->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

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
        <div class="text-center mt-0">
            @if(auth('testimonial')->check())
            <button class="button-add-testimonial" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
                Add Your Testimonial
            </button>
            @else
            <a href="{{ route('testimonial.login') }}" class="button-add">Login to Add Testimonial</a>
            @endif
        </div>

    </section>

    <!-- Testimonial Modal -->
    <div id="testimonialModal" class="modal-testimoni-description" style="display: none;">
        <div class="modal-content-modal-testimoni-description">
            <span class="close-modal">&times;</span>
            <div class="modal-header-section">
                <div class="modal-author-info" id="modalAuthorInfo">
                    <div id="modalAuthorImage" class="modal-author-image"></div>
                    <div class="modal-author-name" id="modalAuthorName"></div>
                </div>
                <div class="modal-rating-date" id="modalRatingDate">
                    <!-- Rating and date will be populated by JS -->
                </div>
            </div>
            <div class="modal-divider"></div>
            <div class="modal-body-section">
                <div class="quote-icon">"</div>
                <p id="modalDescription"></p>
                <div class="quote-icon quote-right">"</div>
            </div>
        </div>
    </div>

    <!-- Modal Add Testimonial -->

    <div id="customModal" class="modal">
        <div class="modal-content-testimonial">
            <div class="modal-header">
                <h2>Add Your Testimonial</h2>
                <span class="close-button">&times;</span>
            </div>

            <div class="modal-body">
                <form id="testimonialForm" method="POST" action="{{ route('business.testimonials.store', ['slug' => $business->slug]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="description">Your Experience</label>
                        <textarea id="description" name="description" rows="4" placeholder="Tell us about your experience..." required></textarea>
                    </div>

                    <div class="form-group rating-group">
                        <label>Your Rating</label>
                        <div class="star-rating-input">
                            <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="5 stars">★</label>
                            <input type="radio" id="star4" name="rating" value="4" required><label for="star4" title="4 stars">★</label>
                            <input type="radio" id="star3" name="rating" value="3" required><label for="star3" title="3 stars">★</label>
                            <input type="radio" id="star2" name="rating" value="2" required><label for="star2" title="2 stars">★</label>
                            <input type="radio" id="star1" name="rating" value="1" required><label for="star1" title="1 star">★</label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="cancel-button">Cancel</button>
                        <button type="submit" class="submit-button">Submit Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Other Businesses  -->
    <section style="background-image: url(assets/images/menu-bg.png);" class="our-menu section bg-light repeat-img" id="menu">
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">Other Businesses</p>
                            <h2 class="h2-title">Explore Other <span>Stores & Restaurants!</span></h2>
                            <div class="sec-title-shape mb-4">
                                <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Filters -->
                <div class="menu-tab-wp">
                    <div class="row">
                        <div class="col-lg-12 m-auto">
                            <div class="menu-tab text-center">
                                <ul class="filters">
                                    <div class="filter-active"></div>
                                    <li class="filter" data-filter=".all">
                                        <img src="{{ asset('assets/images/icon-all.png') }}" alt="" class="icon-filter"> All
                                    </li>
                                    <li class="filter" data-filter=".store">
                                        <img src="{{ asset('assets/images/toko.png') }}" alt="" class="icon-filter"> Store
                                    </li>
                                    <li class="filter" data-filter=".restaurant">
                                        <img src="{{ asset('assets/images/restoran.png') }}" alt="" class="icon-filter"> Restaurant
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Store and Restaurant Items -->
                <div class="menu-list-row">
                    <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                        @foreach($otherBusinesses as $otherBusiness)
                        <div class="col-lg-4 col-sm-6 dish-box-wp all {{ strtolower($otherBusiness->type->title ?? 'all') }}" data-cat="{{ strtolower($otherBusiness->type->title ?? 'all') }}">
                            <div class="dish-box text-center">
                                <div class="dist-img">
                                    <img src="{{ $otherBusiness->logo ? asset('storage/' . $otherBusiness->logo) : asset('assets/images/logo/logo.png') }}" alt="{{ $otherBusiness->name }}">
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
                                    <ul>
                                        <div class="filter-active-data"></div>
                                        <li class="filter-data active">
                                            <a href="{{ route('business.show', $otherBusiness->slug) }}">
                                                <img src="{{ asset('assets/images/icon-all.png') }}" alt="Filter All" class="icon-filter"> Details
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="{{ $otherBusiness->location }}" target="_blank">
                                                <img src="{{ asset('assets/images/toko.png') }}" alt="Filter Toko" class="icon-filter"> Maps
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
        /**
         * Swiper Initialization
         * This initializes the Swiper carousel for testimonials with responsive settings.
         */
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 4, // Display 4 testimonials by default
            spaceBetween: 30, // Space between testimonials
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
                    slidesPerView: 3, // Show 3 testimonials on large screens
                },
                768: {
                    slidesPerView: 2, // Show 2 testimonials on medium screens
                },
                480: {
                    slidesPerView: 1, // Show 1 testimonial on small screens
                }
            }
        });

        /**
         * Toggle Dropdown Menu
         * This function toggles the visibility of the dropdown menu.
         */
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        /**
         * Close Dropdown Menu on Outside Click
         * This event listener closes the dropdown if a click occurs outside the profile image.
         */
        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const profileImage = document.querySelector('.profile-image');
            if (!profileImage.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

        /**
         * Modal Handling
         * Handles the opening and closing of the custom modal for adding testimonials.
         */
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('customModal');
            const openButton = document.querySelector('.button-add-testimonial'); // Button to open modal
            const closeButton = modal.querySelector('.close-button'); // Close button
            const cancelButton = modal.querySelector('.cancel-button'); // Cancel button

            /**
             * Open Modal
             * Displays the modal when the add testimonial button is clicked.
             */
            const openModal = () => {
                modal.style.display = 'block';
            };

            /**
             * Close Modal
             * Hides the modal when the close or cancel button is clicked.
             */
            const closeModal = () => {
                modal.style.display = 'none';
            };

            // Add event listeners for opening and closing modal
            openButton.addEventListener('click', openModal);
            closeButton.addEventListener('click', closeModal);
            cancelButton.addEventListener('click', closeModal);

            /**
             * Close Modal on Outside Click
             * Closes the modal when clicking outside the modal content.
             */
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
        });
    </script>

    <script>
        /**
         * Swiper Initialization
         * This script initializes the Swiper slider with pagination, navigation, and looping functionality.
         */
        const swiper = new Swiper('.swiper-container', {
            pagination: {
                el: '.swiper-pagination', // Enables pagination dots
                clickable: true // Allows clicking on pagination dots to navigate
            },
            navigation: {
                nextEl: '.swiper-button-next', // Next slide button
                prevEl: '.swiper-button-prev' // Previous slide button
            },
            loop: true, // Enables infinite loop
        });
    </script>

    <script>
        /**
         * PDF Viewer Button
         * Redirects users to the PDF file when the "View PDF" button is clicked.
         */
        document.getElementById('viewPdfButton').addEventListener('click', function() {
            const pdfUrl = "{{ asset('storage/' . $business->menu) }}"; // Direct URL to the PDF file
            window.location.href = pdfUrl; // Redirects to a new page
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const descriptions = document.querySelectorAll('.testimonial-description');
            const modal = document.getElementById('testimonialModal');
            const modalDesc = document.getElementById('modalDescription');
            const modalAuthorInfo = document.getElementById('modalAuthorInfo');
            const modalAuthorImage = document.getElementById('modalAuthorImage');
            const modalAuthorName = document.getElementById('modalAuthorName');
            const modalRatingDate = document.getElementById('modalRatingDate');
            const closeModal = document.querySelector('.close-modal');

            // Function to open modal
            function openModal() {
                modal.style.display = 'flex';
                setTimeout(() => {
                    modal.classList.add('active');
                }, 10);
            }

            // Function to close modal
            function closeModalFunc() {
                modal.classList.remove('active');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }

            descriptions.forEach(desc => {
                desc.addEventListener('click', function() {
                    const testimonialBox = this.closest('.testimonials-box');
                    const fullText = this.getAttribute('data-description');
                    const authorName = testimonialBox.querySelector('.h3-title').textContent.trim();

                    // Get the background image URL from the testimonial box
                    const testimonialImageEl = testimonialBox.querySelector('.testimonials-box-img');
                    const backgroundImageStyle = window.getComputedStyle(testimonialImageEl).backgroundImage;

                    // Set description text
                    modalDesc.textContent = fullText;

                    // Set author name and image separately
                    modalAuthorName.textContent = authorName;
                    modalAuthorImage.style.backgroundImage = backgroundImageStyle;

                    // Try to get rating and date if they exist
                    const ratingElement = testimonialBox.querySelector('.star-rating');
                    const dateElement = testimonialBox.querySelector('.testimonial-date');

                    let ratingDateHTML = '<div class="modal-rating-date-container">';

                    if (ratingElement) {
                        const ratingClone = ratingElement.cloneNode(true);
                        ratingDateHTML += '<div class="modal-rating">' + ratingClone.outerHTML + '</div>';
                    }

                    if (dateElement) {
                        const dateClone = dateElement.cloneNode(true);
                        ratingDateHTML += '<div class="modal-date">' + dateClone.innerHTML + '</div>';
                    }

                    ratingDateHTML += '</div>';
                    modalRatingDate.innerHTML = ratingDateHTML;

                    // Open modal
                    openModal();
                });
            });

            // Close modal when clicking X
            closeModal.addEventListener('click', closeModalFunc);

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target == modal) {
                    closeModalFunc();
                }
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.style.display === 'flex') {
                    closeModalFunc();
                }
            });
        });
    </script>

</body>

</html>