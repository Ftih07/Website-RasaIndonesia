@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="error-container">
    <!-- Background animated elements -->
    <div class="bg-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <!-- Main content -->
    <div class="error-content">
        <div class="error-animation">
            <div class="glitch-text" data-text="404">503</div>
        </div>

        <div class="error-message">
            <h2 class="error-title">We're Under Maintenance</h2>
            <p class="error-description">
                Our website is currently undergoing scheduled maintenance to improve your experience.
                Please check back again shortly. We appreciate your patience!
            </p>
        </div>

    </div>
</div>

<style>
    /* Reset dan base styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .error-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #000 0%, #212529 100%);
        position: relative;
        overflow: hidden;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Background animated elements */
    .bg-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .floating-element {
        position: absolute;
        width: 20px;
        height: 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .floating-element:nth-child(1) {
        top: 10%;
        left: 10%;
        animation-delay: 0s;
        animation-duration: 8s;
    }

    .floating-element:nth-child(2) {
        top: 20%;
        right: 20%;
        animation-delay: 2s;
        animation-duration: 6s;
    }

    .floating-element:nth-child(3) {
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
        animation-duration: 10s;
    }

    .floating-element:nth-child(4) {
        bottom: 10%;
        right: 10%;
        animation-delay: 1s;
        animation-duration: 7s;
    }

    .floating-element:nth-child(5) {
        top: 50%;
        left: 50%;
        animation-delay: 3s;
        animation-duration: 9s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 0.7;
        }

        50% {
            transform: translateY(-20px) rotate(180deg);
            opacity: 1;
        }
    }

    /* Main content */
    .error-content {
        text-align: center;
        position: relative;
        z-index: 2;
        max-width: 600px;
        width: 100%;
    }

    /* Glitch effect for 404 */
    .error-animation {
        margin-bottom: 2rem;
    }

    .glitch-text {
        font-size: 8rem;
        font-weight: 900;
        color: #fff;
        position: relative;
        text-shadow: 0.05em 0 0 #00fffc, -0.03em -0.04em 0 #fc00ff,
            0.025em 0.04em 0 #fffc00;
        animation: glitch 725ms infinite;
    }

    .glitch-text::before,
    .glitch-text::after {
        content: attr(data-text);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .glitch-text::before {
        animation: glitch-top 1s linear infinite;
        clip-path: polygon(0 0, 100% 0, 100% 33%, 0 33%);
        -webkit-clip-path: polygon(0 0, 100% 0, 100% 33%, 0 33%);
    }

    .glitch-text::after {
        animation: glitch-bottom 1.5s linear infinite;
        clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
        -webkit-clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
    }

    @keyframes glitch {

        2%,
        64% {
            transform: translate(2px, 0) skew(0deg);
        }

        4%,
        60% {
            transform: translate(-2px, 0) skew(0deg);
        }

        62% {
            transform: translate(0, 0) skew(5deg);
        }
    }

    @keyframes glitch-top {

        2%,
        64% {
            transform: translate(2px, -2px);
        }

        4%,
        60% {
            transform: translate(-2px, 2px);
        }

        62% {
            transform: translate(13px, -1px) skew(-13deg);
        }
    }

    @keyframes glitch-bottom {

        2%,
        64% {
            transform: translate(-2px, 0);
        }

        4%,
        60% {
            transform: translate(-2px, 0);
        }

        62% {
            transform: translate(-22px, 5px) skew(21deg);
        }
    }

    /* Error message */
    .error-message {
        margin-bottom: 3rem;
        color: #fff;
    }

    .error-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .error-description {
        font-size: 1.2rem;
        line-height: 1.6;
        opacity: 0.9;
        margin-bottom: 0;
    }

    /* Buttons */
    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

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

    .btn-primary {
        background: linear-gradient(45deg, #ecad00, #ffc107);
        color: white;
        box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(255, 107, 107, 0.4);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
    }

    .btn-icon {
        width: 20px;
        height: 20px;
        stroke-width: 2;
    }

    /* Search suggestion */
    .search-suggestion {
        color: #fff;
        opacity: 0.9;
    }

    .search-suggestion p {
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .search-box {
        display: flex;
        max-width: 400px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50px;
        padding: 0.5rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .search-box input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 0.75rem 1.5rem;
        color: #fff;
        font-size: 1rem;
        outline: none;
    }

    .search-box input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .search-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    .search-btn svg {
        width: 20px;
        height: 20px;
        stroke: white;
        stroke-width: 2;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .error-container {
            padding: 15px;
        }

        .glitch-text {
            font-size: 5rem;
        }

        .error-title {
            font-size: 2rem;
        }

        .error-description {
            font-size: 1.1rem;
        }

        .error-actions {
            flex-direction: column;
            align-items: center;
        }

        .btn {
            width: 100%;
            max-width: 300px;
            justify-content: center;
        }

        .search-box {
            max-width: 300px;
        }
    }

    @media (max-width: 480px) {
        .glitch-text {
            font-size: 4rem;
        }

        .error-title {
            font-size: 1.8rem;
        }

        .error-description {
            font-size: 1rem;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }
    }



    /* Reduced motion for accessibility */
    @media (prefers-reduced-motion: reduce) {

        .floating-element,
        .glitch-text,
        .glitch-text::before,
        .glitch-text::after {
            animation: none;
        }

        .btn {
            transition: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.querySelector('.search-btn');

        // Handle search functionality
        function handleSearch() {
            const query = searchInput.value.trim();
            if (query) {
                // Redirect to search page or handle search logic
                window.location.href = `{{ url('/search') }}?q=${encodeURIComponent(query)}`;
            }
        }

        searchBtn.addEventListener('click', handleSearch);

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                handleSearch();
            }
        });

        // Add some interactive effects
        const errorContent = document.querySelector('.error-content');

        // Parallax effect for mouse movement
        document.addEventListener('mousemove', function(e) {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;

            const floatingElements = document.querySelectorAll('.floating-element');
            floatingElements.forEach((element, index) => {
                const speed = (index + 1) * 0.5;
                const x = (mouseX - 0.5) * speed;
                const y = (mouseY - 0.5) * speed;

                element.style.transform = `translate(${x}px, ${y}px)`;
            });
        });
    });
</script>
@endsection