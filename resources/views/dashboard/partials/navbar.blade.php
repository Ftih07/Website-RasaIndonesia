<!-- ✅ Enhanced Dashboard Navbar with Better Mobile/Tablet Support -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<nav class="dashboard-navbar mb-4">
    <div class="navbar-container bg-white rounded-3 shadow-sm border-0 p-3">
        <div class="row align-items-center">
            <!-- Navigation Tabs -->
            <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                <div class="nav-tabs-wrapper">
                    <ul class="nav nav-pills dashboard-nav-pills" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}"
                                role="tab">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->is('dashboard/business*') ? 'active' : '' }}"
                                href="{{ route('dashboard.business') }}"
                                role="tab">
                                <i class="fas fa-building me-2"></i>
                                <span>Business</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->is('dashboard/product*') ? 'active' : '' }}"
                                href="{{ route('dashboard.product') }}"
                                role="tab">
                                <i class="fas fa-utensils me-2"></i>
                                <span>Products</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->is('dashboard/orders*') ? 'active' : '' }}"
                                href="{{ route('dashboard.orders') }}"
                                role="tab">
                                <i class="fas fa-shopping-cart me-2"></i>
                                <span>Orders</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->is('dashboard/testimonial*') ? 'active' : '' }}"
                                href="{{ route('dashboard.testimonial') }}"
                                role="tab">
                                <i class="fas fa-star me-2"></i>
                                <span>Testimonials</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request()->is('chat/seller*') ? 'active' : '' }}"
                                href="{{ route('chat.seller') }}"
                                role="tab">
                                <i class="fas fa-comments me-2"></i>
                                <span>Chat</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="col-12 col-lg-4">
                <div class="action-buttons-wrapper">
                    <div class="d-flex align-items-center justify-content-lg-end gap-2">
                        {{-- ✅ View Store Link --}}
                        @php
                        $slug = auth()->user()->business->slug ?? null;
                        @endphp
                        @if($slug)
                        <a class="btn btn-outline-primary btn-sm d-flex align-items-center"
                            href="{{ url('business/' . $slug) }}"
                            target="_blank"
                            rel="noopener noreferrer">
                            <i class="fas fa-external-link-alt me-2"></i>
                            <span class="d-none d-sm-inline">View Store</span>
                            <span class="d-sm-none">Store</span>
                        </a>
                        @endif

                        <!-- Settings Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center"
                                type="button"
                                id="dashboardSettings"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-cog me-2"></i>
                                <span class="d-none d-md-inline">Settings</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="dashboardSettings">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-bell me-2"></i>Notifications</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="fas fa-tools me-2"></i>
                                        Business Actions
                                    </h6>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export Data</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <button class="dropdown-item text-danger"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteBusinessModal">
                                        <i class="fas fa-trash-alt me-2"></i>
                                        Delete Business
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- User Profile Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-gradient-orange btn-sm dropdown-toggle d-flex align-items-center"
                                type="button"
                                id="userProfile"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div class="user-avatar me-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=f97316&color=ffffff&size=24"
                                        alt="Profile"
                                        class="rounded-circle">
                                </div>
                                <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'User' }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userProfile">
                                <li>
                                    <div class="dropdown-item-text">
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=f97316&color=ffffff&size=40"
                                                alt="Profile"
                                                class="rounded-circle me-3">
                                            <div>
                                                <div class="fw-semibold">{{ auth()->user()->name ?? 'User' }}</div>
                                                <small class="text-muted">{{ auth()->user()->email ?? 'user@example.com' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>My Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-question-circle me-2"></i>Help & Support</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="#">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Delete Business Modal -->
<div class="modal fade" id="deleteBusinessModal" tabindex="-1" aria-labelledby="deleteBusinessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-danger fw-bold" id="deleteBusinessModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Delete Business
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger">
                    <i class="fas fa-warning me-2"></i>
                    <strong>Warning!</strong> This action cannot be undone.
                </div>
                <p class="text-muted">Are you sure you want to delete your business? This will permanently remove:</p>
                <ul class="text-muted">
                    <li>All your products and menu items</li>
                    <li>Customer reviews and testimonials</li>
                    <li>Order history and analytics</li>
                    <li>Business settings and configurations</li>
                </ul>
                <p class="fw-semibold text-dark">Type <code>DELETE</code> to confirm:</p>
                <input type="text" class="form-control" id="deleteConfirmation" placeholder="Type DELETE to confirm">
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form action="{{ route('dashboard.destroy') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                        <i class="fas fa-trash-alt me-2"></i>Delete Business
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Custom Styles for Mobile/Tablet Optimization -->
<style>
    /* Dashboard Navbar Styling */
    .dashboard-navbar {
        position: sticky;
        top: 10px;
        z-index: 1020;
    }

    .navbar-container {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95) !important;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Enhanced Nav Pills */
    .dashboard-nav-pills {
        --bs-nav-pills-border-radius: 8px;
        --bs-nav-pills-link-active-color: #ffffff;
        --bs-nav-pills-link-active-bg: linear-gradient(135deg, #f97316 0%, #eab308 100%);
    }

    .dashboard-nav-pills .nav-link {
        color: #6b7280;
        font-weight: 500;
        padding: 0.75rem 1rem;
        margin-right: 0.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .dashboard-nav-pills .nav-link:hover:not(.active):not(.disabled) {
        color: #f97316;
        background-color: rgba(249, 115, 22, 0.1);
        transform: translateY(-2px);
    }

    .dashboard-nav-pills .nav-link.active {
        background: linear-gradient(135deg, #f97316 0%, #eab308 100%);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
    }

    .dashboard-nav-pills .nav-link.disabled {
        color: #9ca3af;
        background-color: #f9fafb;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .dashboard-nav-pills .nav-link i {
        font-size: 0.875rem;
    }

    /* Gradient Button */
    .btn-gradient-orange {
        background: linear-gradient(135deg, #f97316 0%, #eab308 100%);
        border: none;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-gradient-orange:hover {
        background: linear-gradient(135deg, #ea580c 0%, #ca8a04 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        color: white;
    }

    /* User Avatar */
    .user-avatar img {
        width: 24px;
        height: 24px;
        object-fit: cover;
    }

    /* Dropdown Enhancements */
    .dropdown-menu {
        border: none;
        border-radius: 12px;
        padding: 0.5rem;
        min-width: 200px;
    }

    .dropdown-item {
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(249, 115, 22, 0.1);
        color: #f97316;
    }

    .dropdown-item i {
        width: 16px;
        text-align: center;
    }

    .dropdown-header {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
        padding: 0.5rem 0.75rem 0.25rem;
    }

    /* Modal Enhancements */
    .modal-content {
        border-radius: 16px;
    }

    .modal-header {
        padding: 1.5rem 1.5rem 0;
    }

    .modal-body {
        padding: 1rem 1.5rem;
    }

    .modal-footer {
        padding: 0 1.5rem 1.5rem;
    }

    /* Badge Styling */
    .badge.bg-secondary {
        background-color: #6b7280 !important;
        font-size: 0.625rem;
        padding: 0.25rem 0.5rem;
    }

    /* Enhanced Mobile/Tablet Responsive Design */

    /* Tablet Landscape (768px - 991px) */
    @media (max-width: 991.98px) and (min-width: 768px) {
        .dashboard-navbar {
            top: 15px;
        }

        .navbar-container {
            padding: 1.25rem !important;
        }

        .nav-tabs-wrapper {
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding-bottom: 0.25rem;
        }

        .nav-tabs-wrapper::-webkit-scrollbar {
            display: none;
        }

        .dashboard-nav-pills {
            flex-wrap: nowrap;
            min-width: max-content;
            gap: 0.25rem;
        }

        .dashboard-nav-pills .nav-link {
            margin-right: 0;
            white-space: nowrap;
            min-width: 120px;
            text-align: center;
            padding: 0.625rem 1rem;
        }

        .action-buttons-wrapper {
            margin-top: 1rem;
        }

        .action-buttons-wrapper .d-flex {
            justify-content: center;
        }
    }

    /* Tablet Portrait (576px - 767px) */
    @media (max-width: 767.98px) and (min-width: 576px) {
        .dashboard-navbar {
            top: 10px;
        }

        .navbar-container {
            padding: 1rem !important;
        }

        .nav-tabs-wrapper {
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding-bottom: 0.5rem;
        }

        .nav-tabs-wrapper::-webkit-scrollbar {
            height: 2px;
        }

        .nav-tabs-wrapper::-webkit-scrollbar-track {
            background: rgba(249, 115, 22, 0.1);
            border-radius: 1px;
        }

        .nav-tabs-wrapper::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #f97316, #eab308);
            border-radius: 1px;
        }

        .dashboard-nav-pills {
            flex-wrap: nowrap;
            min-width: max-content;
            gap: 0.375rem;
            padding-bottom: 0.25rem;
        }

        .dashboard-nav-pills .nav-link {
            margin-right: 0;
            white-space: nowrap;
            min-width: 110px;
            text-align: center;
            padding: 0.5rem 0.875rem;
            font-size: 0.875rem;
        }

        .dashboard-nav-pills .nav-link i {
            font-size: 0.8rem;
        }

        .action-buttons-wrapper {
            margin-top: 1rem;
        }

        .action-buttons-wrapper .d-flex {
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
    }

    /* Mobile (max-width: 575px) */
    @media (max-width: 575.98px) {
        .dashboard-navbar {
            top: 5px;
            margin-bottom: 1rem !important;
        }

        .navbar-container {
            padding: 0.75rem !important;
            margin: 0 0.5rem;
        }

        /* Enhanced horizontal scrolling for mobile */
        .nav-tabs-wrapper {
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(249, 115, 22, 0.5) rgba(249, 115, 22, 0.1);
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .nav-tabs-wrapper::-webkit-scrollbar {
            height: 3px;
        }

        .nav-tabs-wrapper::-webkit-scrollbar-track {
            background: rgba(249, 115, 22, 0.1);
            border-radius: 2px;
        }

        .nav-tabs-wrapper::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #f97316, #eab308);
            border-radius: 2px;
        }

        .dashboard-nav-pills {
            flex-wrap: nowrap;
            min-width: max-content;
            gap: 0.5rem;
            padding-bottom: 0.25rem;
        }

        .dashboard-nav-pills .nav-link {
            margin-right: 0;
            white-space: nowrap;
            min-width: 100px;
            text-align: center;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        .dashboard-nav-pills .nav-link i {
            font-size: 0.75rem;
            margin-right: 0.25rem !important;
        }

        .dashboard-nav-pills .nav-link span {
            font-size: 0.75rem;
        }

        /* Improved action buttons for mobile */
        .action-buttons-wrapper {
            margin-top: 0.75rem;
        }

        .action-buttons-wrapper .d-flex {
            justify-content: space-between;
            gap: 0.5rem !important;
        }

        .btn-sm {
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
            flex: 1;
            max-width: calc(50% - 0.25rem);
        }

        .btn-sm i {
            font-size: 0.7rem;
        }

        /* Better dropdown positioning on mobile */
        .dropdown-menu {
            min-width: 160px;
            max-width: 90vw;
            font-size: 0.875rem;
        }

        .dropdown-item {
            padding: 0.5rem 0.75rem;
        }

        .dropdown-item i {
            width: 14px;
            font-size: 0.8rem;
        }

        /* User profile text handling */
        .user-avatar img {
            width: 22px;
            height: 22px;
        }
    }

    /* Extra small devices (max-width: 375px) */
    @media (max-width: 375px) {
        .navbar-container {
            padding: 0.5rem !important;
            margin: 0 0.25rem;
        }

        .dashboard-nav-pills .nav-link {
            min-width: 90px;
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
        }

        .dashboard-nav-pills .nav-link i {
            font-size: 0.7rem;
        }

        .dashboard-nav-pills .nav-link span {
            font-size: 0.7rem;
        }

        .btn-sm {
            padding: 0.35rem 0.5rem;
            font-size: 0.7rem;
        }
    }

    /* Animation for active state */
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .dashboard-nav-pills .nav-link.active::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #f97316 0%, #eab308 100%);
        z-index: -1;
        border-radius: 8px;
    }

    /* Loading state */
    .nav-link.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .nav-link.loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        top: 50%;
        right: 8px;
        transform: translateY(-50%);
    }

    @keyframes spin {
        0% {
            transform: translateY(-50%) rotate(0deg);
        }

        100% {
            transform: translateY(-50%) rotate(360deg);
        }
    }

    /* Smooth scrolling enhancement for nav tabs */
    .nav-tabs-wrapper {
        scroll-behavior: smooth;
    }

    /* Touch-friendly improvements */
    @media (hover: none) and (pointer: coarse) {
        .dashboard-nav-pills .nav-link {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-sm {
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-item {
            min-height: 40px;
            display: flex;
            align-items: center;
        }
    }

    /* Modal responsive improvements */
    @media (max-width: 575.98px) {
        .modal-dialog {
            margin: 1rem 0.5rem;
        }

        .modal-content {
            border-radius: 12px;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>

<!-- Enhanced JavaScript for Navbar (Preserved Original Functionality) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete confirmation functionality (preserved)
        const deleteInput = document.getElementById('deleteConfirmation');
        const deleteBtn = document.getElementById('confirmDeleteBtn');

        if (deleteInput && deleteBtn) {
            deleteInput.addEventListener('input', function() {
                deleteBtn.disabled = this.value.trim().toUpperCase() !== 'DELETE';
            });
        }

        // Add loading state to nav links (preserved)
        document.querySelectorAll('.dashboard-nav-pills .nav-link:not(.disabled)').forEach(link => {
            link.addEventListener('click', function(e) {
                // Don't add loading to current page
                if (!this.classList.contains('active')) {
                    this.classList.add('loading');
                    // Remove loading state after navigation or timeout
                    setTimeout(() => {
                        this.classList.remove('loading');
                    }, 3000);
                }
            });
        });

        // Enhanced dropdown behavior (preserved)
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const dropdown = this.nextElementSibling;
                if (dropdown) {
                    dropdown.style.animationName = 'fadeInUp';
                    dropdown.style.animationDuration = '0.3s';
                    dropdown.style.animationFillMode = 'both';
                }
            });
        });

        // Auto-hide navbar on scroll down, show on scroll up (preserved)
        let lastScrollTop = 0;
        const navbar = document.querySelector('.dashboard-navbar');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                navbar.style.transform = 'translateY(-100%)';
                navbar.style.transition = 'transform 0.3s ease-in-out';
            } else {
                // Scrolling up
                navbar.style.transform = 'translateY(0)';
            }

            lastScrollTop = scrollTop;
        });

        // Enhanced mobile navigation scrolling
        const navWrapper = document.querySelector('.nav-tabs-wrapper');
        const activeLink = document.querySelector('.dashboard-nav-pills .nav-link.active');

        if (navWrapper && activeLink && window.innerWidth <= 991) {
            // Scroll active tab into view on mobile/tablet
            setTimeout(() => {
                activeLink.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }, 100);
        }

        // Touch/swipe support for navigation tabs on mobile
        if (navWrapper && 'ontouchstart' in window) {
            let startX = 0;
            let scrollLeft = 0;
            let isScrolling = false;

            navWrapper.addEventListener('touchstart', (e) => {
                startX = e.touches[0].pageX - navWrapper.offsetLeft;
                scrollLeft = navWrapper.scrollLeft;
                isScrolling = false;
            });

            navWrapper.addEventListener('touchmove', (e) => {
                if (!isScrolling) {
                    isScrolling = true;
                }
                const x = e.touches[0].pageX - navWrapper.offsetLeft;
                const walk = (x - startX) * 1.5;
                navWrapper.scrollLeft = scrollLeft - walk;
            });

            // Prevent click events when scrolling
            navWrapper.addEventListener('touchend', (e) => {
                if (isScrolling) {
                    e.preventDefault();
                    setTimeout(() => {
                        isScrolling = false;
                    }, 100);
                }
            });
        }
    });

    // Fadeup animation keyframes (preserved)
    const style = document.createElement('style');
    style.textContent = `
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translate3d(0, 10px, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}
`;
    document.head.appendChild(style);
</script>