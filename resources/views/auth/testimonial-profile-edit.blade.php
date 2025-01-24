<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="form-container">
        <h2 class="form-title">Edit Profile</h2>

        @if (session('success'))
        <div style="color: green; text-align: center; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('testimonial.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <input type="text" name="username" value="{{ $user->username }}" required placeholder="Enter new username" class="form-input">

            <input type="password" name="password" placeholder="Enter new password (optional)" class="form-input">
            <input type="password" name="password_confirmation" placeholder="Confirm new password (optional)" class="form-input">

            <label for="profile_picture" class="label">Update Profile Picture</label>

            <!-- Preview Image -->
            <div class="image-preview-container">
                <img id="profilePreview" src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'default-profile.jpg' }}" alt="Profile Picture" class="profile-preview">
            </div>

            <input type="file" name="profile_picture" accept="image/*" id="profile_picture" class="form-input-file" onchange="previewImage(event)">

            <button type="submit" class="btn-submit">Update Profile</button>

            <button type="button" onclick="window.location.href='{{ route('home') }}'">
                Home
            </button>
        </form>
    </div>

    <!-- Styling -->
    <style>
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: #fff;
        }

        .label {
            font-size: 16px;
            margin-top: 10px;
            display: block;
        }

        .form-input-file {
            margin-top: 10px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #45a049;
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



</body>

</html>