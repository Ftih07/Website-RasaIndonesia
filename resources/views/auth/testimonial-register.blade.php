<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Reset default styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for the form */
        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        /* Form title */
        .form-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        /* Form inputs */
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Button styling */
        .form-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Button hover effect */
        .form-container button:hover {
            background-color: #45a049;
        }

        /* Placeholder styling */
        input::placeholder {
            color: #999;
            font-size: 14px;
        }

        /* Add focus effect to inputs */
        .form-container input:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 4px rgba(76, 175, 80, 0.3);
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 class="form-title">Register</h2>

        <!-- Display success or error messages -->
        @if ($errors->any())
        <div style="color: red; text-align: center; margin-bottom: 10px;">
            {{ $errors->first() }}
        </div>
        @endif

        @if (session('success'))
        <div style="color: green; text-align: center; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('testimonial.register') }}">
            @csrf
            <input type="text" name="username" placeholder="Enter your username" required value="{{ old('username') }}">
            <input type="password" name="password" id="password" placeholder="Enter your password" required>

            <!-- Checkbox to show password -->
            <input type="checkbox" id="show-password" onclick="togglePassword()"> Show Password

            <button type="submit">Register</button>

            <div class="forgot-password">
                Already have an account? <a href="{{ route('testimonial.login') }}">Login</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>



</html>