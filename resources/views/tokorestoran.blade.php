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
                                    <li><a href="#home">Home</a></li>
                                    <li><a href="#about">Tentang Kami</a></li>
                                    <li><a href="#menu">Toko & Restoran</a></li>
                                    <li><a href="#gallery">Gallery</a></li>
                                    <li><a href="#qna">QnA</a></li>
                                    <li><a href="#contact">Hubungi Kami</a></li>
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
                                                    Halal
                                                    <div class="arrow"></div>

                                                </li>
                                                <li class="filter" data-filter=".breakfast">
                                                    <img src="assets/images/toko.png" alt="Filter Toko" class="icon-filter">
                                                    Restoran
                                                    <div class="arrow"></div>

                                                </li>
                                                <li class="filter" data-filter=".lunch">
                                                    <img src="assets/images/restoran.png" alt="Filter Restoran" class="icon-filter">
                                                    Terbaru
                                                    <div class="arrow"></div>

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

                                    <!-- 4 -->
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

                                    <!-- 5 -->
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
                                    <!-- 6 -->
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

                                    <!-- 4 -->
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

                                    <!-- 5 -->
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
                                    <!-- 6 -->
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