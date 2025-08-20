{{-- resources\views\chat\index.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50">
    <div class="container-fluid px-4 py-6">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        {{-- Mobile Back Button (hanya tampil saat ada chat aktif) --}}
                        @if($selectedChat)
                        <button class="btn btn-outline-orange btn-sm me-2 d-md-none" onclick="showSidebar()">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        @endif

                        <div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-circle p-3 me-3 shadow-lg">
                            <i class="fas fa-comments text-white fs-4"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-0 d-none d-sm-block">Chat Messages</h2>
                            <h5 class="font-bold text-gray-800 mb-0 d-sm-none">Chat</h5>
                            <p class="text-muted mb-0 d-none d-sm-block">Connect with our culinary community</p>
                            <small class="text-muted">
                                🔔 Please tap the left sidebar button <strong>twice</strong> to open it properly
                            </small>
                        </div>
                    </div>
                    <div class="badge bg-gradient-to-r from-orange-400 to-amber-400 text-white px-3 py-2 rounded-pill shadow-sm d-none d-sm-inline-flex">
                        <i class="fas fa-users me-1"></i>
                        Online Now
                    </div>
                </div>
            </div>
        </div>

        {{-- Fixed Main Chat Container --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-2xl rounded-3xl overflow-hidden chat-container" style="height: 650px; background: linear-gradient(135deg, #fff5f5 0%, #fef3c7 100%);">
                    <div class="card-body p-0" style="height: 100%;">
                        <div class="row g-0" style="height: 100%;">
                            {{-- Enhanced Sidebar --}}
                            <div class="col-md-4 col-lg-3 sidebar-container {{ $selectedChat ? 'd-none d-md-block' : '' }}" style="height: 100%;" id="sidebarContainer">
                                <div class="h-100 border-end border-warning d-flex flex-column" style="background: linear-gradient(180deg, #f97316 0%, #f59e0b 100%);">
                                    {{-- Sidebar Header (Fixed) --}}
                                    <div class="p-4 border-bottom border-warning-light flex-shrink-0">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h5 class="text-white mb-0 fw-bold">
                                                    <i class="fas fa-utensils me-2"></i>
                                                    Conversations
                                                </h5>
                                                <small class="text-orange-100">Stay connected with taste</small>
                                            </div>
                                            {{-- Mobile Close Button --}}
                                            <button class="btn btn-sm text-white d-md-none" onclick="hideSidebar()" style="opacity: 0.8;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Sidebar Content (Scrollable) --}}
                                    <div class="flex-grow-1 position-relative" style="min-height: 0;">
                                        <div class="position-absolute w-100 h-100 sidebar-scroll" style="overflow-y: auto;">
                                            @livewire('chat-sidebar', ['selectedChatId' => $selectedChat?->id])
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Enhanced Chat Area --}}
                            <div class="col-md-8 col-lg-9 chat-area-container {{ !$selectedChat ? 'd-none d-md-block' : '' }}" style="height: 100%;" id="chatAreaContainer">
                                <div class="h-100 d-flex flex-column">
                                    @if($selectedChat)

                                    {{-- Chat Messages Area (Scrollable) --}}
                                    <div class="flex-grow-1 position-relative" style="min-height: 0;">
                                        <div class="position-absolute w-100 h-100">
                                            {{-- Livewire Chat Box dengan styling khusus --}}
                                            @livewire('chat-box', ['chatId' => $selectedChat->id], key('chat-'.$selectedChat->id))
                                        </div>
                                    </div>
                                    @else
                                    {{-- Empty State --}}
                                    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center p-5">
                                        <div class="mb-4">
                                            <div class="bg-gradient-to-br from-orange-200 to-amber-200 rounded-circle mx-auto mb-3" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-comments text-orange-600" style="font-size: 3rem;"></i>
                                            </div>
                                        </div>
                                        <h4 class="text-gray-700 mb-3 fw-bold d-none d-sm-block">Welcome to Taste of Indonesia Chat</h4>
                                        <h5 class="text-gray-700 mb-3 fw-bold d-sm-none">Welcome to Chat</h5>
                                        <p class="text-muted mb-4 max-w-md">
                                            Select a conversation from the sidebar to start chatting about delicious Indonesian cuisine and connect with food lovers.
                                        </p>
                                        <div class="d-flex gap-3 flex-wrap justify-content-center">
                                            <span class="badge bg-orange-100 text-orange-700 px-3 py-2 rounded-pill">
                                                <i class="fas fa-pepper-hot me-1"></i>
                                                <span class="d-none d-sm-inline">Spicy Conversations</span>
                                                <span class="d-sm-none">Spicy</span>
                                            </span>
                                            <span class="badge bg-amber-100 text-amber-700 px-3 py-2 rounded-pill">
                                                <i class="fas fa-heart me-1"></i>
                                                <span class="d-none d-sm-inline">Food Love</span>
                                                <span class="d-sm-none">Love</span>
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Overlay (untuk menutup sidebar) --}}
        <div class="mobile-overlay d-md-none" id="mobileOverlay" onclick="hideSidebar()"></div>

        {{-- Custom CSS untuk memastikan scrolling bekerja dan responsiveness --}}
        <style>
            /* Mobile Responsiveness */
            @media (max-width: 767.98px) {
                .chat-container {
                    height: calc(100vh - 180px) !important;
                }

                .sidebar-container {
                    position: absolute !important;
                    z-index: 1050 !important;
                    width: 85% !important;
                    max-width: 300px !important;
                    left: 0 !important;
                    top: 0 !important;
                    background: white !important;
                    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1) !important;
                }

                .sidebar-container.show {
                    display: block !important;
                }

                .chat-area-container {
                    width: 100% !important;
                }

                .chat-area-container.show {
                    display: block !important;
                }

                .mobile-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 1040;
                    display: none;
                }

                .mobile-overlay.show {
                    display: block;
                }

                /* Adjust padding for mobile */
                .container-fluid {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }
            }

            /* Custom scrollbar untuk sidebar */
            .sidebar-scroll::-webkit-scrollbar {
                width: 6px;
            }

            .sidebar-scroll::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 3px;
            }

            .sidebar-scroll::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 3px;
            }

            .sidebar-scroll::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.5);
            }

            /* Pastikan chat box menggunakan full height */
            .chat-box-container {
                height: 100% !important;
                display: flex !important;
                flex-direction: column !important;
            }

            .chat-messages-area {
                flex: 1 !important;
                overflow-y: auto !important;
                min-height: 0 !important;
            }

            .chat-input-area {
                flex-shrink: 0 !important;
            }

            /* Custom scrollbar untuk chat messages */
            .chat-messages-area::-webkit-scrollbar {
                width: 8px;
            }

            .chat-messages-area::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }

            .chat-messages-area::-webkit-scrollbar-thumb {
                background: #f97316;
                border-radius: 4px;
            }

            .chat-messages-area::-webkit-scrollbar-thumb:hover {
                background: #ea580c;
            }
        </style>
    </div>
</div>

{{-- JavaScript untuk Mobile Navigation --}}
<script>
    function showSidebar() {
        const sidebar = document.getElementById('sidebarContainer');
        const chatArea = document.getElementById('chatAreaContainer');
        const overlay = document.getElementById('mobileOverlay');

        if (window.innerWidth <= 767.98) {
            sidebar.classList.remove('d-none');
            sidebar.classList.add('show');
            chatArea.classList.add('d-none');
            overlay.classList.add('show');
        }
    }

    function hideSidebar() {
        const sidebar = document.getElementById('sidebarContainer');
        const chatArea = document.getElementById('chatAreaContainer');
        const overlay = document.getElementById('mobileOverlay');

        if (window.innerWidth <= 767.98) {
            sidebar.classList.add('d-none');
            sidebar.classList.remove('show');
            chatArea.classList.remove('d-none');
            overlay.classList.remove('show');
        }
    }

    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebarContainer');
        const chatArea = document.getElementById('chatAreaContainer');
        const overlay = document.getElementById('mobileOverlay');

        if (window.innerWidth > 767.98) {
            // Desktop view - reset classes
            sidebar.classList.remove('d-none', 'show');
            chatArea.classList.remove('d-none', 'show');
            overlay.classList.remove('show');

            // Apply original logic for desktop
            @if($selectedChat)
            sidebar.classList.remove('d-none');
            chatArea.classList.remove('d-none');
            @else
            chatArea.classList.add('d-none');
            chatArea.classList.add('d-md-block');
            @endif
        } else {
            // Mobile view - apply mobile logic
            @if($selectedChat)
            sidebar.classList.add('d-none');
            chatArea.classList.remove('d-none');
            @else
            sidebar.classList.remove('d-none');
            chatArea.classList.add('d-none');
            @endif
        }
    });

    // Handle chat selection on mobile (you might need to trigger this from your Livewire component)
    window.addEventListener('chat-selected', function() {
        if (window.innerWidth <= 767.98) {
            hideSidebar();
        }
    });
</script>

{{-- Custom Styles --}}
<style>
    .btn-outline-orange {
        color: #f97316;
        border-color: #f97316;
    }

    .btn-outline-orange:hover {
        background-color: #f97316;
        border-color: #f97316;
        color: white;
    }

    .border-warning-light {
        border-color: rgba(251, 191, 36, 0.3) !important;
    }

    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .max-w-md {
        max-width: 28rem;
    }
</style>
@endsection