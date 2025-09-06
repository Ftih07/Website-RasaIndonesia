<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- for swiper slider  -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">

    <!-- fancy box  -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">

    <!-- custom css  -->
    <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="body-fixed">
    @include('cart.partials.navbar')

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
                            <h2 class="h2-title">
                                @if($business->type->title === 'Shop')
                                All {{ $business->name }} Product
                                @elseif($business->type->title === 'Restaurant')
                                All {{ $business->name }} Menu
                                @else
                                All Catalogue Menu
                                @endif
                            </h2>
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

                @php
                $allCategories = collect();
                foreach ($menus as $menu) {
                $allCategories = $allCategories->merge($menu->categories);
                }
                $allCategories = $allCategories->unique('id');
                @endphp

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
                                    @foreach($allCategories as $cat)
                                    <li class="filter" data-filter=".category-{{ Str::slug($cat->name) }}">
                                        <img src="{{ asset('assets/images/icon/makanan.png') }}" alt="" class="icon-filter">
                                        {{ $cat->name }}
                                    </li>
                                    @endforeach
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
                        <div class="col-lg-4 col-sm-6 dish-box-wp all {{ $menu->type }}
                    @foreach($menu->categories as $cat) category-{{ Str::slug($cat->name) }} @endforeach"
                            data-cat="{{ $menu->type }}" data-name="{{ strtolower($menu->name) }}">
                            <div class="dish-box text-center" data-menu-id="{{ $menu->id }}">
                                <div class="dist-img">
                                    <img src="{{ $menu->image ? asset('storage/' . $menu->image) : ($business->logo ? asset('storage/' . $business->logo) : asset('assets/images/logo/logo.png')) }}"
                                        alt="{{ $menu->name }}">
                                </div>
                                <div class="dish-title flex items-center gap-2">
                                    <h3 class="h3-title">{{ $menu->name }}</h3>

                                    @if(in_array($menu->id, $cartMenuIds ?? []))
                                    <span class="inline-flex items-center gap-1 bg-warning text-white text-[11px] font-semibold px-2 py-0.5 rounded-full shadow-sm">
                                        <i class="fas fa-shopping-cart text-xs"></i> In Cart
                                    </span>
                                    @endif

                                    <p class="w-full text-gray-500 text-sm">{{ $business->name }}</p>
                                </div>
                                <div class="dish-info">
                                    <ul>
                                        <li>
                                            <p>Status</p>
                                            <span class="badge {{ $menu->is_sell ? 'bg-success' : 'bg-danger' }}">
                                                {{ $menu->is_sell ? 'Available' : 'Not for Sale' }}
                                            </span>
                                        </li>
                                        <li>
                                            <p>Stock</p>
                                            <b>{{ $menu->stock > 0 ? $menu->stock : 'Out of stock' }}</b>
                                        </li>
                                    </ul>
                                </div>

                                <div class="dist-bottom-row">
                                    <ul>
                                        <li>
                                            <b>${{ $menu->price }}</b>
                                        </li>
                                        <li>
                                            @php
                                            $categories = $menu->categories->pluck('name')->toArray(); // ambil nama kategori produk ini
                                            @endphp

                                            <button class="dish-add-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#productModal"
                                                data-id="{{ $menu->id }}"
                                                data-business_id="{{ $business->id }}"
                                                data-name="{{ $menu->name }}"
                                                data-price="{{ $menu->price }}"
                                                data-stock="{{ $menu->stock }}"
                                                data-max_distance="{{ $menu->max_distance }}"
                                                data-is-sell="{{ $menu->is_sell ? 1 : 0 }}"
                                                data-desc="{{ $menu->desc }}"
                                                data-business="{{ $business->name }}"
                                                data-image="{{ $menu->image ? asset('storage/' . $menu->image) : ($business->logo ? asset('storage/' . $business->logo) : asset('assets/images/logo/logo.png')) }}"
                                                data-options='@json($menu->option_data)'
                                                data-categories='@json($categories)'
                                                data-is-sell="{{ $menu->is_sell ? 1 : 0 }}">
                                                <i class="fa fa-plus"></i>
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

                                    <!-- Hidden Inputs -->
                                    <input type="hidden" id="modal-product-id">
                                    <input type="hidden" id="modal-business-id">

                                    <!-- Price -->
                                    <div class="mb-4">
                                        <span class="badge bg-orange mb-2 featured-badge" id="modal-product-categories"></span>
                                        <h2 id="modal-product-name" class="product-title mb-1"></h2>
                                        <p id="modal-product-business" class=""></p>
                                        <h3 id="modal-product-price" class="text-orange fw-bold mb-2 price-tag"></h3>

                                        <!-- Quantity Selector -->
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-outline-secondary btn-sm me-2" id="qty-minus">-</button>
                                            <input type="number" id="qty-input" class="form-control form-control-sm text-center" value="1" min="1" style="width: 60px;">
                                            <button type="button" class="btn btn-outline-secondary btn-sm ms-2" id="qty-plus">+</button>
                                        </div>
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
                                                        <!-- Ganti bagian label “Type” -->
                                                        <span class="highlight-label">Max Distance</span>
                                                        <p id="modal-product-type" class="highlight-value"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="highlight-card">
                                                    <div class="highlight-icon">
                                                        <i class="fas fa-store"></i>
                                                    </div>
                                                    <div class="highlight-info">
                                                        <span class="highlight-label">Status</span>
                                                        <p id="modal-product-status" class="highlight-value"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <div class="highlight-card">
                                                    <div class="highlight-icon">
                                                        <i class="fas fa-boxes"></i>
                                                    </div>
                                                    <div class="highlight-info">
                                                        <span class="highlight-label">Stock</span>
                                                        <p id="modal-product-stock" class="highlight-value"></p>
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

                                    <!-- Option Groups -->
                                    <div id="modal-option-groups" class="mb-4">
                                        <h5 class="section-title">Your Selection</h5>
                                        <div id="option-groups-container">
                                            {{-- Diisi pakai JavaScript --}}
                                        </div>
                                    </div>

                                    <!-- Note Field -->
                                    <div class="mb-3">
                                        <label for="cart-note" class="form-label">Note (Optional)</label>
                                        <textarea id="cart-note" class="form-control" placeholder="Add additional notes..."></textarea>
                                    </div>

                                    <!-- Preference If Unavailable -->
                                    <div class="mb-4">
                                        <label class="form-label">Preference if unavailable</label>
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="preference_if_unavailable" id="merchant_recommendation" value="merchant_recommendation" checked>
                                                <label class="form-check-label" for="merchant_recommendation">
                                                    Go with Merchant Recommendation
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="preference_if_unavailable" id="contact_me" value="contact_me">
                                                <label class="form-check-label" for="contact_me">
                                                    Contact Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add to Cart Button -->
                                    <div class="text-end">
                                        <button type="button" id="add-to-cart-btn" class="toi-btn toi-btn-warning">🛒 Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Cart Item Modal -->
    <div class="modal fade" id="editCartItemModal" tabindex="-1" aria-labelledby="editCartItemLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0">
                <!-- Header -->
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold" id="editCartItemLabel">Edit Cart Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-0">
                    <div class="row g-0">

                        <!-- Image Section -->
                        <div class="col-lg-5 position-relative product-image-container">
                            <div class="product-image-wrapper">
                                <img id="edit-product-image" src="" alt="Product Image" class="product-main-image">
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div class="col-lg-7">
                            <div class="product-details-scroll">
                                <div class="p-4 p-lg-5">

                                    <!-- Hidden ID -->
                                    <input type="hidden" id="edit-cart-row-id">

                                    <!-- Product Info -->
                                    <div class="mb-4">
                                        <h2 id="edit-product-name" class="product-title mb-1"></h2>
                                        <p class="mb-1">Price per unit: <span id="edit-product-unit-price" class="fw-semibold text-orange"></span></p>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="mb-4">
                                        <label class="form-label">Quantity</label>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-outline-secondary btn-sm me-2" id="edit-qty-minus">-</button>
                                            <input type="number" id="edit-qty-input" class="form-control form-control-sm text-center" value="1" min="1" style="width: 60px;">
                                            <button type="button" class="btn btn-outline-secondary btn-sm ms-2" id="edit-qty-plus">+</button>
                                        </div>
                                    </div>

                                    <!-- Option Groups -->
                                    <div id="edit-option-groups-container" class="mb-4">
                                        <h5 class="section-title">Your Selection</h5>
                                        <!-- diisi JS -->
                                    </div>

                                    <!-- Note -->
                                    <div class="mb-3">
                                        <label for="edit-cart-note" class="form-label">Note (Optional)</label>
                                        <textarea id="edit-cart-note" class="form-control" placeholder="Add additional notes..."></textarea>
                                    </div>

                                    <!-- Preference if unavailable -->
                                    <div class="mb-4">
                                        <label class="form-label">Preference if unavailable</label>
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="edit_preference_if_unavailable" id="edit_merchant_recommendation" value="merchant_recommendation">
                                                <label class="form-check-label" for="edit_merchant_recommendation">Go with Merchant Recommendation</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="edit_preference_if_unavailable" id="edit_contact_me" value="contact_me">
                                                <label class="form-check-label" for="edit_contact_me">Contact Me</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="text-end">
                                        <button type="button" id="save-cart-item-btn" class="toi-btn toi-btn-warning">💾 Save Changes</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="currentBusinessId" value="{{ $business->id ?? '' }}">

    <div id="cartSidebar" class="cart-sidebar" data-business-id="{{ $business->id }}">
        <div class="cart-header">
            <h5 class="mb-0 fw-bold fs-5 d-flex align-items-center">
                <i class="fas fa-shopping-cart me-2"></i>
                Your Cart
            </h5>
            <button id="closeCartBtn" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center hover-rotate text-white border-0"
                onclick="toggleCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="cartItemsContainer" class="cart-items custom-scrollbar"></div>
        <div class="cart-footer">
            <button id="checkoutBtn" class="btn w-100 bg-gradient-orange text-white py-3 rounded-3 fw-semibold border-0">
                <i class="fas fa-credit-card me-2"></i>Checkout
            </button>
        </div>
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
                                style="background-image: url({{ asset('assets/images/news.jpg') }});">
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

    <script
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script
        nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

    <!-- JavaScript for Menu and Modal Functionality -->
    <script src="{{ asset('js/cart.js') }}"></script>

    {{-- Tambahkan script JS filter MixItUp kalau pakai --}}
    <script src="https://cdn.jsdelivr.net/npm/mixitup@3/dist/mixitup.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get("product");

            if (productId) {
                // cari button sesuai product-id
                const btn = document.querySelector(`.dish-add-btn[data-id="${productId}"]`);
                if (btn) {
                    btn.click(); // trigger modal auto open
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editCartItemModal = new bootstrap.Modal(document.getElementById("editCartItemModal"));
            const editQtyInput = document.getElementById("edit-qty-input");
            const editQtyMinus = document.getElementById("edit-qty-minus");
            const editQtyPlus = document.getElementById("edit-qty-plus");
            const editOptionGroupsContainer = document.getElementById("edit-option-groups-container");
            const editCartNote = document.getElementById("edit-cart-note");
            const saveCartItemBtn = document.getElementById("save-cart-item-btn");
            const editCartRowIdInput = document.getElementById("edit-cart-row-id");
            const editProductName = document.getElementById("edit-product-name");
            const editProductUnitPrice = document.getElementById("edit-product-unit-price");

            // Fungsi untuk load data cart item dari server dan tampilkan di modal edit
            function loadCartItem(rowId) {
                fetch(`/cart/item/${rowId}`, {
                        headers: {
                            Accept: "application/json"
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) {
                            alert("Failed to load cart item");
                            return;
                        }

                        const item = data.cart_item;

                        document.getElementById("edit-product-image").src = item.product.image_url;

                        editCartRowIdInput.value = item.id;
                        editProductName.textContent = item.product.name;
                        editProductUnitPrice.textContent = parseFloat(item.unit_price).toFixed(2);
                        editQtyInput.value = item.quantity;
                        editCartNote.value = item.note || "";

                        // Set radio preference
                        const pref = item.preference_if_unavailable || "merchant_recommendation";
                        document.querySelectorAll('input[name="edit_preference_if_unavailable"]').forEach(radio => {
                            radio.checked = radio.value === pref;
                        });

                        // Dapatkan ID opsi yang sudah dipilih user di cart
                        let selectedOptionIds = [];
                        try {
                            const selectedOptionGroups = JSON.parse(item.options) || [];
                            selectedOptionGroups.forEach(group => {
                                group.selected.forEach(opt => {
                                    selectedOptionIds.push(opt.id);
                                });
                            });
                        } catch {
                            selectedOptionIds = [];
                        }

                        // Render semua option groups lengkap
                        editOptionGroupsContainer.innerHTML = "";
                        const allGroups = data.all_option_groups || [];

                        allGroups.forEach(group => {
                            const groupWrapper = document.createElement("div");
                            groupWrapper.className = "mb-3";

                            const label = document.createElement("label");
                            label.className = "form-label fw-bold";
                            label.textContent = `${group.group_name} ${group.max_selection ? `(Max ${group.max_selection})` : ""} ${group.is_required ? "*" : ""}`;
                            groupWrapper.appendChild(label);

                            (group.options || []).forEach(option => {
                                const optionId = option.id;
                                const optionName = option.name;
                                const optionPrice = option.price || 0;

                                const id = `edit-option-${group.group_id}-${optionId}`;
                                const checked = selectedOptionIds.includes(optionId) ? "checked" : "";

                                const optionWrapper = document.createElement("div");
                                optionWrapper.className = "form-check";

                                optionWrapper.innerHTML = `
                                    <input class="form-check-input" type="checkbox" name="edit_option_group_${group.group_id}" id="${id}" value="${optionId}" data-price="${optionPrice}" ${checked}>
                                    <label class="form-check-label" for="${id}">
                                    ${optionName} ${optionPrice > 0 ? `(+ $${optionPrice})` : ""}
                                    </label>
                                `;

                                groupWrapper.appendChild(optionWrapper);
                            });

                            editOptionGroupsContainer.appendChild(groupWrapper);
                        });

                        // Setelah render opsi selesai, panggil init modal (harga total & validasi max_selection)
                        window.initEditCartModal();
                    })
                    .catch(() => alert("Failed to load cart item"));
            }

            // Fungsi hitung total harga (unitPrice * qty + total options price * qty)
            function calculateTotalPrice() {
                const basePrice = parseFloat(editProductUnitPrice.textContent) || 0;
                const qty = parseInt(editQtyInput.value) || 1;

                // Hitung total harga option yang dipilih
                let totalOptionsPrice = 0;

                // Untuk setiap group, jumlah harga option yg dicentang
                editOptionGroupsContainer.querySelectorAll("div.mb-3").forEach(groupEl => {
                    groupEl.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
                        totalOptionsPrice += parseFloat(cb.dataset.price) || 0;
                    });
                });

                // Total harga per unit = basePrice + totalOptionsPrice
                const totalPerUnit = basePrice + totalOptionsPrice;

                // Total keseluruhan
                const total = totalPerUnit * qty;

                // Tampilkan hasil di UI (misal di elemen khusus, atau update label)
                // Kalau belum ada elemen khusus, buat dulu dan tambahkan di modal
                let totalPriceEl = document.getElementById("edit-total-price");
                if (!totalPriceEl) {
                    totalPriceEl = document.createElement("div");
                    totalPriceEl.id = "edit-total-price";
                    totalPriceEl.className = "fw-bold fs-5 mb-3";
                    // Tempatkan di atas tombol Save
                    saveCartItemBtn.parentElement.insertBefore(totalPriceEl, saveCartItemBtn);
                }
                totalPriceEl.textContent = `Total Price: $${total.toFixed(2)}`;
            }

            // Fungsi validasi max_selection tiap group
            function validateOptionGroups() {
                let valid = true;

                editOptionGroupsContainer.querySelectorAll("div.mb-3").forEach(groupEl => {
                    const label = groupEl.querySelector("label.form-label").textContent;
                    const maxMatch = label.match(/\(Max (\d+)\)/);
                    const maxSelection = maxMatch ? parseInt(maxMatch[1]) : null;

                    // Cek apakah grup ini required
                    const isRequired = label.includes("*");

                    // Hitung jumlah checkbox tercentang
                    const checkedCount = groupEl.querySelectorAll('input[type="checkbox"]:checked').length;

                    // Reset style dulu
                    groupEl.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                        cb.classList.remove("is-invalid");
                    });

                    // Validasi max_selection
                    if (maxSelection !== null && checkedCount > maxSelection) {
                        valid = false;
                        groupEl.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                            cb.classList.add("is-invalid");
                        });
                    }

                    // Validasi required (minimal 1 tercentang)
                    if (isRequired && checkedCount === 0) {
                        valid = false;
                        groupEl.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                            cb.classList.add("is-invalid");
                        });
                    }
                });

                // Enable/disable tombol Save
                saveCartItemBtn.disabled = !valid;
            }

            // Event listener untuk quantity plus/minus
            editQtyMinus.addEventListener("click", () => {
                let val = parseInt(editQtyInput.value);
                if (val > 1) {
                    editQtyInput.value = val - 1;
                    calculateTotalPrice();
                }
            });

            editQtyPlus.addEventListener("click", () => {
                let val = parseInt(editQtyInput.value);
                editQtyInput.value = val + 1;
                calculateTotalPrice();
            });

            // Update harga saat quantity diubah manual
            editQtyInput.addEventListener("input", () => {
                let val = parseInt(editQtyInput.value);
                if (!val || val < 1) {
                    editQtyInput.value = 1;
                }
                calculateTotalPrice();
            });

            // Event listener saat checkbox option diubah
            editOptionGroupsContainer.addEventListener("change", e => {
                if (e.target.matches('input[type="checkbox"]')) {
                    validateOptionGroups();
                    calculateTotalPrice();
                }
            });

            // Inisialisasi awal waktu load modal
            // (panggil ini di akhir loadCartItem setelah render checkbox dan set value)
            function initModal() {
                calculateTotalPrice();
                validateOptionGroups();
            }

            // expose initModal supaya bisa dipanggil setelah loadCartItem selesai render
            window.initEditCartModal = initModal;

            // Event untuk tombol edit cart item di sidebar
            document.getElementById("cartItemsContainer").addEventListener("click", function(e) {
                if (e.target.classList.contains("edit-cart-item")) {
                    const rowId = e.target.dataset.row;
                    loadCartItem(rowId);
                    editCartItemModal.show();
                }
            });

            // Save edited cart item
            saveCartItemBtn.addEventListener("click", () => {
                const rowId = editCartRowIdInput.value;
                const quantity = parseInt(editQtyInput.value);
                const note = editCartNote.value.trim();
                const preference = document.querySelector('input[name="edit_preference_if_unavailable"]:checked')?.value;

                // Ambil selected options
                const optionGroups = [];
                editOptionGroupsContainer.querySelectorAll("div.mb-3").forEach(groupEl => {
                    const groupName = groupEl.querySelector("label.form-label").textContent.trim();
                    const selected = [];

                    groupEl.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
                        selected.push({
                            id: parseInt(cb.value),
                            price: parseFloat(cb.dataset.price) || 0,
                        });
                    });

                    if (selected.length > 0) {
                        optionGroups.push({
                            group_name: groupName,
                            selected: selected,
                        });
                    }
                });

                fetch(`/cart/update/${rowId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                        body: JSON.stringify({
                            quantity: quantity,
                            note: note,
                            preference_if_unavailable: preference,
                            options: JSON.stringify(optionGroups),
                        }),
                    })
                    .then(res => {
                        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                        return res.json();
                    })
                    .then(data => {
                        console.log("Update cart response:", data);
                        if (data.success) {
                            alert("Cart item updated!");
                            editCartItemModal.hide();

                            location.reload();
                            try {
                                fetchAndRenderCart(currentBusinessId);
                            } catch (e) {
                                console.error("fetchAndRenderCart error:", e);
                            }

                        } else {
                            alert(data.message || "Failed to update cart item");
                        }
                    })
                    .catch(err => {
                        console.error("Fetch error:", err);
                        alert("Failed to update cart item");
                    });
            });
        });
    </script>

    <script>
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            const businessId = document.getElementById('cartSidebar').dataset.businessId;

            fetch(`/cart/validate/${businessId}`)
                .then(res => {
                    if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.href = `/checkout/${businessId}`;
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan.');
                });
        });
    </script>

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