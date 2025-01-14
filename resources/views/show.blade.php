<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Website</title>
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
                            <a href="index.html" class="decoration-none">
                                <span class="text-#FF8243">Rasa</span> Indonesia
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="main-navigation">
                            <button class="menu-toggle"><span></span><span></span></button>
                            <nav class="header-menu">
                                <ul class="menu food-nav-menu">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('home') }}#about">Tentang Kami</a></li>
                                    <li><a href="{{ route('home') }}#menu">Toko & Restoran</a></li>
                                    <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
                                    <li><a href="{{ route('home') }}#qna">QnA</a></li>
                                    <li><a href="{{ route('home') }}#contact">Hubungi Kami</a></li>
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
                                    <img src="assets/images/dish/1.jpg" alt="" class="w-5 h-5 rounded-full">
                                </div>
                            </div>
                            <div class="col-lg-7">

                                <div class="sec-text-hero">
                                    <h2>Sataylicious</h2>
                                    <h3>Restaurant - Otentik, Halal</h3>
                                    <p>Sataylicious is a family-owned business – preparing freshly made satay skewers and peanut sauce ready for you to serve your customers. By ordering our satay, it means less preparation time in the kitchen, cost-effective, consistent with a good margin.</p>
                                    <p>Sataylicious uses a complex blend of spices to create that unforgettable taste and aroma of authentic satay (and other great flavours!). All your kitchen needs to do is grill it to perfection and garnish them as you like according to your business’ concept.</p>
                                </div>

                                <div class="container-hero">
                                    <div class="card">
                                        <div class="circle">
                                            <img src="assets/images/icon/location.png">
                                        </div>
                                        <div class="content">
                                            <h2>Alamat</h2>
                                            <p>Unit 17/417-419 Warrigal Rd, Cheltenham VIC 3192, Australia, Cheltenham, Victoria, Australia</p>
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
                                        <p class="sec-sub-title mb-3">sataylicious</p>
                                        <h2 class="h2-title">Bussines Overview</h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="assets/images/title-shape.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="book-table-info">
                                <div class="row align-items-center">
                                    <div class="col-lg-4">
                                        <div class="table-title text-center">
                                            <h3>Senin - Jumat</h3>
                                            <p>08:00 - 10:00</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="call-now text-center">
                                            <div class="media-sosial">
                                                <div class="icon-container">
                                                    <div class="icon-medsos">
                                                        <img src="assets/images/icon/globe.png" alt="Globe Icon">
                                                    </div>
                                                    <div class="icon-medsos">
                                                        <img src="assets/images/icon/instagram.png" alt="Instagram Icon">
                                                    </div>
                                                    <div class="icon-medsos">
                                                        <img src="assets/images/icon/facebook.png" alt="Facebook Icon">
                                                    </div>
                                                </div>
                                                <h3>Media Sosial</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="table-title text-center">
                                            <h3>Pelayanan</h3>
                                            <p>Makan di tempat, delivery</p>
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
                                        <p class="sec-sub-title mb-3">sataylicious</p>
                                        <h2 class="h2-title">Katalog Menu</h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="assets/images/title-shape.svg" alt="">
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
                                                <li class="filter" data-filter=".all, .breakfast, .lunch, .dinner">
                                                    <img src="assets/images/menu-1.png" alt="" class="icon-filter">
                                                    All
                                                </li>
                                                <li class="filter" data-filter=".breakfast">
                                                    <img src="assets/images/icon/makanan.png" alt="" class="icon-filter">
                                                    Makanan
                                                </li>
                                                <li class="filter" data-filter=".lunch">
                                                    <img src="assets/images/icon/minuman.png" alt="" class="icon-filter">
                                                    Minuman
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-list-row">
                                <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                                    <div class="col-lg-4 col-sm-6 dish-box-wp breakfast" data-cat="breakfast">
                                        <div class="dish-box text-center">
                                            <div class="dist-img">
                                                <img src="assets/images/satay.jpg" alt="    ">
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title">Beef Satay</h3>
                                                <p>Sataylicious</p>
                                            </div>
                                            <div class="dish-info">
                                                <ul>
                                                    <li>
                                                        <p>Type</p>
                                                        <b>Makanan</b>
                                                    </li>
                                                    <li>
                                                        <p>Sajian</p>
                                                        <b>12</b>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dist-bottom-row">
                                                <ul>
                                                    <li>
                                                        <b>$12.00</b>
                                                    </li>
                                                    <li>
                                                        <button class="dish-add-btn">
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2 -->
                                    <div class="col-lg-4 col-sm-6 dish-box-wp breakfast" data-cat="breakfast">
                                        <div class="dish-box text-center">
                                            <div class="dist-img">
                                                <img src="assets/images/satay.jpg" alt="    ">
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title">Beef Satay</h3>
                                                <p>Sataylicious</p>
                                            </div>
                                            <div class="dish-info">
                                                <ul>
                                                    <li>
                                                        <p>Type</p>
                                                        <b>Makanan</b>
                                                    </li>
                                                    <li>
                                                        <p>Sajian</p>
                                                        <b>12</b>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dist-bottom-row">
                                                <ul>
                                                    <li>
                                                        <b>$12.00</b>
                                                    </li>
                                                    <li>
                                                        <button class="dish-add-btn">
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 3 -->
                                    <div class="col-lg-4 col-sm-6 dish-box-wp breakfast" data-cat="breakfast">
                                        <div class="dish-box text-center">
                                            <div class="dist-img">
                                                <img src="assets/images/satay.jpg" alt="    ">
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title">Beef Satay</h3>
                                                <p>Sataylicious</p>
                                            </div>
                                            <div class="dish-info">
                                                <ul>
                                                    <li>
                                                        <p>Type</p>
                                                        <b>Makanan</b>
                                                    </li>
                                                    <li>
                                                        <p>Sajian</p>
                                                        <b>12</b>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dist-bottom-row">
                                                <ul>
                                                    <li>
                                                        <b>$12.00</b>
                                                    </li>
                                                    <li>
                                                        <button class="dish-add-btn">
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

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
                                        style="background-image: url(assets/images/satay.jpg);">
                                        <div class="bg-overlay dark-overlay"></div>
                                        <div class="sec-wp">
                                            <div class="newsletter-box-text">
                                                <h2 class="h2-title">Hubungi Bisnis Ini</h2>
                                                <p>Jika Anda Ingin Melakukan Pemesanan atau Ingin mengetahui Lebih Lanjut Mengenai Bisnis ini</p>
                                            </div>
                                            <div class="contact-icons">
                                                <a href="https://wa.me/your-number" target="_blank"><i class="uil uil-whatsapp"></i></a>
                                                <a href="mailto:your-email@example.com"><i class="uil uil-envelope"></i></a>
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
                                            <h2>Berikut adalah</h2>
                                            <h2>
                                                Galeri dari <span class="rasa-text">Rasa</span> Indonesia
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
                                            <a href="assets/images/bt1.jpg" data-fancybox="table-slider"
                                                class="book-table-img back-img swiper-slide"
                                                style="background-image: url(assets/images/bt1.jpg)"></a>
                                            <a href="assets/images/bt2.jpg" data-fancybox="table-slider"
                                                class="book-table-img back-img swiper-slide"
                                                style="background-image: url(assets/images/bt2.jpg)"></a>
                                            <a href="assets/images/bt3.jpg" data-fancybox="table-slider"
                                                class="book-table-img back-img swiper-slide"
                                                style="background-image: url(assets/images/bt3.jpg)"></a>
                                            <a href="assets/images/bt4.jpg" data-fancybox="table-slider"
                                                class="book-table-img back-img swiper-slide"
                                                style="background-image: url(assets/images/bt4.jpg)"></a>
                                            <a href="assets/images/bt1.jpg" data-fancybox="table-slider"
                                                class="book-table-img back-img swiper-slide"
                                                style="background-image: url(assets/images/bt1.jpg)"></a>
                                            <a href="assets/images/bt2.jpg" data-fancybox="table-slider"
                                                class="book-table-img back-img swiper-slide"
                                                style="background-image: url(assets/images/bt2.jpg)"></a>
                                            <a href="assets/images/bt3.jpg" data-fancybox="table-slider"
                                                class="book-table-img back-img swiper-slide"
                                                style="background-image: url(assets/images/bt3.jpg)"></a>
                                            <a href="assets/images/bt4.jpg" data-fancybox="table-slider"
                                                class="book-table-img back-img swiper-slide"
                                                style="background-image: url(assets/images/bt4.jpg)"></a>
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

                <section class="testimonials section bg-light">
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="sec-title text-center mb-5">
                                        <p class="sec-sub-title mb-3">Sataylicious</p>
                                        <h2 class="h2-title">testimonials</h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="assets/images/title-shape.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <div class="testimonials-container">
                                        <div class="testimonials-box">
                                            <div class="testimonial-box-top">
                                                <div class="testimonials-box-img back-img"
                                                    style="background-image: url(assets/images/testimonials/t1.jpg);">
                                                </div>
                                                <div class="star-rating-wp">
                                                    <div class="star-rating">
                                                        <span class="star-rating__fill" style="width:85%"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="testimonials-box-text">
                                                <h3 class="h3-title">Nilay Hirpara</h3>
                                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Itaque, quisquam.</p>
                                            </div>
                                        </div>
                                        <div class="testimonials-box">
                                            <div class="testimonial-box-top">
                                                <div class="testimonials-box-img back-img"
                                                    style="background-image: url(assets/images/testimonials/t2.jpg);">
                                                </div>
                                                <div class="star-rating-wp">
                                                    <div class="star-rating">
                                                        <span class="star-rating__fill" style="width:80%"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="testimonials-box-text">
                                                <h3 class="h3-title">Ravi Kumawat</h3>
                                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Itaque, quisquam.</p>
                                            </div>
                                        </div>
                                        <div class="testimonials-box">
                                            <div class="testimonial-box-top">
                                                <div class="testimonials-box-img back-img"
                                                    style="background-image: url(assets/images/testimonials/t1.jpg);">
                                                </div>
                                                <div class="star-rating-wp">
                                                    <div class="star-rating">
                                                        <span class="star-rating__fill" style="width:85%"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="testimonials-box-text">
                                                <h3 class="h3-title">Nilay Hirpara</h3>
                                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Itaque, quisquam.</p>
                                            </div>
                                        </div>
                                        <div class="testimonials-box">
                                            <div class="testimonial-box-top">
                                                <div class="testimonials-box-img back-img"
                                                    style="background-image: url(assets/images/testimonials/t2.jpg);">
                                                </div>
                                                <div class="star-rating-wp">
                                                    <div class="star-rating">
                                                        <span class="star-rating__fill" style="width:80%"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="testimonials-box-text">
                                                <h3 class="h3-title">Ravi Kumawat</h3>
                                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Itaque, quisquam.</p>
                                            </div>
                                        </div>

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
                </section>

                <section style="background-image: url(assets/images/menu-bg.png);"
                    class="our-menu section bg-light repeat-img" id="menu">
                    <div class="sec-wp">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="sec-title text-center mb-5">
                                        <p class="sec-sub-title mb-3">Toko & Restoran</p>
                                        <h2 class="h2-title">Temukan Daftar<span>Restoran & Toko Disini!</span></h2>
                                        <div class="sec-title-shape mb-4">
                                            <img src="assets/images/title-shape.svg" alt="">
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
                                                <li class="filter" data-filter=".all, .breakfast, .lunch, .dinner">
                                                    <img src="assets/images/icon-all.png" alt="Filter All" class="icon-filter">
                                                    All
                                                </li>
                                                <li class="filter" data-filter=".breakfast">
                                                    <img src="assets/images/toko.png" alt="Filter Toko" class="icon-filter">
                                                    Toko
                                                </li>
                                                <li class="filter" data-filter=".lunch">
                                                    <img src="assets/images/restoran.png" alt="Filter Restoran" class="icon-filter">
                                                    Restoran
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="menu-list-row">
                                <div class="row g-xxl-5 bydefault_show" id="menu-dish">
                                    <div class="col-lg-4 col-sm-6 dish-box-wp breakfast" data-cat="breakfast">
                                        <div class="dish-box text-center">
                                            <div class="dist-img">
                                                <img src="assets/images/dish/1.jpg" alt="">
                                            </div>
                                            <div class="dish-rating">
                                                5
                                                <i class="uil uil-star"></i>
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title">Sataylicious</h3>
                                                <p>Restoran</p>
                                            </div>
                                            <div class="info-container">
                                                <div class="info-item">
                                                    <i class="uil uil-location-point"></i>
                                                    <p>Unit 17/417-419 Warrigal Rd, Cheltenham VIC 3192, Australia, Cheltenham, Victoria, Australia</p>
                                                </div>
                                                <div class="info-item">
                                                    <i class="uil uil-utensils"></i>
                                                    <p>Otentik, Halal</p>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="menu-tab text-center">
                                                <ul class="">
                                                    <div class="filter-active"></div>
                                                    <li class="filter active">
                                                        <a href="#">
                                                            <img src="assets/images/icon-all.png" alt="Filter All" class="icon-filter">
                                                            Details
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#">
                                                            <img src="assets/images/toko.png" alt="Filter Toko" class="icon-filter">
                                                            Maps
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2 -->
                                    <div class="col-lg-4 col-sm-6 dish-box-wp breakfast" data-cat="breakfast">
                                        <div class="dish-box text-center">
                                            <div class="dist-img">
                                                <img src="assets/images/dish/1.jpg" alt="">
                                            </div>
                                            <div class="dish-rating">
                                                5
                                                <i class="uil uil-star"></i>
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title">Sataylicious</h3>
                                                <p>Restoran</p>
                                            </div>
                                            <div class="info-container">
                                                <div class="info-item">
                                                    <i class="uil uil-location-point"></i>
                                                    <p>Unit 17/417-419 Warrigal Rd, Cheltenham VIC 3192, Australia, Cheltenham, Victoria, Australia</p>
                                                </div>
                                                <div class="info-item">
                                                    <i class="uil uil-utensils"></i>
                                                    <p>Otentik, Halal</p>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="menu-tab text-center">
                                                <ul class="">
                                                    <div class="filter-active"></div>
                                                    <li class="filter active">
                                                        <a href="#">
                                                            <img src="assets/images/icon-all.png" alt="Filter All" class="icon-filter">
                                                            Details
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#">
                                                            <img src="assets/images/toko.png" alt="Filter Toko" class="icon-filter">
                                                            Maps
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 3 -->
                                    <div class="col-lg-4 col-sm-6 dish-box-wp breakfast" data-cat="breakfast">
                                        <div class="dish-box text-center">
                                            <div class="dist-img">
                                                <img src="assets/images/dish/1.jpg" alt="">
                                            </div>
                                            <div class="dish-rating">
                                                5
                                                <i class="uil uil-star"></i>
                                            </div>
                                            <div class="dish-title">
                                                <h3 class="h3-title">Sataylicious</h3>
                                                <p>Restoran</p>
                                            </div>
                                            <div class="info-container">
                                                <div class="info-item">
                                                    <i class="uil uil-location-point"></i>
                                                    <p>Unit 17/417-419 Warrigal Rd, Cheltenham VIC 3192, Australia, Cheltenham, Victoria, Australia</p>
                                                </div>
                                                <div class="info-item">
                                                    <i class="uil uil-utensils"></i>
                                                    <p>Otentik, Halal</p>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="menu-tab text-center">
                                                <ul class="">
                                                    <div class="filter-active"></div>
                                                    <li class="filter active">
                                                        <a href="#">
                                                            <img src="assets/images/icon-all.png" alt="Filter All" class="icon-filter">
                                                            Details
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#">
                                                            <img src="assets/images/toko.png" alt="Filter Toko" class="icon-filter">
                                                            Maps
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-container">
                                <a href="#" class="view-all-button">View All</a>
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
                                            style="background-image: url(assets/images/news.jpg);">
                                            <div class="bg-overlay dark-overlay"></div>
                                            <div class="sec-wp">
                                                <div class="newsletter-box-text">
                                                    <h2 class="h2-title">Ingin Menambahkan Bisnis Anda?</h2>
                                                    <p>Silahkan hubungi kami dan beritahu kami secara detail mengenai bisnis anda</p>
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
                                                        <span class="text-#FF8243">Rasa</span> Indonesia
                                                    </a>
                                                </div>
                                            </div>
                                            <p>Rasa Indonesia adalah panduan kuliner yang dirancang khusus untuk memperkenalkan kekayaan cita rasa Indonesia di Australia. Website ini menjadi jembatan bagi pecinta kuliner Nusantara yang merindukan masakan autentik di negeri Kangguru.
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
                                                <h3 class="h3-title">Site Navigasi</h3>
                                                <ul class="column-2">
                                                    <li><a href="#about">Home</a></li>
                                                    <li><a href="#about">Tentang Kami</a></li>
                                                    <li><a href="#menu">Toko & Restoran</a></li>
                                                    <li><a href="#gallery">Gallery</a></li>
                                                    <li><a href="#blog">QnA</a></li>
                                                    <li><a href="#contact">Hubungi Kami</a></li>
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
                                        <p>Copyright &copy; 2025 <span class="name">Rasa</span> Indonesia. All Rights Reserved.
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

        </script>

    </body>
</body>

</html>