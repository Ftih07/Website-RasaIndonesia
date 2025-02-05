<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        @import url();

        * {
            margin: 0;
            padding: 0;
            font-family: 'poppins', sans-serif;
        }

        section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;

            background: url('https://marksel.co.id/site/assets/files/1444/333_1000.jpg')no-repeat;
            background-position: center;
            background-size: cover;
        }

        .form-box {
            position: relative;
            width: 400px;
            height: 450px;
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
            background: #fff;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
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
    </style>
</head>

<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form method="POST" action="{{ route('testimonial.register') }}">
                    <h2>Register</h2>

                    <!-- Display success or error messages -->
                    @if ($errors->any())
                    <div style="color: red; text-align: center; margin-bottom: 10px">
                        {{ $errors->first() }}
                    </div>
                    @endif @if (session('success'))
                    <div style="color: green; text-align: center; margin-bottom: 10px">
                        {{ session('success') }}
                    </div>
                    @endif @csrf

                    <!-- Username -->
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input
                            type="text"
                            name="username"
                            required
                            value="{{ old('username') }}" />
                        <label for="">Username</label>
                    </div>

                    <!-- Password -->
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

                    <button type="submit">Register</button>
                    <div class="register">
                        <p>
                            Already have an account?
                            <a href="{{ route('testimonial.login') }}">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>

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