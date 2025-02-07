<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Website</title>
    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- bootstrap  -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- for swiper slider  -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">

    <!-- fancy box  -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">

    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taste of Indonesia | Login</title>

</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap");
    @import url();

    * {
        margin: 0;
        padding: 0;
        font-family: 'poppins', sans-serif;
    }

    /*///////////////////////////////////////////*/

    .header-logo a {
        text-decoration: none;
        color: #0d0d25;
        font-family: "Playfair Display", serif;
        font-weight: 900;
        font-size: 20px;
    }

    .header-logo a span {
        color: #ff8243;
    }

    .rasa-text {
        color: #ff8243;
        font-weight: bold;
    }

    .site-header {
        background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        position: sticky;
        padding: 30px 0;
        display: flex;
        align-items: center;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 99;
        transition: 0.5s;
        border-bottom: 1px solid transparent;
    }

    .site-header.sticky_head {
        background: rgb(255 255 255 / 80%);
        padding: 20px 0;
        border-color: #f2f2f2;
        backdrop-filter: blur(20px);
    }

    .main-navigation {
        display: flex;
        width: 100%;
        height: 100%;
        justify-content: flex-end;
        align-items: center;
    }

    .main-navigation .menu li {
        display: inline-block;
        position: relative;
        margin: 0 6px;
    }

    .main-navigation .menu li:first-child {
        margin-left: 0;
    }

    .main-navigation .menu li:last-child {
        margin-right: 0;
    }

    .main-navigation .menu li:hover>ul,
    .main-navigation .menu li.focus>ul {
        opacity: 1;
        margin-top: 6px;
        visibility: visible;
    }

    a {
        background-color: transparent;
        text-decoration: none !important;
        outline: none !important;
    }

    ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .main-navigation .menu ul a {
        width: 200px;
    }

    .main-navigation .menu li:hover>ul,
    .main-navigation .menu li.focus>ul {
        left: auto;
    }

    .main-navigation .menu li a {
        display: flex;
        transition: 0.3s;
        position: relative;
        justify-content: center;
        align-items: center;
        color: #0d0d25;
        text-transform: capitalize;
        font-weight: 500;
        padding: 5px 18px;
        border-radius: 30px;
    }

    .main-navigation .menu li a:hover,
    .main-navigation .menu li .active-menu,
    .main-navigation .menu .sub-menu li .active-sub-menu {
        color: #ff8243;
        background: #f3f3f5;
        box-shadow: inset 8px 8px 12px #e2e2e2, inset -8px -8px 12px #ffffff;
    }

    .header-right {
        margin-left: 40px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .header-btn {
        width: 40px;
        height: 40px;
        display: inline-flex;
        justify-content: center;
        border-radius: 10px;
        position: relative;
        margin-left: 20px;
        transition: 0.3s;
        box-shadow: inset 6px 6px 7px #dadada, inset -6px -6px 7px #ffffff;
        align-items: center;
    }


    .header-btn:hover {
        background: linear-gradient(145deg, #dcdcdc, #ffffff);
        box-shadow: 20px 20px 60px #cfcfd0, -20px -20px 60px #ffffff;
    }

    .header-search-form {
        position: relative;
    }

    .for-des {
        display: block !important;
    }

    .header-search-form button {
        background: transparent;
        border: none;
        padding: 0;
        position: absolute;
        right: 0;
        top: 50%;
        transform: translate(0, -50%);
        width: 48px;
        height: 100%;
        opacity: 0.5;
    }

    .header-search-form .form-input {
        font-size: 14px;
        padding-right: 40px;
        width: 200px;
        height: 40px;
    }

    .form-input::placeholder {
        color: rgba(70 69 71 / 0.7);
    }

    .form-input {
        width: 100%;
        height: 50px;
        outline: none !important;
        padding: 10px 15px;
        color: #0d0d25;
        -webkit-appearance: none;
        border-radius: 10px;
        border: none;
        background: #f8f8f8;
        box-shadow: inset 6px 6px 8px #dadada, inset -6px -6px 8px #ffffff;
    }

    * {
        -webkit-tap-highlight-color: transparent;
    }

    .uil {
        color: #ff8243;
    }

    @media screen and (min-width: 992px) {
        .menu-toggle {
            display: none;
        }
    }

    @media (min-width: 1500px) {
        .container {
            max-width: 1368px;
        }
    }

    @media (min-width: 2100px) {
        .container {
            max-width: 1400px;
        }

        p,
        body,
        button,
        input {
            font-size: 18px;
            line-height: 32px;
        }
    }

    @media (max-width: 1399px) {
        .header-right {
            margin-left: 20px;
        }

        .main-navigation .menu li {
            margin: 0 3px;
        }
    }

    @media (max-width: 1199px) {
        .header-btn {
            margin-left: 10px;
        }

        .header-right {
            margin-left: 10px;
        }

        .main-navigation .menu li {
            margin: 0;
        }

        .main-navigation .menu li a {
            padding: 4px 15px;
            font-size: 15px;
        }

        .header-search-form .form-input {
            width: 170px;
        }
    }

    @media (max-width: 991px) {
        .header-right {
            display: none;
        }

        .section {
            padding-top: 85px;
            padding-bottom: 85px;
        }

        .for-des {
            display: none !important;
        }

        .for-mob {
            display: block !important;
        }

        .site-header .container {
            max-width: 100%;
            padding: 0;
            height: 100%;
        }

        .site-header .container .row {
            margin: 0;
            height: 100%;
        }

        .site-header .container .row .col-lg-2 {
            width: auto;
            padding: 0;
            height: 100%;
            position: absolute;
            top: 0;
            left: 30px;
            z-index: 2;
            display: flex;
            align-items: center;
        }

        .menu-toggle {
            position: absolute;
            top: 50%;
            right: 30px;
            border: none;
            outline: none !important;
            background: transparent;
            width: 40px;
            height: 40px;
            transform: translate(0, -50%);
            z-index: 100;
            box-shadow: inset 6px 6px 7px #dadada, -6px -6px 10px #ffffff;
            border-radius: 10px;
            padding: 0 8px;
        }

        .menu-toggle span {
            display: block;
            width: 100%;
            height: 4px;
            background: #ff8243;
            margin-bottom: 5px;
            transition: 0.3s;
            border-radius: 5px;
            position: relative;
        }

        .menu-toggle span:last-child {
            margin: 0;
        }

        .toggled .menu-toggle span:nth-child(1) {
            transform: rotate(45deg);
            top: 5px;
        }

        .toggled .menu-toggle span:nth-child(2) {
            transform: rotate(-45deg);
            top: -4px;
        }

        .toggled .menu-toggle span:nth-child(3) {
            opacity: 0;
            height: 0;
        }

        .toggled .header-menu {
            transform: translateY(0);
        }

        .header-menu {
            height: 100vh;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding-top: max(9vh, 30px);
            padding-left: max(6vh, 30px);
            z-index: 99;
            transition: 1s cubic-bezier(0.165, 0.84, 0.44, 1);
            overflow-y: auto;
            transform: translateY(-100%);
            background-image: url(assets/images/blog-pattern-bg.png);
            background-position: center;
            background-color: #f3f3f5;
        }

        .main-navigation .menu li {
            display: block;
            float: none;
            margin: 0;
            margin-bottom: max(20px, 4vh);
        }

        .main-navigation .menu li a {
            display: inline-block;
            font-size: max(16px, 2vh);
        }

        .main-navigation .menu .sub-menu {
            max-width: 220px;
            opacity: 1;
            visibility: visible;
            display: none;
        }

        .main-navigation .menu .sub-menu li {
            margin-bottom: 5px;
        }

        .main-navigation .menu li:last-child {
            margin: 0;
        }

        .main-navigation .menu .sub-menu li a {
            color: #ff8243;
        }

        .header-btn.header-cart {
            display: none;
        }

        .header-btn {
            margin: 0;
            margin-right: 70px;
        }

        .site-header {
            padding: 20px 0;
            box-shadow: 0px 10px 55px #d4d4d4;
        }

        .site-header.sticky_head,
        .site-header {
            background: rgb(255 255 255 / 90%);
        }

        body {
            height: auto !important;
        }
    }

    @media (max-width: 575px) {

        .container,
        .container-fluid {
            padding: 0 30px;
        }
    }

    @media (max-width: 400px) {

        .container,
        .container-fluid {
            padding: 0 15px;
        }

        .header-btn {
            margin-right: 56px;
        }

        .menu-toggle {
            right: 15px;
        }

        .site-header .container .row .col-lg-2 {
            left: 15px;
        }
    }

    /* **************** responsiveness ***************** */

    @media (min-width: 2100px) {
        .container {
            max-width: 1400px;
        }

        p,
        body,
        button,
        input {
            font-size: 18px;
            line-height: 32px;
        }
    }

    @media (max-width: 1399px) {
        .h1-title {
            font-size: 80px;
            line-height: 90px;
        }

        .h3-title {
            font-size: 26px;
            line-height: 36px;
        }

        .h4-title {
            font-size: 24px;
            line-height: 34px;
        }

        .h2-title {
            font-size: 38px;
            line-height: 48px;
        }

        .team-img {
            height: 400px;
        }

        .blog-box {
            padding: 30px 20px;
        }

        .dist-bottom-row ul li b {
            font-size: 25px;
        }
    }

    @media (max-width: 1199px) {
        .main-banner {
            padding: 200px 0;
        }

        .banner-img-wp {
            height: 360px;
        }

        .dish-box {
            padding: 0 0 40px;
        }

        .dist-img img {
            width: 220px;
        }

        .dist-img {
            margin-top: -110px;
        }

        .dist-bottom-row ul li b {
            font-size: 28px;
        }

        .sec-text {
            padding: 0;
        }

        .team-img {
            height: 340px;
        }

        .testimonials-box {
            padding: 30px 20px;
            margin: 26px 0 30px;
        }

        .testimonials-box-img {
            min-width: 80px;
            min-height: 80px;
            margin-top: -80px;
        }

        .faq-box .h4-title {
            padding: 16px 20px;
        }

        .faq-box p {
            padding: 8px 20px 20px;
        }

        .blog-img {
            height: 240px;
        }

        .newsletter-box-text {
            padding: 0;
        }

        .footer-flex-box>div {
            padding: 0 10px;
        }

        .star-rating {
            font-size: 19px;
        }

        .testimonial-box-top {
            margin-bottom: 10px;
        }

        .call-now a {
            font-size: 28px;
        }

        .menu-box {
            padding: 50px 20px 30px 20px;
        }

        .menu-img {
            width: 140px;
        }

        .sec-img img {
            width: fit-content;
            height: fit-content;
        }
    }

    @media (max-width: 575px) {

        .container,
        .container-fluid {
            padding: 0 30px;
        }

    }

    @media (max-width: 400px) {

        .container,
        .container-fluid {
            padding: 0 15px;
        }

        .section {
            padding-top: 60px;
            padding-bottom: 60px;
        }
    }

    @media (max-width: 575px) {

        .container,
        .container-fluid {
            padding: 0 30px;
        }
    }

    @media (max-width: 400px) {

        .container,
        .container-fluid {
            padding: 0 15px;
        }
    }


    section {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        width: 100%;

        background: url('https://www.astronauts.id/blog/wp-content/uploads/2022/08/Makanan-Khas-Daerah-tiap-Provinsi-di-Indonesia-Serta-Daerah-Asalnya-1024x683.jpg')no-repeat;
        background-position: center;
        background-size: cover;
    }

    .form-box {
        position: relative;
        width: 400px;
        height: 550px;
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        backdrop-filter: blur(15px);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    h2 {
        font-size: 2em;
        color: #fff;
        text-align: center;
        margin-bottom: 50px;
    }

    .inputbox {
        position: relative;
        margin: 30px 0;
        width: 310px;
        border-bottom: 2px solid #fff;
    }

    .inputbox label {
        position: absolute;
        top: 50%;
        left: 5px;
        transform: translateY(-50%);
        color: #fff;
        font-size: 1em;
        pointer-events: none;
        transition: .5s;
    }

    input:focus~label,
    input:valid~label {
        top: -5px;
    }

    .inputbox {
        position: relative;
        display: flex;
        align-items: center;
    }

    .inputbox input {
        padding-right: 30px;
        /* Ruang untuk ikon mata */
    }

    .inputbox ion-icon {
        position: absolute;
        right: 10px;
        cursor: pointer;
    }

    .inputbox input {
        width: 100%;
        height: 50px;
        background: transparent;
        border: none;
        outline: none;
        font-size: 1em;
        padding: 0 35px 0 5px;
        color: #fff;
    }

    .inputbox ion-icon {
        position: absolute;
        right: 8px;
        color: #fff;
        font-size: 1.2em;
        top: 20px;
    }

    .forget {
        margin: -15px 0 -15px;
        font-size: .9em;
        color: #fff;
        display: flex;
        justify-content: center;
    }

    .forget label input {
        margin-right: 3px;
    }

    .forget label a {
        color: #fff;
        text-decoration: none;
    }

    .forget label a:hover {
        text-decoration: underline;
    }

    button {
        width: 100%;
        height: 40px;
        border-radius: 40px;
        background: #e3a92b;
        border: none;
        outline: none;
        cursor: pointer;
        font-size: 1em;
        font-weight: 600;
        color: #fff;
    }

    .register {
        font-size: .9em;
        color: #fff;
        text-align: center;
        margin: 25px 0 10px;
    }

    .register p a {
        text-decoration: none;
        color: #fff;
        font-weight: 600;
    }

    .register p a:hover {
        text-decoration: underline;
    }

    /* Untuk mencegah perubahan background oleh autofill */
    input:-webkit-autofill {
        background-color: transparent !important;
        -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
        -webkit-text-fill-color: #fff !important;
        /* Warna teks tetap putih */
        transition: background-color 5000s ease-in-out 0s;
    }

    @media (max-width: 480px) {
        .form-box {
            width: 85%;
            padding: 15px;
        }

        h2 {
            font-size: 1.8em;
        }

        .inputbox input {
            height: 45px;
            font-size: 0.9em;
        }

        .inputbox {
            width: 200px;
        }

        button {
            align-items: center;
            height: 35px;
            font-size: 0.9em;
        }
    }

    .bottom-footer {
        border-top: 1px solid rgb(204 204 204 / 40%);
        position: relative;
    }

    .copyright-text {
        padding: 20px 0;
    }

    .copyright-text p {
        margin: 0;
    }

    .name {
        color: #ff8243;
        font-weight: bold;
    }

    .logo-container {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 10px;
    }
</style>

<body>
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
                                <li><a href="{{ route('home') }}#menu">Store & Restaurant</a></li>
                                <li><a href="{{ route('home') }}#gallery">Gallery</a></li>
                                <li><a href="{{ route('home') }}#qna">QnA</a></li>
                                <li><a href="{{ route('home') }}#contact">Contact Us</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <section>
        <div class="form-box">
            <div class="form-value">
                <div class="col-lg-12 text-center mb-4">
                    <div class="logo-container">
                        <img src="{{ asset('assets/images/logo/Logo-ICAV.png') }}" alt="Logo 1" class="logo mx-3" style="width: 80px; height: auto;">
                        <img src="{{ asset('assets/images/logo/Logo-Atdag-Canberra.png') }}" alt="Logo 2" class="logo mx-3" style="width: 100px; height: auto;">
                    </div>
                </div>
                <form method="POST" action="{{ route('testimonial.login') }}">
                    <h2>Login</h2>

                    <!-- Display error or success messages -->
                    @if ($errors->any())
                    <div style="color: red; text-align: center; margin-bottom: 10px">
                        {{ $errors->first() }}
                    </div>
                    @endif @if (session('success'))
                    <div style="color: green; text-align: center; margin-bottom: 10px">
                        {{ session('success') }}
                    </div>
                    @endif @csrf
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input
                            type="text"
                            name="username"
                            required
                            value="{{ old('username') }}" />
                        <label for="">Username</label>
                    </div>

                    <div class="inputbox">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required />
                        <label for="">Password</label>
                        <ion-icon
                            name="eye-off-outline"
                            id="togglePassword"
                            onclick="togglePassword()"></ion-icon>
                    </div>

                    <button type="submit">Log in</button>
                    <div class="register">
                        <p>
                            Don't have a account
                            <a href="{{ route('testimonial.register') }}">Register</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- footer starts  -->
    <footer class="site-footer">
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
            </div>
        </div>
    </footer>

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
    <script
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script
        nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.setAttribute("name", "eye-outline"); // Mata terbuka
            } else {
                passwordInput.type = "password";
                toggleIcon.setAttribute("name", "eye-off-outline"); // Mata tertutup
            }
        }
    </script>
</body>


</html>