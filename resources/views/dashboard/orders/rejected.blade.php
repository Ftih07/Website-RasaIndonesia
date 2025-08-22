@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Main Status Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Header with gradient background -->
            <div class="bg-gradient-to-r from-red-400 via-red-500 to-red-600 px-8 py-12 text-center relative overflow-hidden">
                
                <!-- Alert icon -->
                <div class="relative z-10 mb-6">
                    <div class="inline-block p-4 bg-white bg-opacity-20 rounded-full">
                        <svg class="w-16 h-16 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3 relative z-10">
                    Application Not Approved
                </h1>
                <p class="text-xl text-red-100 relative z-10 max-w-2xl mx-auto">
                    We're sorry, but your orders feature activation request has been declined
                </p>
            </div>

            <!-- Content Section -->
            <div class="p-8">
                <!-- Status Message -->
                <div class="bg-red-50 border-l-4 border-red-400 p-6 mb-8 rounded-r-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-lg font-semibold text-red-800 mb-2">Request Status: Declined</h2>
                            <p class="text-red-700 leading-relaxed">
                                Your application for the orders feature activation has been reviewed by our admin team and unfortunately cannot be approved at this time. This decision may be due to various factors including incomplete business information, policy requirements, or other technical considerations.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Next Steps Section -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- What to do next -->
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-blue-800 mb-3">What You Can Do Next</h3>
                                <ul class="text-sm text-blue-700 space-y-2">
                                    <li class="flex items-start">
                                        <span class="text-blue-500 mr-2 mt-1">•</span>
                                        <span>Contact our admin team for specific feedback</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-blue-500 mr-2 mt-1">•</span>
                                        <span>Review and update your business profile</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-blue-500 mr-2 mt-1">•</span>
                                        <span>Ensure all required information is complete</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-blue-500 mr-2 mt-1">•</span>
                                        <span>Submit a new application after addressing concerns</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Common reasons -->
                    <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
                        <div class="flex items-start">
                            <div class="bg-yellow-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-yellow-800 mb-3">Common Reasons for Decline</h3>
                                <ul class="text-sm text-yellow-700 space-y-2">
                                    <li class="flex items-start">
                                        <span class="text-yellow-500 mr-2 mt-1">•</span>
                                        <span>Incomplete business profile information</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-yellow-500 mr-2 mt-1">•</span>
                                        <span>Missing required documentation</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-yellow-500 mr-2 mt-1">•</span>
                                        <span>Business category not currently supported</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-yellow-500 mr-2 mt-1">•</span>
                                        <span>Policy compliance requirements not met</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 text-center mb-6">
                        Ready to Try Again?
                    </h3>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="mailto:admin@tasteofindonesia.com?subject=Orders Feature - Request Feedback" 
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-lg shadow-md hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact Admin
                        </a>
                        
                        <a href="{{ route('dashboard.orders.request') }}" 
                           class="inline-flex items-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-lg border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Submit New Application
                        </a>
                    </div>
                </div>

                <!-- Support Resources -->
                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Help Center -->
                    <div class="bg-purple-50 rounded-xl p-6 border border-purple-200 text-center hover:shadow-lg transition duration-300">
                        <div class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-purple-800 mb-2">Help Center</h4>
                        <p class="text-sm text-purple-600 mb-4">Find detailed guides and requirements</p>
                        <a href="#" class="text-purple-600 hover:text-purple-700 font-medium text-sm">Visit Help Center →</a>
                    </div>

                    <!-- Live Chat -->
                    <div class="bg-green-50 rounded-xl p-6 border border-green-200 text-center hover:shadow-lg transition duration-300">
                        <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-green-800 mb-2">Live Chat</h4>
                        <p class="text-sm text-green-600 mb-4">Get instant help from our support team</p>
                        <a href="#" class="text-green-600 hover:text-green-700 font-medium text-sm">Start Chat →</a>
                    </div>

                    <!-- Phone Support -->
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200 text-center hover:shadow-lg transition duration-300">
                        <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-blue-800 mb-2">Phone Support</h4>
                        <p class="text-sm text-blue-600 mb-4">Speak directly with our experts</p>
                        <a href="tel:+62-xxx-xxx-xxxx" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Call Now →</a>
                    </div>
                </div>

                <!-- Encouragement Message -->
                <div class="mt-8 text-center bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl p-8 border border-orange-200">
                    <div class="max-w-2xl mx-auto">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Don't Give Up!</h3>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Many successful businesses have gone through the application process multiple times before approval. 
                            Each application is a step closer to growing your business with our orders feature.
                        </p>
                        <div class="flex items-center justify-center text-orange-600 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            We're here to help you succeed
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add interactive checkbox functionality
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = this.closest('label');
            const span = label.querySelector('span');
            
            if (this.checked) {
                span.style.textDecoration = 'line-through';
                span.style.color = '#10b981';
                label.style.backgroundColor = '#f0fdf4';
            } else {
                span.style.textDecoration = 'none';
                span.style.color = '#374151';
                label.style.backgroundColor = 'transparent';
            }
        });
    });

    // Add smooth animations for interactive elements
    document.querySelectorAll('.hover\\:shadow-lg').forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease, box-shadow 0.2s ease';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add click tracking for action buttons
    document.querySelectorAll('a[href*="mailto"], a[href*="tel"]').forEach(link => {
        link.addEventListener('click', function() {
            console.log('Contact initiated:', this.href);
        });
    });
</script>

<style>
    /* Custom hover animations */
    .hover\:scale-105:hover {
        transform: scale(1.05);
    }
    
    /* Smooth transitions for all interactive elements */
    * {
        transition: all 0.2s ease;
    }
    
    /* Custom focus styles */
    input[type="checkbox"]:focus {
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
</style>
@endsection