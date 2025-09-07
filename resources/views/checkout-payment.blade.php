@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #FFF5E6 0%, #FFF8F0 100%);">
    <div class="container-fluid py-5">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <div class="d-inline-block position-relative">
                <h1 class="display-4 fw-bold text-dark mb-2" style="font-family: 'Playfair Display', serif;">Secure Payment</h1>
                <div class="position-absolute top-100 start-50 translate-middle-x" style="width: 100px; height: 4px; background: linear-gradient(90deg, #FF6B35, #F7931E); border-radius: 2px;"></div>
            </div>
            <p class="text-muted mt-4">Complete your payment to enjoy authentic Indonesian cuisine</p>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <i class="fas fa-shield-alt text-success me-2"></i>
                <small class="text-muted">Secured by <strong>Stripe</strong> • SSL Encrypted</small>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="row g-0 shadow-lg" style="border-radius: 20px; overflow: hidden; background: white;">
                    <!-- Order Summary Section -->
                    <div class="col-lg-5">
                        <div class="h-100 p-4 p-lg-5" style="background: linear-gradient(135deg, #FFF8F5 0%, #FFF5E6 100%); border-right: 1px solid #FFE4D6;">
                            <!-- Header -->
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #FF6B35, #F7931E);">
                                    <i class="fas fa-receipt text-white fs-5"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-bold text-dark">Order Summary</h4>
                                    <small class="text-muted">Review your delicious order</small>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="mb-4">
                                @foreach($order->items as $item)
                                <div class="d-flex justify-content-between align-items-start mb-3 p-3 rounded-3" style="background: rgba(255, 235, 214, 0.3);">
                                    <div class="flex-grow-1 me-3">
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                                <span class="fw-bold small" style="color: #FF6B35;">{{ $item->quantity }}</span>
                                            </div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $item->product->name }}</h6>
                                        </div>
                                        <div class="ms-4">
                                            <small class="text-muted">{{ $item->quantity }} × A${{ number_format($item->unit_price, 2) }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold" style="color: #FF6B35;">A${{ number_format($item->total_price, 2) }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Price Breakdown -->
                            <div class="border-top pt-3" style="border-color: #FFE4D6 !important;">
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted">
                                        <i class="fas fa-calculator me-2"></i>Subtotal
                                    </span>
                                    <span class="fw-semibold">A${{ number_format($order->items->sum('total_price'), 2) }}</span>
                                </div>

                                {{-- ✅ tampilkan shipping cost (dari kolom shipping_cost) --}}
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted">
                                        <i class="fas fa-shipping-fast me-2"></i>Shipping Cost
                                    </span>
                                    <span class="fw-semibold">
                                        A${{ number_format($order->shipping_cost, 2) }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted">
                                        <i class="fas fa-shipping-fast me-2"></i>Delivery Fee
                                    </span>
                                    <span class="fw-semibold">A${{ number_format($order->delivery_fee, 2) }}</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted">
                                        <i class="fas fa-concierge-bell me-2"></i>Service Fee
                                    </span>
                                    <span class="fw-semibold">A${{ number_format($order->order_fee, 2) }}</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center py-2 border-top mt-2 pt-3" style="border-color: #FFE4D6 !important;">
                                    <span class="text-dark fw-semibold">
                                        <i class="fas fa-file-invoice-dollar me-2"></i>Gross Value
                                    </span>
                                    <span class="fw-bold">A${{ number_format($order->total_price, 2) }}</span>
                                </div>
                            </div>

                            <!-- Total Amount -->
                            <div class="mt-4 p-4 text-white rounded-3" style="background: linear-gradient(135deg, #FF6B35, #F7931E);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-credit-card me-2"></i>Total to Pay
                                    </h5>
                                    <h4 class="mb-0 fw-bold">A${{ number_format($order->gross_price, 2) }}</h4>
                                </div>
                            </div>

                            <!-- Trust Indicators -->
                            <div class="mt-4 text-center">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <i class="fas fa-lock me-2" style="color: #28a745;"></i>
                                    <small class="text-muted">256-bit SSL Encryption</small>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <i class="fab fa-cc-visa me-2" style="color: #1A1F71;"></i>
                                    <i class="fab fa-cc-mastercard me-2" style="color: #EB001B;"></i>
                                    <i class="fab fa-cc-amex me-2" style="color: #006FCF;"></i>
                                    <i class="fab fa-apple-pay me-2" style="color: #000;"></i>
                                    <i class="fab fa-google-pay" style="color: #4285F4;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="col-lg-7">
                        <div class="h-100 p-4 p-lg-5">
                            <!-- Payment Header -->
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745, #20c997);">
                                    <i class="fas fa-credit-card text-white fs-5"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-bold text-dark">Payment Details</h4>
                                    <small class="text-muted">Enter your payment information securely</small>
                                </div>
                            </div>

                            <!-- Security Notice -->
                            <div class="alert border-0 mb-4" style="background: linear-gradient(135deg, #E8F5E8 0%, #D4EDDA 100%); border-radius: 12px;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-shield-check me-3" style="color: #28a745; font-size: 1.2rem;"></i>
                                    <div>
                                        <h6 class="mb-1 fw-bold" style="color: #28a745;">Secure Payment</h6>
                                        <small class="text-muted">Your payment information is encrypted and secure. We never store your card details.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Errors Display -->
                            <div id="payment-errors" class="alert alert-danger d-none mb-3" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <span class="error-message"></span>
                            </div>

                            <!-- Stripe Payment Element -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark mb-3">
                                    <i class="fas fa-credit-card me-2" style="color: #28a745;"></i>
                                    Payment Information
                                </label>
                                <div class="payment-element-container" style="border: 2px solid #E8F5E8; border-radius: 12px; padding: 20px; background: #FAFFFE; min-height: 200px;">
                                    <div id="payment-element" style="min-height: 40px;"></div>
                                </div>
                            </div>

                            <!-- Payment Button -->
                            <div class="d-grid mb-4">
                                <button id="submit" class="btn btn-lg text-white fw-bold py-3 position-relative" style="background: linear-gradient(135deg, #28a745, #20c997); border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); min-height: 60px; overflow: hidden;">
                                    <span class="btn-content d-flex align-items-center justify-content-center">
                                        <i class="fas fa-lock me-2"></i>
                                        Pay A${{ number_format($order->gross_price, 2) }}
                                    </span>
                                    <span class="loading-spinner d-none d-flex align-items-center justify-content-center">
                                        <i class="fas fa-spinner fa-spin me-2"></i>
                                        Processing Payment...
                                    </span>
                                </button>
                            </div>

                            <!-- Terms and Privacy -->
                            <div class="text-center mb-4">
                                <small class="text-muted">
                                    By completing this purchase, you agree to our
                                    <a href="#" class="text-decoration-none fw-semibold" style="color: #FF6B35;">Terms of Service</a>
                                    and
                                    <a href="#" class="text-decoration-none fw-semibold" style="color: #FF6B35;">Privacy Policy</a>.
                                </small>
                            </div>

                            <!-- Powered by Stripe -->
                            <div class="text-center mt-3">
                                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill" style="background: #F8F9FA; border: 1px solid #E9ECEF;">
                                    <small class="text-muted me-2">Powered by</small>
                                    <img src="https://stripe.com/img/v3/home/twitter.png" alt="Stripe" style="height: 16px; width: auto;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

    /* Payment Button Styling */
    #submit {
        transition: all 0.3s ease;
        min-height: 60px;
    }

    #submit:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4) !important;
    }

    #submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* Loading States */
    .btn-content,
    .loading-spinner {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        transition: opacity 0.3s ease;
    }

    /* Payment Element Container */
    .payment-element-container {
        transition: border-color 0.3s ease;
    }

    .payment-element-container:focus-within {
        border-color: #28a745;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
    }

    /* Stripe Element Styling */
    #payment-element .StripeElement,
    #payment-element .__PrivateStripeElement {
        border: none !important;
        background-color: transparent !important;
        padding: 0 !important;
        box-shadow: none !important;
    }

    #payment-element .Input,
    #payment-element input {
        border: 1px solid #E8F5E8 !important;
        border-radius: 8px !important;
        padding: 12px 16px !important;
        background-color: #FAFFFE !important;
        font-size: 16px !important;
        transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
    }

    #payment-element .Input:focus,
    #payment-element input:focus {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25) !important;
        outline: none !important;
    }

    #payment-element .Error {
        color: #dc3545 !important;
        font-size: 14px !important;
        margin-top: 8px !important;
    }

    /* Error Display */
    #payment-errors {
        border-radius: 8px;
    }

    #payment-errors.d-none {
        display: none !important;
    }

    /* Animation for payment button */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
        }
    }

    #submit.processing {
        animation: pulse 2s infinite;
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {

        .col-lg-5,
        .col-lg-7 {
            border-right: none !important;
        }

        .col-lg-5 {
            border-bottom: 1px solid #FFE4D6;
        }
    }

    /* Loading spinner animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .fa-spinner.fa-spin {
        animation: spin 1s linear infinite;
    }
</style>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const options = {
        clientSecret: "{{ $clientSecret }}",
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#28a745',
                colorBackground: '#FAFFFE',
                colorText: '#30313d',
                colorDanger: '#dc3545',
                fontFamily: 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
                spacingUnit: '4px',
                borderRadius: '8px',
                fontSizeBase: '16px',
                colorBorder: '#E8F5E8',
            },
            rules: {
                '.Input': {
                    borderColor: '#E8F5E8',
                    backgroundColor: '#FAFFFE',
                    padding: '12px 16px',
                    fontSize: '16px',
                    borderRadius: '8px',
                },
                '.Input:focus': {
                    borderColor: '#28a745',
                    boxShadow: '0 0 0 2px rgba(40, 167, 69, 0.25)',
                },
                '.Input--invalid': {
                    borderColor: '#dc3545',
                },
                '.Label': {
                    fontSize: '14px',
                    fontWeight: '500',
                    color: '#495057',
                    marginBottom: '8px',
                }
            }
        }
    };

    const elements = stripe.elements(options);
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const submitButton = document.getElementById('submit');
    const btnContent = submitButton.querySelector('.btn-content');
    const loadingSpinner = submitButton.querySelector('.loading-spinner');
    const errorDisplay = document.getElementById('payment-errors');

    // Function to show errors
    function showError(message) {
        errorDisplay.querySelector('.error-message').textContent = message;
        errorDisplay.classList.remove('d-none');
        errorDisplay.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        // Auto-hide after 10 seconds
        setTimeout(() => {
            hideError();
        }, 10000);
    }

    // Function to hide errors
    function hideError() {
        errorDisplay.classList.add('d-none');
    }

    submitButton.addEventListener('click', async (event) => {
        event.preventDefault();

        // Hide any previous errors
        hideError();

        // Disable button and show loading state
        submitButton.disabled = true;
        submitButton.classList.add('processing');
        btnContent.style.opacity = '0';
        loadingSpinner.classList.remove('d-none');
        loadingSpinner.style.opacity = '1';

        try {
            const {
                error
            } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: "{{ route('order.success', $order) }}",
                },
            });

            if (error) {
                // Show error to customer
                showError(error.message);

                // Reset button state
                resetButtonState();
            }
        } catch (err) {
            console.error('Payment error:', err);
            showError('An unexpected error occurred. Please try again.');
            resetButtonState();
        }
    });

    // Function to reset button state
    function resetButtonState() {
        submitButton.disabled = false;
        submitButton.classList.remove('processing');
        btnContent.style.opacity = '1';
        loadingSpinner.classList.add('d-none');
        loadingSpinner.style.opacity = '0';
    }

    // Handle payment element ready state
    paymentElement.on('ready', () => {
        console.log('Payment element ready');
    });

    // Handle real-time validation errors from the payment element
    paymentElement.on('change', (event) => {
        if (event.error) {
            showError(event.error.message);
        } else {
            hideError();
        }
    });
</script>
@endsection