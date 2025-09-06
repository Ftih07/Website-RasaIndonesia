<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/logo.png') }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
    // Data default untuk halaman index news
    $url = Request::fullUrl();
    $title = 'Latest News – Taste of Indonesia';
    $description = 'Latest news and articles about Taste of Indonesia, Indonesian culinary, events, tips & other interesting information.';
    $image = asset('assets/images/logo/logo.png');
    $keywords = 'Indonesian cuisine, Taste of Indonesia, Indonesian food news, culinary event, news article';
    @endphp

    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ $title }}">
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="author" content="Taste of Indonesia">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $image }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $url }}">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="{{ $description }}">
    <meta property="twitter:image" content="{{ $image }}">

    <!-- Title di tab browser -->
    <title>{{ $title }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootstrap  -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- fancy box  -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">

    <!-- custom css  -->
    <link rel="stylesheet" href="{{ asset('assets/css/news-index.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="body-fixed">
    @include('partials.navbar')

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
                            <p class="sec-sub-title mb-3">NEWS</p>
                            <div class="about_us">
                                <h2>All News About</h2>
                                <h2>
                                    <span class="rasa-text">Taste </span>of Indonesia
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="collection">
            @foreach ($allNews as $item)
            <div class="content-news">
                <img src="{{ asset('storage/' . $item->image_news) }}" alt="Street Food" />
                <div class="text-content">
                    <h3>{{ Str::limit(strip_tags($item->title), 20) }}</h3>
                    <p>{{ Str::limit(strip_tags($item->desc), 100) }}</p>
                    <div class="button-container-news">
                        <a href="{{ route('news.show', $item->slug) }}" class="view-all-button-news">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </section>

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

    <!-- jquery  -->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

    <!-- custom js  -->
    <script src="{{ asset('assets/main.js') }}"></script>

</body>

</html>