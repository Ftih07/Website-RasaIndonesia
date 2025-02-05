<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                @if (session('success'))
                <div style="color: green; text-align: center; margin-bottom: 10px">
                    {{ session('success') }}
                </div>
                @endif
                <form
                    method="POST"
                    action="{{ route('testimonial.profile.update') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <h2>Edit Profile</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input
                            type="text"
                            name="username"
                            value="{{ $user->username }}"
                            required
                            class="form-input" />
                        <label for="">Username</label>
                    </div>

                    <div class="inputbox">
                        <input type="password" name="password" class="form-input" id="password" />
                        <label for="">Password</label>
                        <ion-icon
                            name="eye-off-outline"
                            id="togglePassword"
                            onclick="togglePassword()"></ion-icon>
                    </div>

                    <div class="inputbox">
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-input" />
                        <label for="">Confirm Password</label>
                        <ion-icon
                            name="eye-off-outline"
                            id="togglePassword"
                            onclick="togglePassword()"></ion-icon>
                    </div>
                    <label for="profile_picture" class="label">Update Profile Picture</label>

                    <!-- Preview Image -->
                    <div class="image-preview-container">
                        <img
                            id="profilePreview"
                            src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'default-profile.jpg' }}"
                            alt="Profile Picture"
                            class="profile-preview" />
                    </div>

                    <input
                        type="file"
                        name="profile_picture"
                        accept="image/*"
                        id="profile_picture"
                        class="form-input-file"
                        onchange="previewImage(event)" />

                    <button type="submit" class="btn-submit">Update Profile</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Styling -->
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

            background: url('https://www.astronauts.id/blog/wp-content/uploads/2022/08/Makanan-Khas-Daerah-tiap-Provinsi-di-Indonesia-Serta-Daerah-Asalnya-1024x683.jpg')no-repeat;
            background-position: center;
            background-size: cover;
        }

        .form-box {
            position: relative;
            width: 600px;
            height: 650px;
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
            margin-bottom: 15%;
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

        .forget label a, .label {
            color: #fff;
            text-decoration: none;
        }

        .forget label a:hover {
            text-decoration: underline;
        }

        button {
            margin-top: 8%;
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

        .image-preview-container {
            text-align: center;
            margin: 15px 0;
        }

        .profile-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        /* Success message styling */
        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 10px;
            font-size: 16px;
        }
    </style>

    <!-- JavaScript for Image Preview -->
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById('profilePreview');
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

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