<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
    $url = Request::fullUrl();
    $title = $currentNews->title ?? 'Taste of Indonesia News';
    $description = strip_tags(Str::limit($currentNews->desc ?? '', 160));
    $image = asset('assets/images/logo/logo.png'); // default image/logo
    if ($currentNews->image_news) {
    $image = asset('storage/' . $currentNews->image_news);
    }
    @endphp

    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ $title }}">
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $currentNews->meta_keywords ?? 'Indonesian cuisine, Taste of Indonesia, Indonesian food news, culinary event, news article' }}">
    <meta name="author" content="{{ $currentNews->writer ?? 'Taste of Indonesia' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
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
    <link rel="stylesheet" href="{{ asset('assets/css/news.css') }}">

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
                            <h2 class="h2-title title-news">{{ $currentNews->title }}</h2>
                            <div class="sec-title-shape mb-4">
                                <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 m-auto">
                            <!-- About Us Video Section -->
                            <div class="about-video">
                                <div class="about-video-img" style="background-image: url({{ asset('storage/' . $currentNews->image_news) }});">
                                </div>
                            </div>
                            <div class="article-header">
                                <p>By : {{ $currentNews->writer ?? 'Not Defined' }}</p>
                                <p class="time">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $currentNews->time_read }} minute read . {{ $currentNews->published_display }}
                                </p>
                                <div class="social-icons">
                                    <p>Share :</p>
                                    <!-- Facebook -->
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}"
                                        target="_blank">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>

                                    <!-- Twitter -->
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}&text={{ urlencode($currentNews->title) }}"
                                        target="_blank">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>

                                    <!-- Email -->
                                    <a href="mailto:?subject={{ urlencode($currentNews->title) }}&body=Check out this article: {{ urlencode(Request::fullUrl()) }}">
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>

                                    <!-- WhatsApp -->
                                    <a href="https://wa.me/?text={{ urlencode($currentNews->title . ' ' . Request::fullUrl()) }}" target="_blank" title="Share via WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>

                                    <!-- Instagram DM -->
                                    <a href="https://www.instagram.com/direct/inbox/"
                                        target="_blank"
                                        title="Share via Instagram DM"
                                        onclick="copyLinkToClipboard('{{ Request::fullUrl() }}')">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>

                                    <!-- Copy Link -->
                                    <a href="javascript:void(0);" onclick="copyLink()" title="Copy Link">
                                        <i class="fa-solid fa-link"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="article-content">
                                {!! $currentNews->desc !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- News  -->
    <section class="faq-sec section-repeat-img" style="background-image: url('{{ asset('assets/images/faq-bg.png') }}');"
        id="news">
        <div class="sec-wp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title another-news mb-3">another news</p>
                            <div class="about_us">
                                <h2>Another News About </h2>
                                <h2>
                                    <span class="rasa-text"> Taste </span>of Indonesia
                                </h2>
                            </div>
                            <div class="sec-title-shape mb-4">
                                <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="collection">
        <div class="swiper-container mySwiper">

            <div class="swiper-wrapper">
                @foreach($anotherNews as $news)

                <div class="content-news swiper-slide">
                    <img src="{{ asset('storage/' . $news ->image_news) }}" alt="">
                    <div class="text-content">
                        <h3>{{ Str::limit($news->title, 20) }}</h3>
                        <p>{{ Str::limit(strip_tags($news->desc), 100) }}</p>
                        <div class="button-container-news">
                            <a href="{{ route('news.show', $news->slug) }}" class="view-all-button-news">Read More </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <div class="swiper-button-wp-news">
                <div class="swiper-button-prev swiper-button">
                    <i class="uil uil-angle-left"></i>
                </div>
                <div class="swiper-button-next swiper-button">
                    <i class="uil uil-angle-right"></i>
                </div>
            </div>
            <div class="swiper-pagination"></div>
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
        function copyLink() {
            navigator.clipboard.writeText(window.location.href)
                .then(() => alert('Link copied to clipboard!'))
                .catch(err => console.error('Could not copy text: ', err));
        }
    </script>

    <script>
        function copyLinkToClipboard(link) {
            navigator.clipboard.writeText(link)
                .then(() => {
                    alert("Link has been copied to the clipboard. You can directly paste it in Instagram DM 😊");
                })
                .catch(err => {
                    console.error("Could not copy text: ", err);
                });
        }
    </script>

</body>

</html>