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
    @include('partials.navbar')


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

                        @if($business->user_id === null)
                        <span class="badge bg-warning text-dark">Belum diklaim</span>
                        <p class="text-muted">Bisnis ini belum memiliki pengelola di sistem kami.</p>
                        @else
                        <h3>
                            {{ $business->type->title ?? 'N/A' }} -
                            @foreach ($business->food_categories as $category)
                            {{ $category->title }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </h3>
                        <p>Updated On: {{ \Carbon\Carbon::parse($business->updated_at)->format('D F d, Y \a\t gA') }}</p>
                        <p>{{ $business->description }}</p>
                        @endif
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

                <!-- Update your existing menu cards to include data-menu-id attribute -->
                <div class="menu-list-row">
                    <div class="row g-xxl-5 bydefault_show-menu" id="menu">
                        @foreach($latestMenus as $menu)
                        <div class="col-lg-4 col-sm-6 dish-box-wp all {{ $menu->type ?? 'no-type' }}" data-cat="{{ $menu->type ?? 'no-type' }}">
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
                                            <b>{{ ucfirst($menu->type ?? 'no type') }}</b>
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
                                            <button class="dish-add-btn" data-menu-id="{{ $menu->id }}">
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

                <div class="text-center mt-4">
                    <a href="{{ route('business.menu', $business->slug) }}" target="_blank" class="viewAllBtn">View All</a>
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

                @if(auth()->check())
                @php
                $userTestimonials = $testimonials->where('user_id', auth()->id());
                @endphp

                @if($userTestimonials->isNotEmpty())
                <div class="mt-5">
                    <h4 class="text-center mb-4">📝 Review Anda tentang bisnis ini</h4>
                    <div class="row">
                        @foreach($userTestimonials as $userTestimonial)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm">
                                {{-- Optional: Product image --}}
                                @if($userTestimonial->image_url_product)
                                <img src="{{ $userTestimonial->image_url_product }}" class="card-img-top" alt="Product Image">
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title">{{ $userTestimonial->name }}</h5>
                                    <div class="mb-2 text-muted small">
                                        {{ \Carbon\Carbon::parse($userTestimonial->publishedAtDate)->format('d M Y, g:i A') }}
                                    </div>
                                    <div class="mb-2">⭐ {{ $userTestimonial->rating }}/5</div>
                                    <p class="card-text">{{ $userTestimonial->description }}</p>

                                    {{-- Optional: testimonial image --}}
                                    @if($userTestimonial->image_url)
                                    <div class="mt-2">
                                        <img src="{{ $userTestimonial->image_url }}" alt="Image" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                    @endif
                                </div>

                                {{-- Jumlah like --}}
                                <div class="px-3 pb-3">
                                    <small class="text-muted">{{ $userTestimonial->likes->count() }} orang merasa terbantu</small>
                                </div>

                                {{-- Balasan --}}
                                @if($userTestimonial->reply)
                                <div class="bg-light p-3 mx-3 mb-3 rounded border">
                                    <strong>{{ $userTestimonial->replier->name ?? 'Penjual' }} <span class="badge bg-success">Penjual</span></strong>
                                    <small class="text-muted"> - {{ \Carbon\Carbon::parse($userTestimonial->replied_at)->diffForHumans() }}</small>
                                    <p class="mb-0 mt-1">{{ $userTestimonial->reply }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <!-- Tombol Edit -->
                            <button
                                class="btn btn-sm btn-outline-primary"
                                onclick="showEditTestimonialModal({{ $userTestimonial->id }}, '{{ addslashes($userTestimonial->description) }}', {{ $userTestimonial->rating }})">
                                ✏️ Edit
                            </button>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('testimonial.destroy', $userTestimonial->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus testimonial ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>

                        @endforeach
                    </div>
                </div>
                @endif
                @endif

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

                                    <div class="testimonial-date mb-2">
                                        <span class="date-icon"><i class="uil uil-calendar-alt"></i></span>
                                        <span class="date-text">{{ \Carbon\Carbon::parse($testimonial->publishedAtDate)->format('M d, Y') }}</span>
                                        <span class="time-text">{{ \Carbon\Carbon::parse($testimonial->publishedAtDate)->format('g:i A') }}</span>
                                    </div>

                                    <p class="testimonial-description" data-description="{{ $testimonial->description }}">
                                        {{ $testimonial->description }}
                                    </p>

                                    {{-- Optional testimonial image --}}
                                    @if($testimonial->image_url)
                                    <div class="mt-2">
                                        <img src="{{ $testimonial->image_url }}" alt="Testimonial Image" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                    @endif

                                    {{-- Apakah komentar ini membantu? --}}
                                    <div class="mt-3">
                                        @auth
                                        @if($testimonial->likes->contains('user_id', auth()->id()))
                                        <span class="text-success">👍 Terima kasih!</span>
                                        @else
                                        <form method="POST" action="{{ route('testimonial.like', $testimonial) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-primary">👍 Apakah komentar ini membantu?</button>
                                        </form>
                                        @endif
                                        @else
                                        <a href="{{ route('testimonial.login') }}" class="text-primary">👍 Login untuk memberi Like</a>
                                        @endauth

                                        <p class="text-muted small mt-1">
                                            {{ $testimonial->likes->count() }} orang merasa terbantu
                                        </p>
                                    </div>

                                    {{-- Balasan seller (kalau ada) --}}
                                    @if($testimonial->reply)
                                    <div class="bg-light p-2 mt-3 rounded border">
                                        <strong>{{ $testimonial->replier->name ?? 'Admin' }} <span class="badge bg-success">Penjual</span></strong>
                                        <small class="text-muted"> - {{ \Carbon\Carbon::parse($testimonial->replied_at)->diffForHumans() }}</small>
                                        <p class="mb-0 mt-1">{{ $testimonial->reply }}</p>
                                    </div>
                                    @endif
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
            @if(auth()->check())
            <button class="button-add-testimonial" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
                Add Your Testimonial
            </button>
            @else
            <a href="{{ route('testimonial.login') }}" class="button-add">Login to Add Testimonial</a>
            @endif
        </div>

    </section>

    <!-- Edit Testimonial Modal -->
    <div class="modal fade" id="editTestimonialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="" id="editTestimonialForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editTestimonialId" name="testimonial_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Testimonial</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editTestimonialDescription" class="form-label">Deskripsi</label>
                            <textarea id="editTestimonialDescription" name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editTestimonialRating" class="form-label">Rating</label>
                            <input type="number" id="editTestimonialRating" name="rating" min="1" max="5" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                <form id="testimonialForm" method="POST" action="{{ route('testimonial.store', ['slug' => $business->slug]) }}">
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
                                    @if ($business->user_id === null)
                                    <span class="badge bg-warning text-dark" style="font-size: 0.7rem; margin-left: 5px;">Belum diklaim</span>
                                    @endif
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

    @include('partials.footer')

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

    <!-- JavaScript for Modal Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuData = @json($latestMenus);
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

            document.querySelectorAll('.dish-box-wp').forEach(item => {
                const box = item.querySelector('.dish-box');
                const addBtn = item.querySelector('.dish-add-btn');
                const menuId = box.getAttribute('data-menu-id');

                box.addEventListener('click', function(e) {
                    if (!e.target.closest('.dish-add-btn')) {
                        openProductModal(menuId);
                    }
                });

                if (addBtn) {
                    addBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        openProductModal(menuId);
                    });
                }
            });

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
                document.getElementById('modal-product-price').textContent = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(menu.price);

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

                        const priceDisplay = variant.price ? `$${variant.price}` : ''; // Cek dulu

                        variantElem.innerHTML = `
            <div class="variant-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="variant-name">${variant.name}</span>
                    </div>
                    <div>
                        <span class="variant-price text-orange">${priceDisplay}</span>
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

    <script>
        function showEditTestimonialModal(id, description, rating) {
            const form = document.getElementById('editTestimonialForm');
            form.action = `/testimonial/${id}`; // <- ubah action di sini
            document.getElementById('editTestimonialId').value = id;
            document.getElementById('editTestimonialDescription').value = description;
            document.getElementById('editTestimonialRating').value = rating;
            const modal = new bootstrap.Modal(document.getElementById('editTestimonialModal'));
            modal.show();
        }
    </script>


</body>

</html>