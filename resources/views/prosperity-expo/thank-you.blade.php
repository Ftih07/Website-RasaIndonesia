<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - Prosperity Expo 2025</title>
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
            position: relative;
            /* Needed for background animations */
            overflow-x: hidden;
            /* Prevents horizontal scrollbar due to animations */
        }

        /* Animated Background Elements: Creates a dynamic visual effect in the background */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            /* Ensures it stays behind the main content */
            overflow: hidden;
        }

        /* Individual Floating Shapes (stars, trophies, handshakes) */
        .floating-shape {
            position: absolute;
            opacity: 0.1;
            /* Subtle transparency */
            animation: float 6s ease-in-out infinite;
            /* Floating animation */
        }

        /* Specific positioning and animation delays for each shape */
        .floating-shape:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-shape:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        /* Keyframes for the floating animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
                /* Start and end at original Y position */
            }

            50% {
                transform: translateY(-20px);
                /* Moves up by 20px in the middle of animation */
            }
        }

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

        /* Main Container Styling: Wrapper for the thank-you message and details */
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            /* Semi-transparent white background */
            backdrop-filter: blur(20px);
            /* Blurs content behind */
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            z-index: 1;
            /* Ensures it's above the background animation */
        }

        /* Success Header Styling: Top section with confirmation message */
        .success-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            /* Green gradient */
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Success Header Background Animation: Subtle repeating pattern */
        .success-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(45deg,
                    transparent,
                    transparent 10px,
                    rgba(255, 255, 255, 0.1) 10px,
                    rgba(255, 255, 255, 0.1) 20px);
            animation: celebrateSlide 15s linear infinite;
            /* Animation definition */
        }

        /* Keyframes for the header background animation */
        @keyframes celebrateSlide {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Ensures success content is above the animated background */
        .success-content {
            position: relative;
            z-index: 2;
        }

        /* Success Icon Styling and Animation */
        .success-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: bounceIn 1s ease-out;
            /* Bounce-in animation */
        }

        /* Keyframes for bounce-in animation */
        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        /* Success Title Styling and Animation */
        .success-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            animation: slideInFromTop 0.8s ease-out 0.3s both;
            /* Slide-in from top with delay */
        }

        /* Keyframes for slide-in from top animation */
        @keyframes slideInFromTop {
            0% {
                transform: translateY(-50px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Success Subtitle Styling and Animation */
        .success-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            animation: slideInFromBottom 0.8s ease-out 0.5s both;
            /* Slide-in from bottom with delay */
        }

        /* Keyframes for slide-in from bottom animation */
        @keyframes slideInFromBottom {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Content Section Styling: Main body of the thank-you page */
        .content-section {
            padding: 40px 30px;
        }

        /* Participant Info Section Styling and Animation */
        .participant-info {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            /* Light gray gradient */
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
            animation: fadeInUp 0.8s ease-out 0.7s both;
            /* Fade-in up animation with delay */
        }

        /* Keyframes for fade-in up animation */
        @keyframes fadeInUp {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Info Title Styling */
        .info-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Info Grid Styling: Layout for participant details */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            /* Responsive grid columns */
            gap: 20px;
        }

        /* Individual Info Item Styling */
        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            /* Smooth hover effect */
        }

        /* Info Item Hover State */
        .info-item:hover {
            transform: translateY(-2px);
            /* Slight lift on hover */
        }

        /* Info Icon Styling */
        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            /* Blue/purple gradient */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        /* Info Text Container */
        .info-text {
            flex: 1;
        }

        /* Info Label Styling */
        .info-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Info Value Styling */
        .info-value {
            font-size: 1rem;
            color: #1e293b;
            font-weight: 600;
            margin-top: 2px;
        }

        /* QR Section Styling and Animation */
        .qr-section {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            /* Dark gray gradient */
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out 0.9s both;
            /* Fade-in up animation with delay */
        }

        /* QR Section Background Grain Effect */
        .qr-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Inline SVG for subtle grain pattern */
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.03"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }

        /* QR Title Styling */
        .qr-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        /* QR Container Styling and Animation */
        .qr-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            display: inline-block;
            /* Allows centering with text-align */
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
            animation: pulse 2s infinite;
            /* Pulsating animation */
        }

        /* QR Code Image Styling */
        .qr-code img {
            border-radius: 8px;
            max-width: 200px;
            height: auto;
        }

        /* QR Instructions Styling */
        .qr-instructions {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-top: 15px;
            position: relative;
            z-index: 2;
        }

        /* Action Buttons Section Styling and Animation */
        .action-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
            animation: fadeInUp 0.8s ease-out 1.1s both;
            /* Fade-in up animation with delay */
        }

        /* General Button Styling */
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            /* Removes underline for links */
            position: relative;
            overflow: hidden;
        }

        /* Button Hover Animation (shine effect) */
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        /* Primary Button Styling (Download PDF) */
        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            /* Green gradient */
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        /* Secondary Button Styling (Print Page) */
        .btn-secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            /* Blue/purple gradient */
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        /* Next Steps Section Styling and Animation */
        .next-steps {
            background: linear-gradient(135deg, #fef3c7 0%, #fcd34d 100%);
            /* Yellow gradient */
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 5px solid #f59e0b;
            /* Orange left border */
            animation: fadeInUp 0.8s ease-out 1.3s both;
            /* Fade-in up animation with delay */
        }

        /* Next Steps Title Styling */
        .next-steps-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #92400e;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Steps List Styling (Numbered List) */
        .steps-list {
            list-style: none;
            /* Removes default bullets/numbers */
            counter-reset: step-counter;
            /* Initializes a counter for custom numbering */
        }

        /* Individual Step List Item Styling */
        .steps-list li {
            counter-increment: step-counter;
            /* Increments the counter for each list item */
            position: relative;
            padding-left: 50px;
            /* Space for the custom number circle */
            margin-bottom: 15px;
            color: #92400e;
            font-weight: 500;
        }

        /* Custom Number Circle for Steps List */
        .steps-list li::before {
            content: counter(step-counter);
            /* Displays the current counter value */
            position: absolute;
            left: 0;
            top: 0;
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            /* Orange gradient */
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Contact Info Section Styling and Animation */
        .contact-info {
            background: linear-gradient(135deg, #e0f2fe 0%, #b3e5fc 100%);
            /* Light blue gradient */
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            border: 1px solid #0284c7;
            /* Blue border */
            animation: fadeInUp 0.8s ease-out 1.5s both;
            /* Fade-in up animation with delay */
        }

        /* Contact Title Styling */
        .contact-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #0c4a6e;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* Contact Details Layout */
        .contact-details {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        /* Individual Contact Item Styling */
        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #0c4a6e;
            font-weight: 500;
            text-decoration: none;
        }

        .contact-info a {
            color: inherit;
            /* Mengikuti warna parent (warna teks normal) */
            text-decoration: none;
            /* Hilangkan underline */
            font-weight: 500;
            /* (Opsional) Biar tetap tegas kayak teks biasa */
        }

        .contact-info a:hover {
            text-decoration: underline;
            /* (Opsional) Kalau mau pas hover tetap ada efek */
        }

        /* Partnership Footer Styling */
        .partnership-footer {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-top: 1px solid #e2e8f0;
        }

        .partnership-footer p {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        /* Flags Styling (reused from registration form) */
        .flags {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        /* Responsive Design Media Queries */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                border-radius: 15px;
            }

            .success-header {
                padding: 30px 20px;
            }

            .success-title {
                font-size: 2rem;
            }

            .success-icon {
                font-size: 3rem;
            }

            .content-section {
                padding: 25px 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                /* Single column layout on smaller screens */
            }

            .action-buttons {
                flex-direction: column;
                /* Stack buttons vertically */
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .contact-details {
                flex-direction: column;
                /* Stack contact items vertically */
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .success-header {
                padding: 25px 15px;
            }

            .success-title {
                font-size: 1.7rem;
            }

            .content-section {
                padding: 20px 15px;
            }

            .qr-section {
                padding: 20px 15px;
            }

            .qr-code img {
                max-width: 150px;
            }
        }

        /* Print styles: Optimizes the page for printing */
        @media print {
            body {
                background: white;
                /* White background for print */
                padding: 0;
            }

            .container {
                box-shadow: none;
                /* Remove shadows */
                background: white;
            }

            .success-header {
                background: #10b981 !important;
                /* Force green background for print */
                -webkit-print-color-adjust: exact;
                /* Ensures colors are printed accurately */
            }

            .action-buttons {
                display: none;
                /* Hide buttons when printing */
            }
        }
    </style>
</head>

<body>
    {{-- Animated background with floating shapes --}}
    <div class="bg-animation">
        <div class="floating-shape">
            <i class="fas fa-star" style="font-size: 3rem; color: white;"></i>
        </div>
        <div class="floating-shape">
            <i class="fas fa-trophy" style="font-size: 2.5rem; color: white;"></i>
        </div>
        <div class="floating-shape">
            <i class="fas fa-handshake" style="font-size: 3.5rem; color: white;"></i>
        </div>
    </div>

    {{-- Main content container --}}
    <div class="container">
        {{-- Success confirmation header --}}
        <div class="success-header">
            <div class="success-content">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i> {{-- Checkmark icon --}}
                </div>
                <h1 class="success-title">Welcome to Prosperity Expo 2025!</h1>
                {{-- Displays participant's name dynamically from the passed $participant variable --}}
                <p class="success-subtitle">Thank you, {{ $participant->name }}! Your registration has been confirmed.</p>
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

        {{-- Main content section with participant details, QR code, and next steps --}}
        <div class="content-section">
            {{-- Participant Information display --}}
            <div class="participant-info">
                <h2 class="info-title">
                    <i class="fas fa-user-check"></i>
                    Registration Details
                </h2>
                <div class="info-grid">
                    {{-- Display Full Name --}}
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-text">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $participant->name }}</div>
                        </div>
                    </div>
                    {{-- Display Email Address --}}
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-text">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $participant->email }}</div>
                        </div>
                    </div>
                    {{-- Display Company/Brand --}}
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info-text">
                            <div class="info-label">Company/Brand</div>
                            <div class="info-value">{{ $participant->company_name }}</div>
                        </div>
                    </div>
                    {{-- Display Registration Date (using current date, as 'created_at' is for internal record) --}}
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="info-text">
                            <div class="info-label">Registration Date</div>
                            <div class="info-value">{{ date('F j, Y') }}</div>
                        </div>
                    </div>
                    {{-- Display Participant Type --}}
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info-text">
                            <div class="info-label">Participat Type</div>
                            <div class="info-value">{{ $participant->participant_type }}</div>
                        </div>
                    </div>
                    {{-- Display Contact User --}}
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info-text">
                            <div class="info-label">Phone / WhatsApp Number </div>
                            <div class="info-value">{{ $participant->contact }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- QR Code Section --}}
            <div class="qr-section">
                <h3 class="qr-title">
                    <i class="fas fa-qrcode"></i>
                    Your Event Access QR Code
                </h3>
                <div class="qr-container">
                    {{-- PHP block to generate QR code image as base64 string --}}
                    @php
                    // Uses SimpleSoftwareIO\QrCode to generate a PNG image of the participant's QR code UUID.
                    // The image data is then base64 encoded to be embedded directly into the HTML.
                    $qrImage = base64_encode(QrCode::format('png')->size(200)->generate($participant->qr_code));
                    @endphp
                    <div class="qr-code">
                        {{-- Displays the QR code image using the base64 encoded data URI --}}
                        <img src="data:image/png;base64,{{ $qrImage }}" alt="Event Access QR Code">
                    </div>
                </div>
                <p class="qr-instructions">
                    <i class="fas fa-mobile-alt"></i>
                    Save this QR code on your device or take a screenshot for quick check-in at the event
                </p>
            </div>

            {{-- Action Buttons: Download PDF and Print Page --}}
            <div class="action-buttons">
                {{-- Form to trigger PDF download --}}
                <form action="{{ route('prosperity-expo.download', ['qr_code' => $participant->qr_code]) }}" method="GET" style="display: inline;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-download"></i>
                        Download PDF Certificate
                    </button>
                </form>
                {{-- Button to print the current page --}}
                <button onclick="window.print()" class="btn btn-secondary">
                    <i class="fas fa-print"></i>
                    Print This Page
                </button>
            </div>

            {{-- Next Steps section --}}
            <div class="next-steps">
                <h3 class="next-steps-title">
                    <i class="fas fa-list-check"></i>
                    What's Next?
                </h3>
                <ol class="steps-list">
                    <li>Save or screenshot your QR code above for event check-in</li>
                    <li>Download your PDF certificate as backup documentation</li>
                    <li>Arrive at the venue with your QR code ready for scanning</li>
                </ol>
            </div>

            {{-- Contact Information section --}}
            <div class="contact-info">
                <h3 class="contact-title">
                    <i class="fas fa-headset"></i>
                    Need Help?
                </h3>
                <br>
                <div class="contact-details">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span><a href="mailto:sales.expo@kupu-gsc.co.id" target="_blank">sales.expo@kupu-gsc.co.id</a></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>Agi : <a href="https://wa.me/6281573000739" target="_blank">+62 815-7300-0739</a></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>Dewi : <a href="https://wa.me/62818201311" target="_blank">+62 818-201-311</a></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-globe"></i>
                        <span><a href="https://www.prosperity-expo.com" target="_blank" rel="noopener noreferrer">www.prosperity-expo.com</a></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Partnership Footer (reused from registration form) --}}
        <div class="partnership-footer">
            <p><strong>Indonesia-Australia Prosperity Expo 2025</strong></p>
            <div class="flags">
                🇮🇩 <i class="fas fa-handshake" style="color: #667eea; font-size: 1.5rem;"></i> 🇦🇺
            </div>
            <p>Building bridges for trade, investment, and sustainable growth</p>
        </div>
    </div>

    {{-- JavaScript for page enhancements --}}
    <script>
        // JavaScript for adding a confetti animation on page load to celebrate registration.
        window.addEventListener('load', function() {
            const colors = ['#10b981', '#667eea', '#f59e0b', '#ef4444', '#8b5cf6']; // Array of confetti colors

            function createConfetti() {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.width = '10px';
                confetti.style.height = '10px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)]; // Random color
                confetti.style.left = Math.random() * window.innerWidth + 'px'; // Random horizontal position
                confetti.style.top = '-10px'; // Start above the viewport
                confetti.style.zIndex = '1000'; // Ensure it's on top
                confetti.style.borderRadius = '50%'; // Make it circular
                confetti.style.pointerEvents = 'none'; // Don't block clicks

                document.body.appendChild(confetti);

                // Animate confetti falling and fading out.
                const fallAnimation = confetti.animate([{
                        transform: 'translateY(0px) rotate(0deg)',
                        opacity: 1
                    },
                    {
                        transform: `translateY(${window.innerHeight + 10}px) rotate(360deg)`, // Fall to bottom
                        opacity: 0
                    }
                ], {
                    duration: 3000 + Math.random() * 2000, // Random duration for varied fall speeds
                    easing: 'cubic-bezier(0.4, 0.0, 0.2, 1)' // Smooth easing function
                });

                fallAnimation.onfinish = () => confetti.remove(); // Remove confetti element after animation
            }

            // Create a burst of 50 confetti pieces with staggered delays.
            for (let i = 0; i < 50; i++) {
                setTimeout(createConfetti, i * 100); // Staggered creation
            }
        });

        // JavaScript for adding interactive feedback when the QR Code is clicked.
        document.querySelector('.qr-container').addEventListener('click', function() {
            // Add a subtle scale animation to the QR container.
            this.style.transform = 'scale(1.05)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);

            // Create and show a temporary tooltip message.
            const tooltip = document.createElement('div');
            tooltip.textContent = 'QR Code ready for check-in!';
            tooltip.style.position = 'absolute';
            tooltip.style.background = '#10b981';
            tooltip.style.color = 'white';
            tooltip.style.padding = '8px 12px';
            tooltip.style.borderRadius = '6px';
            tooltip.style.fontSize = '0.9rem';
            tooltip.style.top = '-40px'; // Position above the QR code
            tooltip.style.left = '50%';
            tooltip.style.transform = 'translateX(-50%)';
            tooltip.style.zIndex = '1001';
            tooltip.style.animation = 'fadeInUp 0.3s ease-out'; // Simple fade-in animation

            this.style.position = 'relative'; // Ensure tooltip is positioned relative to the container
            this.appendChild(tooltip);

            setTimeout(() => tooltip.remove(), 2000); // Remove tooltip after 2 seconds
        });

        // JavaScript for optimizing print output.
        window.addEventListener('beforeprint', function() {
            // Change body background to white before printing to save ink and ensure readability.
            document.body.style.background = 'white';
        });

        window.addEventListener('afterprint', function() {
            // Revert body background to the original gradient after printing is done.
            document.body.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        });
    </script>
</body>

</html>