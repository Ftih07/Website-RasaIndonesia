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
    <link rel="stylesheet" href="{{ asset('assets/css/news.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>



<body class="body-fixed">
    @include('partials.navbar')
    <!-- Events Overview  -->
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
                    <!-- Logo -->
                    <div class="col-lg-12 text-center mb-4">
                        <div class="logo-container">
                            <img src="{{ asset('assets/images/logo/Logo-ICAV.png') }}" alt="Logo 1" class="logo mx-3" style="width: 80px; height: auto;">
                            <img src="{{ asset('assets/images/logo/Logo-Atdag-Canberra.png') }}" alt="Logo 2" class="logo mx-3" style="width: 120px; height: auto;">
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="col-lg-12">
                        <div class="sec-title text-center mb-5">
                            <p class="sec-sub-title mb-3">CALENDAR OF EVENTS</p>
                            <h2 class="h2-title title-news">{{ $event->title }}</h2>
                            <div class="sec-title-shape mb-4">
                                <img src="{{ asset('assets/images/title-shape.svg') }}" alt="">
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="row">
                        <div class="col-lg-10 m-auto">
                            <!-- Image -->
                            <div class="about-video">
                                <div class="about-video-img" style="background-image: url({{ asset('storage/' . $event->image_events) }});"></div>
                            </div>

                            <!-- Share Buttons -->
                            <div class="article-header">
                                <div class="social-icons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}" target="_blank">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                    <a href="mailto:?subject=Check out this event&body={{ urlencode(request()->fullUrl()) }}">
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>
                                    <!-- WhatsApp -->
                                    <a href="https://wa.me/?text={{ urlencode($event->title . ' ' . Request::fullUrl()) }}" target="_blank" title="Share via WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>

                                    <!-- Instagram DM -->
                                    <a href="https://www.instagram.com/direct/inbox/"
                                        target="_blank"
                                        title="Share via Instagram DM"
                                        onclick="copyLinkToClipboard('{{ Request::fullUrl() }}')">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                    <a href="#" onclick="navigator.clipboard.writeText('{{ request()->fullUrl() }}'); alert('Link copied!')">
                                        <i class="fa-solid fa-link"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Event Content -->
                            <div class="container-events">
                                <div class="content">
                                    <div class="article-content">
                                        {!! $event->desc !!}
                                    </div>
                                </div>

                                <!-- Sidebar -->
                                <div class="container-events-sidebar">
                                    <aside class="sidebar">
                                        <!-- Location -->
                                        <p class="event-address">
                                            <i class="fas fa-map-marker-alt"></i> <strong>{{ $event->place_name }}</strong><br>
                                            {{ $event->street_name }}
                                        </p>

                                        <!-- Time -->
                                        <p>
                                            <i class="fas fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('l j F Y \f\r\o\m g A') }} to
                                            {{ \Carbon\Carbon::parse($event->end_time)->format('g A') }}
                                        </p>

                                        <!-- Iframe Map -->
                                        @if ($event->iframe)
                                        <div class="event-map" style="margin: 15px 0;">
                                            <iframe
                                                src="{{ $event->iframe }}"
                                                width="100%"
                                                height="200"
                                                frameborder="0"
                                                style="border:0; border-radius: 10px;"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                        @endif

                                        <!-- Contact -->
                                        <div class="contact-section">
                                            <h3>Contact event organiser</h3>
                                            <p><strong>{{ $event->organizer_name ?? 'Organizer' }}</strong></p>
                                            @foreach ($event->contact_organizer ?? [] as $contact)
                                            <p>
                                                @if ($contact['type'] === 'phone')
                                                <i class="fas fa-phone"></i> {{ $contact['value'] }}
                                                @elseif ($contact['type'] === 'website')
                                                <i class="fas fa-globe"></i> <a href="{{ $contact['value'] }}" target="_blank">Website</a>
                                                @elseif ($contact['type'] === 'facebook')
                                                <i class="fab fa-facebook"></i> <a href="{{ $contact['value'] }}" target="_blank">Facebook</a>
                                                @elseif ($contact['type'] === 'instagram')
                                                <i class="fab fa-instagram"></i> <a href="{{ $contact['value'] }}" target="_blank">Instagram</a>
                                                @endif
                                            </p>
                                            @endforeach
                                        </div>

                                        <!-- Tag -->
                                        <p class="event-tag">#{{ Str::slug($event->type_events) }}</p>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <!-- Calendar  -->
    <section class="faq-sec section-repeat-img" style="background-image: url('{{ asset('assets/images/faq-bg.png') }}');"
        id="news">
        <div class="row">
            <div class="col-lg-12">
                <div class="sec-title text-center mb-5">
                    <p class="sec-sub-title calendar-events mb-3">CALENDAR OF EVENTS</p>
                    <div class="about_us">
                        <h2>Calendar of </h2>
                        <h2>
                            Events<span class="rasa-text"> Taste </span>of Indonesia
                        </h2>
                    </div>
                    <div class="sec-title-shape mb-4">
                        <img src="assets/images/title-shape.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faq-sec section-repeat-img" style="background-image: url('{{ asset('assets/images/faq-bg.png') }}');"
        id="news">
        <div class="container-card-calendar">
            <div class="swiper tranding-slider">
                <div class="swiper-wrapper">
                    @foreach ($events->where('id', '!=', $event->id)->take(6) as $otherEvent)
                    <div class="swiper-slide tranding-slide">
                        <div class="tranding-slide-img">
                            <img src="{{ asset('storage/' . $otherEvent ->image_events) }}" alt="Event" />
                        </div>
                        <div class="tranding-slide-content">
                            <a href="{{ route('events.show', $otherEvent->slug) }}" target="_blank" class="link-calendar">
                                <h1 class="food-price">{{ $otherEvent->type_events }}</h1>
                                <div class="desc">
                                    <div class="location">
                                        <i class="fa-solid fa-location-dot"></i> {{ $otherEvent->place_name }}
                                    </div>
                                    <div class="title-calendar">{{ $otherEvent->title }}</div>
                                    <div class="time">
                                        {{ \Carbon\Carbon::parse($otherEvent->start_date)->format('j F Y') }}
                                        - at {{ \Carbon\Carbon::parse($otherEvent->start_time)->format('g:i a') }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>


                <div class="swiper-pagination-navbar">
                    <div class="swiper-button-wp-calendar">
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

    <!-- Link copy to clipboard -->
    <script>
        function copyLink(e) {
            e.preventDefault();
            const tempInput = document.createElement("input");
            tempInput.value = window.location.href;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            alert("Link copied to clipboard!");
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