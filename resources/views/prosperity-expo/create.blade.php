<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Primary Meta Tags --}}
    <title>Register for Prosperity Expo 2025 - Indonesia-Australia Trade & Investment Exhibition</title>
    <link rel="icon" href="{{ asset('assets/images/logo/IAPEX_Logo.png') }}" type="image/x-icon" />

    <meta name="description" content="Register now for Prosperity Expo 2025, the premier Indonesia-Australia Trade & Investment Exhibition. Secure your spot as an exhibitor, sponsor, or visitor to foster economic collaboration.">
    <meta name="keywords" content="Prosperity Expo, registration, daftar pameran, Indonesia Australia, trade exhibition, investment forum, exhibitor, sponsor, visitor, business event, 2025 expo">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook Meta Tags --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Register for Prosperity Expo 2025">
    <meta property="og:description" content="Register now for Prosperity Expo 2025, the premier Indonesia-Australia Trade & Investment Exhibition. Secure your spot as an exhibitor, sponsor, or visitor to foster economic collaboration.">
    <meta property="og:image" content="{{ asset('assets/images/logo/IAPEX_Logo.png') }}"> 
    <meta property="og:image:alt" content="Prosperity Expo 2025 Registration Banner">

    {{-- Twitter Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Register for Prosperity Expo 2025">
    <meta name="twitter:description" content="Register now for Prosperity Expo 2025, the premier Indonesia-Australia Trade & Investment Exhibition. Secure your spot as an exhibitor, sponsor, or visitor to foster economic collaboration.">
    <meta name="twitter:image" content="{{ asset('assets/images/logo/IAPEX_Logo.png') }}"> 
    <meta name="twitter:image:alt" content="Prosperity Expo 2025 Registration Banner">

    {{-- Link to Font Awesome for icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Global Reset and Box Sizing */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling: Sets background, font, and ensures full viewport height */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            /* Gradient background */
            min-height: 100vh;
            /* Ensures body takes full height */
            padding: 20px;
            /* Padding around the main content */
        }

        /* Container Styling: Main wrapper for the form, centered on the page */
        .container {
            max-width: 800px;
            /* Maximum width of the container */
            margin: 0 auto;
            /* Centers the container horizontally */
            background: rgba(255, 255, 255, 0.95);
            /* Semi-transparent white background */
            backdrop-filter: blur(20px);
            /* Blurs content behind the container */
            border-radius: 20px;
            /* Rounded corners */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            /* Soft shadow for depth */
            overflow: hidden;
            /* Hides any overflowing content */
        }

        /* Header Section Styling */
        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            /* Dark blue gradient background */
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            /* Needed for the pseudo-element animation */
            overflow: hidden;
        }

        /* Header Background Animation: Creates a subtle animated pattern */
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(45deg,
                    transparent,
                    transparent 10px,
                    rgba(255, 255, 255, 0.05) 10px,
                    rgba(255, 255, 255, 0.05) 20px);
            /* Repeating diagonal lines */
            animation: slide 20s linear infinite;
            /* Animation definition */
        }

        /* Keyframes for the header background animation */
        @keyframes slide {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Ensures header content is above the animated background */
        .header-content {
            position: relative;
            z-index: 2;
        }

        /* Header Title Styling */
        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            /* Text shadow for readability */
        }

        /* Header Subtitle Styling */
        .header .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        /* Event Info Section Styling */
        .header .event-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            /* Allows items to wrap on smaller screens */
            margin-top: 20px;
        }

        /* Individual Event Detail Styling */
        .event-detail {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        /* Form Container Styling */
        .form-container {
            padding: 40px 30px;
        }

        /* Error Message Container Styling (for Laravel validation errors) */
        .error-container {
            background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
            /* Red gradient background */
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            border-left: 5px solid #ff4757;
            /* Left border for emphasis */
        }

        .error-container ul {
            list-style: none;
            /* Removes bullet points */
        }

        .error-container li {
            padding: 5px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-container li::before {
            content: '⚠';
            /* Warning icon */
            font-size: 1.2rem;
        }

        /* Form Group Styling: Wrapper for label and input */
        .form-group {
            margin-bottom: 25px;
        }

        /* Form Label Styling */
        .form-group label {
            display: block;
            /* Makes label take full width */
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        /* Form Control (Input/Textarea) Styling */
        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e6ed;
            /* Light gray border */
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            /* Smooth transitions for focus/hover */
            background: #fafbfc;
            /* Light background color */
        }

        /* Form Control Focus State */
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            /* Blue border on focus */
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            /* Soft blue shadow */
            transform: translateY(-2px);
            /* Slight lift effect */
        }

        /* Form Control Hover State */
        .form-control:hover {
            border-color: #c5d2ea;
            /* Slightly darker border on hover */
        }

        /* Textarea Specific Styling */
        textarea.form-control {
            resize: vertical;
            /* Allows vertical resizing */
            min-height: 120px;
        }

        /* Radio Button Group Styling */
        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Individual Radio Option Styling */
        .radio-option {
            position: relative;
            display: flex;
            align-items: center;
            padding: 20px;
            border: 2px solid #e0e6ed;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        /* Radio Option Hover State */
        .radio-option:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
            transform: translateY(-2px);
        }

        /* Hides the default radio input */
        .radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        /* Custom Radio Button Checked State */
        .radio-option input[type="radio"]:checked+.radio-custom {
            background: #667eea;
            border-color: #667eea;
        }

        .radio-option input[type="radio"]:checked+.radio-custom::after {
            opacity: 1;
            /* Shows the inner dot when checked */
        }

        /* Custom Radio Button Visual (outer circle) */
        .radio-custom {
            width: 24px;
            height: 24px;
            border: 2px solid #ddd;
            border-radius: 50%;
            margin-right: 15px;
            position: relative;
            transition: all 0.3s ease;
            flex-shrink: 0;
            /* Prevents shrinking */
        }

        /* Custom Radio Button Inner Dot (when checked) */
        .radio-custom::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            /* Hidden by default */
            transition: opacity 0.3s ease;
        }

        /* Radio Label Styling */
        .radio-label {
            flex: 1;
            /* Takes remaining space */
            font-weight: 500;
            color: #2c3e50;
        }

        /* Price Tag Styling for Radio Options */
        .price-tag {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            /* Pink/red gradient */
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-left: 10px;
        }

        /* File Upload Styling */
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        /* Hides default file input */
        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        /* Custom File Upload Label (the visible drag-and-drop area) */
        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 20px;
            border: 2px dashed #c5d2ea;
            /* Dashed border */
            border-radius: 12px;
            background: #fafbfc;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #5a6c7d;
        }

        /* File Upload Label Hover State */
        .file-upload-label:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
            color: #667eea;
        }

        /* Icon within file upload label */
        .file-upload-label i {
            font-size: 1.5rem;
        }

        /* Submit Button Styling */
        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            /* Blue/purple gradient */
            color: white;
            border: none;
            padding: 18px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        /* Submit Button Hover Animation (shine effect) */
        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            /* Starts off-screen to the left */
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            /* White translucent gradient */
            transition: left 0.5s;
            /* Animates from left to right */
        }

        .submit-btn:hover::before {
            left: 100%;
            /* Moves to off-screen right on hover */
        }

        /* Submit Button Hover and Active States */
        .submit-btn:hover {
            transform: translateY(-2px);
            /* Slight lift */
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            /* Larger shadow */
        }

        .submit-btn:active {
            transform: translateY(0);
            /* Resets on click */
        }

        /* Partnership Badge Styling */
        .partnership-badge {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #f6f9fc 0%, #f1f5f9 100%);
            /* Light gray gradient */
            border-radius: 12px;
            border: 1px solid #e0e6ed;
        }

        .partnership-badge p {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        /* Flags and Handshake Icon Styling */
        .flags {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            font-size: 2rem;
            /* Emoji size */
        }

        /* Prosperity Icon Animation */
        .prosperity-icon {
            display: inline-block;
            animation: pulse 2s infinite;
            /* Pulsating animation */
        }

        /* Keyframes for the pulse animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Media Queries for Responsiveness */

        /* Large tablets and small desktops */
        @media (max-width: 1024px) {
            .container {
                max-width: 90%;
                margin: 20px auto;
            }

            .header h1 {
                font-size: 2.2rem;
            }

            .form-container {
                padding: 35px 25px;
            }
        }

        /* Tablets */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                margin: 0;
                /* Remove margin to fill screen width */
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }

            .header {
                padding: 25px 20px;
            }

            .header h1 {
                font-size: 1.8rem;
                line-height: 1.2;
            }

            .header .subtitle {
                font-size: 0.95rem;
                margin-bottom: 15px;
            }

            .event-info {
                flex-direction: column;
                /* Stack event details vertically */
                gap: 12px;
            }

            .event-detail {
                font-size: 0.85rem;
                justify-content: center;
            }

            .form-container {
                padding: 25px 20px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .radio-option {
                padding: 15px;
                flex-direction: column;
                /* Stack radio content vertically */
                text-align: center;
                gap: 10px;
            }

            .radio-custom {
                margin-right: 0;
                align-self: center;
            }

            .radio-label {
                text-align: center;
            }

            .price-tag {
                margin-left: 0;
                margin-top: 8px;
                align-self: center;
            }

            .file-upload-label {
                flex-direction: column;
                /* Stack file upload label content vertically */
                gap: 8px;
                text-align: center;
                padding: 15px;
            }

            .submit-btn {
                padding: 16px 30px;
                font-size: 1rem;
            }
        }

        /* Large phones */
        @media (max-width: 480px) {
            body {
                padding: 5px;
            }

            .header {
                padding: 20px 15px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .header .subtitle {
                font-size: 0.9rem;
            }

            .form-container {
                padding: 20px 15px;
            }

            .form-group label {
                font-size: 0.9rem;
            }

            .form-control {
                padding: 12px 15px;
                font-size: 0.95rem;
            }

            .radio-option {
                padding: 12px;
            }

            .radio-label strong {
                font-size: 0.95rem;
            }

            .radio-label p {
                font-size: 0.8rem !important;
            }

            .price-tag {
                font-size: 0.8rem;
                padding: 6px 12px;
            }

            .file-upload-label {
                padding: 12px;
                font-size: 0.9rem;
            }

            .submit-btn {
                padding: 14px 25px;
                font-size: 0.95rem;
            }

            .partnership-badge {
                padding: 15px;
                margin-top: 25px;
            }

            .partnership-badge p {
                font-size: 0.85rem;
            }

            .flags {
                font-size: 1.5rem;
            }
        }

        /* Small phones */
        @media (max-width: 360px) {
            .header h1 {
                font-size: 1.3rem;
            }

            .header .subtitle {
                font-size: 0.85rem;
            }

            .event-detail {
                font-size: 0.8rem;
            }

            .form-container {
                padding: 15px 10px;
            }

            .form-control {
                padding: 10px 12px;
            }

            .radio-option {
                padding: 10px;
            }

            .submit-btn {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }

        /* Landscape orientation adjustments */
        @media (max-height: 500px) and (orientation: landscape) {
            .header {
                padding: 15px 20px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .header .subtitle {
                margin-bottom: 10px;
            }

            .event-info {
                margin-top: 10px;
            }

            .form-container {
                padding: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2),
        (min-resolution: 192dpi) {
            .container {
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            }

            .header::before {
                opacity: 0.8;
            }
        }

        /* Touch-friendly enhancements (for devices with coarse pointers like fingers) */
        @media (pointer: coarse) {
            .form-control {
                padding: 16px 18px;
                font-size: 16px;
                /* Prevents zoom on iOS when input is focused */
            }

            .radio-option {
                padding: 18px;
                min-height: 60px;
                /* Ensures a larger touch target */
            }

            .radio-custom {
                width: 28px;
                height: 28px;
            }

            .submit-btn {
                padding: 18px 35px;
                min-height: 56px;
                /* Ensures a larger touch target */
            }

            .file-upload-label {
                padding: 20px;
                min-height: 80px;
                /* Ensures a larger touch target */
            }
        }

        /* Header Partners Section - Tambahkan CSS ini ke dalam <style> tag */

        /* Header Partners Container */
        .header-partners {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border-bottom: 1px solid #e2e8f0;
            padding: 25px 30px;
            text-align: center;
            position: relative;
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        /* Header Partners Content */
        .header-partners-content {
            position: relative;
            z-index: 2;
        }

        /* Header Partners Title */
        .header-partners-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            position: relative;
        }

        /* Decorative line under title */
        .header-partners-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1px;
        }

        /* Header Logos Container */
        .header-logos-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 35px;
            flex-wrap: wrap;
        }

        /* Individual Header Logo Item */
        .header-logo-item {
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 15px;
            padding: 18px 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
            position: relative;
            overflow: hidden;
        }

        /* Subtle background pattern for logo items */
        .header-logo-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Header Logo Item Hover Effect */
        .header-logo-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .header-logo-item:hover::before {
            opacity: 1;
        }

        /* Header Partner Logo Image */
        .header-partner-logo {
            max-height: 55px;
            max-width: 140px;
            width: auto;
            height: auto;
            object-fit: contain;
            filter: brightness(0.95);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        /* Header Logo Hover Effect */
        .header-logo-item:hover .header-partner-logo {
            filter: brightness(1);
            transform: scale(1.05);
        }

        /* Animation for individual logos */
        .header-logo-item:nth-child(1) {
            animation: slideInFromLeft 0.6s ease-out 0.8s both;
        }

        .header-logo-item:nth-child(2) {
            animation: slideInFromBottom 0.6s ease-out 1s both;
        }

        .header-logo-item:nth-child(3) {
            animation: slideInFromRight 0.6s ease-out 1.2s both;
        }

        /* Keyframes for logo animations */
        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-50px);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInFromRight {
            0% {
                transform: translateX(50px);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInFromBottom {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Responsive Design for Header Logos */
        @media (max-width: 768px) {
            .header-partners {
                padding: 20px 20px;
            }

            .header-logos-container {
                gap: 25px;
            }

            .header-logo-item {
                padding: 15px 20px;
            }

            .header-partner-logo {
                max-height: 45px;
                max-width: 120px;
            }

            .header-partners-title {
                font-size: 0.85rem;
                margin-bottom: 18px;
            }
        }

        @media (max-width: 480px) {
            .header-partners {
                padding: 18px 15px;
            }

            .header-logos-container {
                gap: 20px;
            }

            .header-logo-item {
                padding: 12px 15px;
                flex: 1;
                min-width: 100px;
                max-width: 130px;
            }

            .header-partner-logo {
                max-height: 40px;
                max-width: 100px;
            }

            .header-partners-title {
                font-size: 0.8rem;
                margin-bottom: 15px;
            }
        }

        /* Print optimization */
        @media print {
            .header-partners {
                background: white !important;
                -webkit-print-color-adjust: exact;
            }

            .header-logo-item {
                box-shadow: none;
                border: 1px solid #e2e8f0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- Header section of the registration form --}}
        <div class="header">
            <div class="header-content">
                <h1><i class="fas fa-handshake prosperity-icon"></i> Prosperity Expo 2025</h1>
                <p class="subtitle">Indonesia-Australia Trade & Investment Exhibition</p>
                <div class="event-info">
                    <div class="event-detail">
                        <i class="fas fa-calendar-alt"></i>
                        <span>2025</span>
                    </div>
                    <div class="event-detail">
                        <i class="fas fa-globe-asia"></i>
                        <span>Indonesia-Australia Partnership</span>
                    </div>
                    <div class="event-detail">
                        <i class="fas fa-chart-line"></i>
                        <span>Economic Collaboration</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Partner Logos Header Section - Tambahkan setelah closing div success-header dan sebelum content-section -->
        <div class="header-partners">
            <div class="header-partners-content">
                <p class="header-partners-title">Official Partners</p>
                <div class="header-logos-container">
                    <div class="header-logo-item">
                        <img src="https://framerusercontent.com/images/fGCgpHRiychMw8xfk26Tri4H0w.png" alt="Katalis" class="header-partner-logo">
                    </div>
                    <div class="header-logo-item">
                        <img src="https://cdn-az.allevents.in/events4/banners/7c40abc0bbe380f162da8a9afd2fb72e2ae150b0610da261abfaab51667528be-rimg-w400-h400-gmir.png?v=1681264687" alt="KBRI Canberra" class="header-partner-logo">
                    </div>
                    <div class="header-logo-item">
                        <img src="https://tanya-atdag.au/wp-content/uploads/2025/01/Logo-Atdag-Canberra.png" alt="Atdag Canberra" class="header-partner-logo">
                    </div>
                </div>
            </div>
        </div>
        {{-- Main form container --}}
        <div class="form-container">
            {{-- Blade directive to display validation errors if any --}}
            @if ($errors->any())
            <div class="error-container">
                <h4 style="margin-bottom: 15px;"><i class="fas fa-exclamation-triangle"></i> Please correct the following errors:</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- The registration form itself --}}
            <form action="{{ route('prosperity-expo.store') }}" method="POST" enctype="multipart/form-data">
                @csrf {{-- CSRF token for security in Laravel forms --}}

                {{-- Full Name Input --}}
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name *</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
                </div>

                {{-- Email Address Input --}}
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address *</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="your.email@company.com" required>
                </div>

                {{-- Company Name / Brand Input --}}
                <div class="form-group">
                    <label for="company_name"><i class="fas fa-building"></i> Company Name / Brand *</label>
                    <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Your company or brand name" required>
                </div>

                {{-- Position / Title Input --}}
                <div class="form-group">
                    <label for="position"><i class="fas fa-id-badge"></i> Position / Title *</label>
                    <input type="text" name="position" id="position" class="form-control" placeholder="Your job title or position" required>
                </div>

                {{-- Phone / WhatsApp Number Input --}}
                <div class="form-group">
                    <label for="contact"><i class="fas fa-phone"></i> Phone / WhatsApp Number *</label>
                    <input type="text" name="contact" id="contact" class="form-control" placeholder="+62 xxx-xxxx-xxxx" required>
                </div>

                {{-- Participation Type Radio Buttons --}}
                <div class="form-group">
                    <label><i class="fas fa-users"></i> Participation Type *</label>
                    <div class="radio-group">
                        <label class="radio-option" for="exhibitor">
                            <input type="radio" id="exhibitor" name="participant_type" value="Exhibitor : Rp. 10.000.000" required>
                            <div class="radio-custom"></div>
                            <div class="radio-label">
                                <strong>Exhibitor Package</strong>
                                <span class="price-tag">Rp. 10.000.000</span>
                                <p style="margin-top: 8px; font-size: 0.9rem; color: #64748b;">Display your products and services to international audience</p>
                            </div>
                        </label>
                        <label class="radio-option" for="sponsor">
                            <input type="radio" id="sponsor" name="participant_type" value="Sponsor : Rp. 25.000.000">
                            <div class="radio-custom"></div>
                            <div class="radio-label">
                                <strong>Sponsor Package</strong>
                                <span class="price-tag">Rp. 25.000.000</span>
                                <p style="margin-top: 8px; font-size: 0.9rem; color: #64748b;">Premium visibility and branding opportunities</p>
                            </div>
                        </label>
                        <label class="radio-option" for="Visitor">
                            <input type="radio" id="Visitor" name="participant_type" value="Visitor : Free" required>
                            <div class="radio-custom"></div>
                            <div class="radio-label">
                                <strong>Visitor</strong>
                                <span class="price-tag">Free</span>
                                <p style="margin-top: 8px; font-size: 0.9rem; color: #64748b;">Visit the exhibition for free, discover a wide range of offerings, and forge valuable connections.</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Type of Business / Industry Input --}}
                <div class="form-group">
                    <label for="company_type"><i class="fas fa-industry"></i> Type of Business / Industry *</label>
                    <input type="text" name="company_type" id="company_type" class="form-control" placeholder="e.g., Manufacturing, Technology, Services, etc." required>
                </div>

                {{-- Brief Description of Products/Services Textarea --}}
                <div class="form-group">
                    <label for="product_description"><i class="fas fa-clipboard-list"></i> Brief Description of Products/Services *</label>
                    <textarea name="product_description" id="product_description" class="form-control" placeholder="Describe your products or services that will be showcased at the expo..." required></textarea>
                </div>

                {{-- Social Media Username Input (Optional) --}}
                <div class="form-group">
                    <label for="company_social_media_username"><i class="fas fa-share-alt"></i> Social Media Username</label>
                    <input type="text" name="company_social_media_username" id="company_social_media_username" class="form-control" placeholder="@yourbrand (Instagram, Twitter, LinkedIn, etc.)">
                </div>

                {{-- Company Profile Document Upload --}}
                <div class="form-group">
                    <label><i class="fas fa-file-upload"></i> Company Profile Document (Optional)</label>
                    <div class="file-upload">
                        <input type="file" name="company_profile" id="company_profile" accept=".pdf,.doc,.docx">
                        <label for="company_profile" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Click to upload your company profile (PDF, DOC, DOCX)</span>
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Register for Prosperity Expo 2025
                </button>

                {{-- Partnership Badge Section --}}
                <div class="partnership-badge">
                    <p><strong>Strengthening Indonesia-Australia Partnership</strong></p>
                    <div class="flags">
                        🇮🇩 <i class="fas fa-handshake" style="color: #667eea; font-size: 1.5rem;"></i> 🇦🇺
                    </div>
                    <p style="margin-top: 10px; font-style: italic;">Building bridges for trade, investment, and sustainable growth</p>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript for client-side enhancements --}}
    <script>
        // JavaScript for updating the file upload label with the selected file name.
        document.getElementById('company_profile').addEventListener('change', function(e) {
            const label = document.querySelector('.file-upload-label span');
            if (e.target.files.length > 0) {
                // If a file is selected, update the label to show the file name and a check icon.
                label.innerHTML = '<i class="fas fa-check-circle" style="color: #10b981;"></i> ' + e.target.files[0].name;
            } else {
                // If no file is selected (e.g., user cancels), revert to original text.
                label.innerHTML = 'Click to upload your company profile (PDF, DOC, DOCX)';
            }
        });

        // Basic client-side form validation before submission.
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = document.querySelectorAll('input[required], textarea[required]');
            let allValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    // If a required field is empty, mark it as invalid visually.
                    allValid = false;
                    field.style.borderColor = '#ef4444'; // Red border
                    field.style.backgroundColor = '#fef2f2'; // Light red background
                } else {
                    // If a required field is filled, mark it as valid visually.
                    field.style.borderColor = '#10b981'; // Green border
                    field.style.backgroundColor = '#f0fdf4'; // Light green background
                }
            });

            if (!allValid) {
                e.preventDefault(); // Prevent form submission if not all required fields are filled.
                alert('Please fill in all required fields.'); // Show a simple alert message.
            }
        });

        // JavaScript for adding a subtle hover/focus effect to form inputs.
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                // On focus, slightly enlarge the parent form group.
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                // On blur, revert the size of the parent form group.
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>

</html>