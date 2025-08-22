@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<div class="container mx-auto px-4 py-8">
    <!-- Main Status Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Header with animated gradient -->
            <div class="bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 px-8 py-12 text-center relative overflow-hidden">

                <!-- Animated clock icon -->
                <div class="relative z-10 mb-6">
                    <div class="inline-block p-4 bg-white bg-opacity-20 rounded-full animate-pulse">
                        <svg class="w-16 h-16 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-white mb-3 relative z-10">
                    Application Under Review
                </h1>
                <p class="text-xl text-orange-100 relative z-10 max-w-2xl mx-auto">
                    Your submission is currently being processed by our admin team
                </p>
            </div>

            <!-- Status Content -->
            <div class="p-8">
                <!-- Status Timeline -->
                <div class="mb-12">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Review Process</h2>

                    <div class="relative">
                        <!-- Timeline line -->
                        <div class="absolute left-8 top-0 h-full w-0.5 bg-gradient-to-b from-green-400 via-orange-400 to-gray-300"></div>

                        <!-- Timeline items -->
                        <div class="relative space-y-8">
                            <!-- Step 1: Submitted -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-16 h-16 bg-green-500 rounded-full flex items-center justify-center relative z-10">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-6 bg-green-50 rounded-lg p-4 flex-1 border border-green-200">
                                    <h3 class="font-semibold text-green-800">Application Submitted</h3>
                                    <p class="text-green-600 text-sm mt-1">Your application has been successfully received</p>
                                    <span class="text-xs text-green-500 font-medium">✓ Completed</span>
                                </div>
                            </div>

                            <!-- Step 2: Under Review -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center relative z-10 animate-pulse">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-6 bg-orange-50 rounded-lg p-4 flex-1 border border-orange-200">
                                    <h3 class="font-semibold text-orange-800">Currently Under Review</h3>
                                    <p class="text-orange-600 text-sm mt-1">Our admin team is carefully reviewing your submission</p>
                                    <span class="text-xs text-orange-500 font-medium">⏳ In Progress</span>
                                </div>
                            </div>

                            <!-- Step 3: Decision -->
                            <div class="flex items-center opacity-50">
                                <div class="flex-shrink-0 w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center relative z-10">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-6 bg-gray-50 rounded-lg p-4 flex-1 border border-gray-200">
                                    <h3 class="font-semibold text-gray-600">Approval Notification</h3>
                                    <p class="text-gray-500 text-sm mt-1">You'll receive a confirmation email once the review is complete</p>
                                    <span class="text-xs text-gray-400 font-medium">○ Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Information Cards -->
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <!-- What's Next Card -->
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-blue-800 mb-2">What Happens Next?</h3>
                                <ul class="text-sm text-blue-700 space-y-2">
                                    <li class="flex items-start">
                                        <span class="text-blue-500 mr-2">•</span>
                                        <span>Admin will review your application details</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-blue-500 mr-2">•</span>
                                        <span>You'll receive an email notification with the decision</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-blue-500 mr-2">•</span>
                                        <span>If approved, you can start using all features immediately</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Estimated Time Card -->
                    <div class="bg-purple-50 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-start">
                            <div class="bg-purple-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-purple-800 mb-2">Estimated Review Time</h3>
                                <div class="text-sm text-purple-700 space-y-2">
                                    <div class="flex items-center">
                                        <span class="font-medium text-purple-800">Standard Review:</span>
                                        <span class="ml-2 bg-purple-100 px-2 py-1 rounded text-xs">1-3 Business Days</span>
                                    </div>
                                    <p class="text-purple-600 text-xs mt-2">
                                        ⏰ Review times may vary during peak periods
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Support Section -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 text-center border border-gray-200">
                    <div class="max-w-2xl mx-auto">
                        <h3 class="font-semibold text-gray-800 mb-3 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Need Help?
                        </h3>
                        <p class="text-gray-600 mb-4">
                            If you have any questions about your application or need to update your information,
                            our support team is here to help.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="mailto:support@tasteofindonesia.com"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Contact Support
                            </a>
                            <a href="#"
                                class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                View FAQ
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Auto-refresh Notice -->
                <div class="mt-8 text-center">
                    <div class="inline-flex items-center text-sm text-gray-500 bg-gray-100 rounded-full px-4 py-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                        This page will automatically refresh every 5 minutes to show status updates
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auto-refresh script -->
<script>
    // Auto-refresh every 5 minutes (300,000 milliseconds)
    setTimeout(function() {
        location.reload();
    }, 300000);

    // Add smooth scroll animation for any anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
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

    // Add hover effects to cards
    document.querySelectorAll('.bg-blue-50, .bg-purple-50').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
</script>

<style>
    /* Custom animations */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    /* Pulse animation for the timeline */
    @keyframes pulse-ring {
        0% {
            transform: scale(0.8);
            opacity: 1;
        }

        100% {
            transform: scale(2.4);
            opacity: 0;
        }
    }

    .pulse-ring::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        border: 2px solid #f97316;
        border-radius: 50%;
        animation: pulse-ring 2s infinite;
    }
</style>
@endsection