<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="@yield('favicon', asset('assets/images/logo/logo.png'))">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- bootstrap  -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- for swiper slider  -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">

    <!-- fancy box  -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">

    <title>Register | Taste of Indonesia</title>
    <link rel="stylesheet" href="{{ asset('assets/css/testimonial-register.css') }}">
</head>

<body>
    <!-- Register Form -->
    <section>
        <div class="form-box">
            <div class="form-value">
                <div class="col-lg-12 text-center mb-4">
                    <div class="logo-container">
                        <img src="{{ asset('assets/images/logo/Logo-ICAV.png') }}" alt="Logo 1" class="logo mx-3" style="width: 80px; height: auto;">
                        <img src="{{ asset('assets/images/logo/Logo-Atdag-Canberra.png') }}" alt="Logo 2" class="logo mx-3" style="width: 100px; height: auto;">
                    </div>
                </div>

                <form method="POST" action="{{ route('testimonial.register') }}">
                    <h2>Register</h2>
                    @csrf

                    {{-- Success/Error --}}
                    @if (session('success'))
                    <div style="color: green; text-align: center; margin-bottom: 10px">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div style="color: red; text-align: center; margin-bottom: 10px">
                        {{ $errors->first() }}
                    </div>
                    @endif

                    {{-- Username / Email --}}
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" name="username" required value="{{ old('username') }}" />
                        <label>Email / Username</label>
                    </div>

                    {{-- Address --}}
                    <div class="inputbox">
                        <ion-icon name="home-outline"></ion-icon>
                        <input type="text" name="address" required value="{{ old('address') }}" />
                        <label>Address</label>
                    </div>

                    {{-- Contact --}}
                    <div class="inputbox">
                        <ion-icon name="call-outline"></ion-icon>
                        <input type="text" name="contact" required value="{{ old('contact') }}" />
                        <label>Contact</label>
                    </div>

                    {{-- Password --}}
                    <div class="inputbox">
                        <input type="password" name="password" id="password" required />
                        <label>Password</label>
                        <ion-icon name="eye-off-outline" id="togglePassword" onclick="togglePassword()"></ion-icon>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="inputbox">
                        <input type="password" name="password_confirmation" required />
                        <label>Confirm Password</label>
                    </div>

                    <button type="submit">Register</button>

                    <div class="register">
                        <p>
                            Already have an account?
                            <a href="{{ route('testimonial.login') }}">Login</a>
                        </p>
                    </div>
                    <a href="{{ route('google.redirect') }}" class="btn btn-danger w-full text-white">
                        <i class="fab fa-google mr-2"></i> Login/Register with Google
                    </a>
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
        /**
         * Toggle Password Visibility
         * This function toggles the visibility of the password input field.
         * It also changes the icon to indicate whether the password is visible or hidden.
         */
        function togglePassword() {
            const passwordInput = document.getElementById("password"); // Get the password input field
            const toggleIcon = document.getElementById("togglePassword"); // Get the toggle icon

            if (passwordInput.type === "password") { // If password is hidden
                passwordInput.type = "text"; // Show password
                toggleIcon.setAttribute("name", "eye-outline"); // Change icon to open eye
            } else { // If password is visible
                passwordInput.type = "password"; // Hide password
                toggleIcon.setAttribute("name", "eye-off-outline"); // Change icon to closed eye
            }
        }
    </script>
</body>



</html>