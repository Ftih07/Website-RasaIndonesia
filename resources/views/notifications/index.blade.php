@extends('layouts.app')

@section('content')
<!-- Font Awesome -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

<!-- Navigation Bar -->
<nav class="navbar navbar-light bg-white shadow-sm border-0" style="border-bottom: 1px solid #f0f0f0;">
    <div class="container-fluid px-3 px-md-4">
        <div class="d-flex align-items-center">
            <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none p-0 me-3 d-flex align-items-center text-indonesian-brown hover-lift">
                <i class="fas fa-arrow-left me-2" style="font-size: 1.1rem;"></i>
                <span class="fw-medium">Back</span>
            </a>
            <div class="navbar-brand mb-0 d-flex align-items-center">
                <div class="notification-icon-nav me-2">
                    <i class="fas fa-bell text-white"></i>
                </div>
                <span class="text-indonesian-brown fw-bold">Notifications</span>
            </div>
        </div>
    </div>
</nav>

<div class="main-content">
    <!-- Hero Header Section -->
    <div class="hero-section">
        <div class="container-fluid px-3 px-md-4 py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="text-center mb-4">
                        <div class="hero-icon-wrapper mb-4">
                            <div class="hero-icon">
                                <i class="fas fa-bell"></i>
                                <div class="icon-glow"></div>
                            </div>
                        </div>
                        <h1 class="hero-title text-indonesian-brown mb-3">Your Notifications</h1>
                        <p class="hero-subtitle text-indonesian-text">Stay connected with everything that matters to you</p>
                        <div class="notification-count-badge">
                            {{ count($notifications) }} {{ count($notifications) === 1 ? 'notification' : 'notifications' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Content -->
    <div class="notifications-section">
        <div class="container-fluid px-3 px-md-4 pb-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    @forelse ($notifications as $notif)
                    <div class="notification-card {{ $notif->is_read ? 'read' : 'unread' }} mb-4">
                        <div class="notification-content">
                            <!-- Notification Indicator -->
                            <div class="notification-indicator">
                                @if(!$notif->is_read)
                                <div class="indicator-dot unread-dot"></div>
                                @else
                                <div class="indicator-dot read-dot"></div>
                                @endif
                            </div>

                            <!-- Notification Body -->
                            <div class="notification-body">
                                <div class="notification-header">
                                    <h3 class="notification-title {{ !$notif->is_read ? 'fw-bold text-indonesian-brown' : 'text-indonesian-text' }}">
                                        {{ $notif->title }}
                                    </h3>
                                </div>

                                <p class="notification-message">
                                    {{ $notif->message }}
                                </p>

                                <!-- Timestamp -->
                                <div class="notification-meta">
                                    <div class="timestamp-info">
                                        <i class="far fa-clock me-2"></i>
                                        <span>{{ $notif->created_at->translatedFormat('d F Y, H:i') }}</span>
                                        <span class="separator">•</span>
                                        <span class="time-ago">{{ $notif->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="notification-actions">
                                @if(!$notif->is_read)
                                <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-primary-indonesian">
                                        <i class="fas fa-envelope-open me-2"></i>
                                        Mark as Read
                                    </button>
                                </form>
                                @else
                                <span class="btn-action btn-read-status">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Read
                                </span>
                                @endif

                                <form method="POST" action="{{ route('notifications.destroy', $notif->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-danger-indonesian"
                                        onclick="return confirm('Are you sure you want to delete this notification?')">
                                        <i class="fas fa-trash-alt me-2"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-bell-slash"></i>
                        </div>
                        <h3 class="empty-state-title">No Notifications Yet</h3>
                        <p class="empty-state-description">
                            You're all caught up! New notifications will appear here when you receive them.
                        </p>
                        <div class="empty-state-decoration">
                            <div class="decoration-circle"></div>
                            <div class="decoration-circle"></div>
                            <div class="decoration-circle"></div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Color Palette - Inspired by Taste of Indonesia */
    :root {
        --indonesian-gold: #FF8000;
        --indonesian-brown: #fb923c;
        --indonesian-cream: #FDF6E3;
        --indonesian-warm-white: #FEFBF6;
        --indonesian-text: #6B5B47;
        --indonesian-light-brown: #fb923c;
        --indonesian-accent: #fb923c;
        --shadow-warm: rgba(139, 69, 19, 0.1);
        --shadow-soft: rgba(0, 0, 0, 0.05);
    }

    /* Base Styling */
    body {
        background: linear-gradient(135deg, var(--indonesian-warm-white) 0%, var(--indonesian-cream) 100%);
        color: var(--indonesian-text);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .text-indonesian-brown {
        color: var(--indonesian-brown) !important;
    }

    .text-indonesian-gold {
        color: var(--indonesian-gold) !important;
    }

    .text-indonesian-text {
        color: var(--indonesian-text) !important;
    }

    /* Navbar Styling */
    .navbar {
        backdrop-filter: blur(10px);
        background: rgba(254, 251, 246, 0.95) !important;
    }

    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
        transform: translateY(-1px);
        color: var(--indonesian-gold) !important;
    }

    .notification-icon-nav {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--indonesian-gold), var(--indonesian-accent));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px var(--shadow-warm);
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, var(--indonesian-warm-white) 0%, var(--indonesian-cream) 50%, rgba(212, 165, 116, 0.1) 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(212, 165, 116, 0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(139, 69, 19, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-icon-wrapper {
        position: relative;
    }

    .hero-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--indonesian-gold), var(--indonesian-accent));
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        box-shadow: 0 8px 32px var(--shadow-warm);
        position: relative;
        z-index: 2;
    }

    .icon-glow {
        position: absolute;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--indonesian-gold), var(--indonesian-accent));
        border-radius: 50%;
        opacity: 0.3;
        animation: pulse-glow 2s ease-in-out infinite alternate;
        z-index: 1;
    }

    @keyframes pulse-glow {
        0% {
            transform: scale(1);
            opacity: 0.3;
        }

        100% {
            transform: scale(1.2);
            opacity: 0.1;
        }
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        letter-spacing: -0.025em;
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: 1.125rem;
        font-weight: 400;
        opacity: 0.8;
        max-width: 500px;
        margin: 0 auto 2rem;
    }

    .notification-count-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--indonesian-gold), var(--indonesian-accent));
        color: white;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.875rem;
        box-shadow: 0 4px 20px var(--shadow-warm);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    /* Notifications Section */
    .notifications-section {
        position: relative;
        z-index: 2;
        margin-top: -2rem;
    }

    .notification-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 24px var(--shadow-soft);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .notification-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 48px rgba(0, 0, 0, 0.1);
    }

    .notification-card.unread {
        border-left: 4px solid var(--indonesian-gold);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(254, 251, 246, 0.9) 100%);
    }

    .notification-content {
        padding: 2rem;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 1.5rem;
        align-items: start;
    }

    /* Notification Indicator */
    .notification-indicator {
        padding-top: 0.25rem;
    }

    .indicator-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        position: relative;
    }

    .unread-dot {
        background: var(--indonesian-gold);
        box-shadow: 0 0 0 4px rgba(212, 165, 116, 0.2);
        animation: pulse-dot 2s ease-in-out infinite alternate;
    }

    .read-dot {
        background: #E5E7EB;
    }

    @keyframes pulse-dot {
        0% {
            box-shadow: 0 0 0 4px rgba(212, 165, 116, 0.2);
        }

        100% {
            box-shadow: 0 0 0 8px rgba(212, 165, 116, 0.1);
        }
    }

    /* Notification Body */
    .notification-body {
        min-width: 0;
    }

    .notification-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .notification-message {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        color: var(--indonesian-text);
    }

    .notification-meta {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        color: rgba(107, 91, 71, 0.7);
    }

    .timestamp-info {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .separator {
        opacity: 0.5;
    }

    .time-ago {
        background: rgba(212, 165, 116, 0.1);
        color: var(--indonesian-brown);
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-weight: 500;
    }

    /* Action Buttons */
    .notification-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn-action {
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 140px;
        text-transform: none;
        letter-spacing: 0.01em;
    }

    .btn-primary-indonesian {
        background: linear-gradient(135deg, var(--indonesian-gold), var(--indonesian-accent));
        color: white;
        box-shadow: 0 4px 16px rgba(212, 165, 116, 0.3);
    }

    .btn-primary-indonesian:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(212, 165, 116, 0.4);
        color: white;
    }

    .btn-danger-indonesian {
        background: white;
        color: #DC2626;
        border: 1.5px solid #FCA5A5;
    }

    .btn-danger-indonesian:hover {
        background: #FEF2F2;
        border-color: #DC2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(220, 38, 38, 0.1);
    }

    .btn-read-status {
        background: rgba(229, 231, 235, 0.8);
        color: rgba(107, 91, 71, 0.7);
        cursor: default;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        position: relative;
    }

    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(212, 165, 116, 0.1), rgba(139, 69, 19, 0.05));
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: rgba(212, 165, 116, 0.6);
        margin-bottom: 2rem;
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--indonesian-brown);
        margin-bottom: 1rem;
    }

    .empty-state-description {
        font-size: 1rem;
        color: var(--indonesian-text);
        opacity: 0.7;
        max-width: 400px;
        margin: 0 auto 2rem;
        line-height: 1.6;
    }

    .empty-state-decoration {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
    }

    .decoration-circle {
        width: 8px;
        height: 8px;
        background: var(--indonesian-gold);
        border-radius: 50%;
        opacity: 0.3;
        animation: float 3s ease-in-out infinite;
    }

    .decoration-circle:nth-child(2) {
        animation-delay: 0.5s;
    }

    .decoration-circle:nth-child(3) {
        animation-delay: 1s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .notification-content {
            grid-template-columns: auto 1fr;
            grid-template-rows: auto auto;
            gap: 1rem;
        }

        .notification-actions {
            grid-column: 1 / -1;
            flex-direction: row;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .btn-action {
            min-width: auto;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        .notification-card {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 576px) {
        .notification-content {
            padding: 1.5rem;
        }

        .notification-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-action {
            min-width: 100%;
            margin-bottom: 0.5rem;
        }

        .hero-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .notification-count-badge {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }

    /* Smooth page transitions */
    .main-content {
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Enhanced focus states for accessibility */
    .btn-action:focus,
    .notification-card:focus,
    .hover-lift:focus {
        outline: 3px solid rgba(212, 165, 116, 0.5);
        outline-offset: 2px;
    }
</style>

@endsection