@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-block p-4 bg-gradient-to-r from-orange-100 to-orange-200 rounded-full mb-6">
                <svg class="w-16 h-16 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Activate <span class="text-orange-600">Orders Feature</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Transform your business with our comprehensive order management system.
                Start accepting orders directly from customers and streamline your operations.
            </p>
        </div>

        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-2 gap-12 mb-12">
            <!-- Features Section -->
            <div class="space-y-6">
                <h2 class="text-3xl font-semibold text-gray-800 mb-8">
                    What You'll Get
                </h2>

                <!-- Feature Cards -->
                <div class="space-y-4">
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <div class="flex items-start">
                            <div class="bg-green-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Direct Order Management</h3>
                                <p class="text-gray-600 text-sm">Accept and manage customer orders directly through your dashboard with real-time notifications.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <div class="flex items-start">
                            <div class="bg-blue-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Flexible Pricing & Shipping</h3>
                                <p class="text-gray-600 text-sm">Set custom pricing, manage inventory, and configure shipping options that work for your business.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <div class="flex items-start">
                            <div class="bg-purple-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Analytics & Reports</h3>
                                <p class="text-gray-600 text-sm">Track your sales performance, customer behavior, and business growth with detailed analytics.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                        <div class="flex items-start">
                            <div class="bg-orange-100 p-3 rounded-full mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a3 3 0 01-3-3v-1M3 4a2 2 0 012-2h10a2 2 0 012 2v6a2 2 0 01-2 2H9l-4 4V4z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Customer Communication</h3>
                                <p class="text-gray-600 text-sm">Stay connected with customers through integrated messaging and order status updates.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Request Form Section -->
            <div class="lg:sticky lg:top-8">
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-8 border border-orange-200 shadow-xl">
                    <div class="text-center mb-8">
                        <div class="inline-block p-3 bg-orange-200 rounded-full mb-4">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Ready to Get Started?</h2>
                        <p class="text-gray-600">Submit your request and we'll activate your orders feature within 24-48 hours.</p>
                    </div>

                    <!-- Benefits Summary -->
                    <div class="bg-white rounded-xl p-6 mb-6 border border-orange-100">
                        <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            Activation Includes:
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center">
                                <span class="text-green-500 mr-2">✓</span>
                                Complete order management dashboard
                            </li>
                            <li class="flex items-center">
                                <span class="text-green-500 mr-2">✓</span>
                                Customer ordering interface
                            </li>
                            <li class="flex items-center">
                                <span class="text-green-500 mr-2">✓</span>
                                Automated email notifications
                            </li>
                            <li class="flex items-center">
                                <span class="text-green-500 mr-2">✓</span>
                                Payment processing integration
                            </li>
                            <li class="flex items-center">
                                <span class="text-green-500 mr-2">✓</span>
                                24/7 technical support
                            </li>
                        </ul>
                    </div>

                    <!-- Request Form -->
                    <form action="{{ route('dashboard.orders.request') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Terms Agreement -->
                        <div class="bg-white rounded-lg p-4 border border-orange-100">
                            <div class="flex items-start">
                                <input type="checkbox" id="terms_agreement" name="terms_agreement" required
                                    class="mt-1 mr-3 w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                <label for="terms_agreement" class="text-sm text-gray-700 leading-relaxed">
                                    I agree to the <a href="#" class="text-orange-600 hover:text-orange-700 font-medium">Terms of Service</a>
                                    and understand that the orders feature will be subject to our
                                    <a href="#" class="text-orange-600 hover:text-orange-700 font-medium">pricing policy</a>.
                                </label>
                            </div>
                        </div>

                        <!-- Business Info Notice -->
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-blue-700">
                                    <p class="font-medium mb-1">Before Activation:</p>
                                    <p>Make sure your business profile is complete with accurate contact information, business hours, and menu items.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-4 px-6 rounded-xl hover:from-orange-600 hover:to-orange-700 transform hover:scale-105 transition duration-300 shadow-lg hover:shadow-xl">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Request Orders Activation
                            </span>
                        </button>

                        <!-- Processing Time -->
                        <div class="text-center text-sm text-gray-500">
                            <div class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Processing time: 24-48 hours
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-12">
            <h2 class="text-3xl font-semibold text-gray-800 text-center mb-8">
                Frequently Asked Questions
            </h2>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <span class="text-orange-500 mr-2">Q:</span>
                            How long does activation take?
                        </h3>
                        <p class="text-gray-600 text-sm ml-6">
                            Most activations are completed within 24-48 hours. You'll receive an email confirmation once your orders feature is ready.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <span class="text-orange-500 mr-2">Q:</span>
                            Are there any setup fees?
                        </h3>
                        <p class="text-gray-600 text-sm ml-6">
                            The basic orders feature activation is free. Transaction fees may apply based on your chosen payment processing options.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <span class="text-orange-500 mr-2">Q:</span>
                            Can I customize my menu?
                        </h3>
                        <p class="text-gray-600 text-sm ml-6">
                            Yes! You'll have full control over your menu items, pricing, categories, and availability through your dashboard.
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <span class="text-orange-500 mr-2">Q:</span>
                            What payment methods are supported?
                        </h3>
                        <p class="text-gray-600 text-sm ml-6">
                            We support major credit cards, digital wallets, and popular Indonesian payment methods like OVO, GoPay, and Dana.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <span class="text-orange-500 mr-2">Q:</span>
                            Can I manage delivery areas?
                        </h3>
                        <p class="text-gray-600 text-sm ml-6">
                            Absolutely! Set your delivery zones, shipping rates, and delivery times to match your business operations.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <span class="text-orange-500 mr-2">Q:</span>
                            Is technical support included?
                        </h3>
                        <p class="text-gray-600 text-sm ml-6">
                            Yes! Our technical support team is available 24/7 to help you with any questions or issues you may encounter.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="text-center bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-8 border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">
                Still Have Questions?
            </h3>
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                Our support team is ready to help you understand how the orders feature can benefit your business.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:support@tasteofindonesia.com"
                    class="inline-flex items-center px-6 py-3 bg-orange-500 text-white font-medium rounded-lg hover:bg-orange-600 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email Support
                </a>
                <a href="#"
                    class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Live Chat
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Add form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const checkbox = document.getElementById('terms_agreement');
        if (!checkbox.checked) {
            e.preventDefault();
            alert('Please accept the terms and conditions to proceed.');
            checkbox.focus();
            return false;
        }

        // Add loading state to button
        const button = this.querySelector('button[type="submit"]');
        button.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing Request...
            </span>
        `;
        button.disabled = true;
    });

    // Add smooth scroll for anchor links
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

    // Add hover animations to feature cards
    document.querySelectorAll('.hover\\:-translate-y-1').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)';
        });
    });
</script>
@endsection