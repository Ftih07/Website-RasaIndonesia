@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #FFF5E6 0%, #FFF8F0 100%);">
    <div class="container-fluid py-5">
        <!-- Success Animation Section -->
        <div class="text-center mb-5">
            <div class="position-relative d-inline-block">
                <!-- Success Check Animation -->
                <div class="success-checkmark">
                    <div class="check-icon">
                        <span class="icon-line line-tip"></span>
                        <span class="icon-line line-long"></span>
                        <div class="icon-circle"></div>
                        <div class="icon-fix"></div>
                    </div>
                </div>

                <h1 class="display-4 fw-bold text-dark mb-3" style="font-family: 'Playfair Display', serif;">Order Confirmed!</h1>
                <p class="lead text-muted mb-4">Thank you! Your delicious Indonesian cuisine is on its way</p>

                <!-- Order Number Badge -->
                <div class="d-inline-block px-4 py-2 rounded-pill text-white mb-4" style="background: linear-gradient(135deg, #FF6B35, #F7931E); box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);">
                    <i class="fas fa-receipt me-2"></i>
                    <strong>Order #{{ $order->order_number }}</strong>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <!-- Order Status Card -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #28a745, #20c997);">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fas fa-clock me-3 fs-4"></i>
                            <div>
                                <h5 class="mb-0 fw-bold">Order Status</h5>
                                <small class="opacity-75">Current status of your order</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="status-badge d-inline-block px-4 py-2 rounded-pill fw-bold text-white mb-3"
                                style="background: linear-gradient(135deg, #17a2b8, #138496);">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ ucfirst($order->delivery_status) }}
                            </div>
                            <p class="text-muted mb-0">We'll keep you updated on your order progress</p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Card -->
                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <!-- Card Header -->
                    <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%); position: relative;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: url('data:image/svg+xml,<svg xmlns=\" http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\">
                            <circle cx=\"20\" cy=\"20\" r=\"2\" fill=\"white\" />
                            <circle cx=\"80\" cy=\"20\" r=\"2\" fill=\"white\" />
                            <circle cx=\"20\" cy=\"80\" r=\"2\" fill=\"white\" />
                            <circle cx=\"80\" cy=\"80\" r=\"2\" fill=\"white\" />
                            <circle cx=\"50\" cy=\"50\" r=\"3\" fill=\"white\" /></svg>'); background-size: 50px 50px;">
                        </div>
                        <h3 class="mb-0 fw-bold position-relative">Order Summary</h3>
                        <small class="opacity-75 position-relative">Review your delicious order</small>
                    </div>

                    <div class="card-body p-0">
                        <!-- Order Items -->
                        @foreach($order->items as $index => $item)
                        <div class="p-4 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: #FFE4D6 !important;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1 me-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FFF5E6, #FFE4D6) !important;">
                                            <span class="fw-bold" style="color: #FF6B35;">{{ $item->quantity }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->quantity }} × A${{ number_format($item->unit_price, 2) }}</small>
                                        </div>
                                    </div>

                                    <!-- Product Options -->
                                    @if(!empty($item->options_for_view))
                                    <div class="ms-5 ps-2">
                                        @foreach($item->options_for_view as $group)
                                        @foreach($group['items'] as $opt)
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-plus me-2" style="color: #FF6B35; font-size: 0.7rem;"></i>
                                            <small class="text-muted">
                                                {{ $opt['name'] }}
                                                @if(isset($opt['price']) && $opt['price'] > 0)
                                                <span class="fw-bold" style="color: #FF6B35;">(+A${{ number_format($opt['price'], 2) }})</span>
                                                @endif
                                            </small>
                                        </div>
                                        @endforeach
                                        @endforeach
                                    </div>
                                    @endif
                                </div>

                                <div class="text-end">
                                    <span class="fw-bold fs-5" style="color: #FF6B35;">A${{ number_format($item->total_price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Price Breakdown -->
                        <div class="p-4" style="background: linear-gradient(135deg, #FFF8F5, #FFF5E6);">
                            <!-- Subtotal -->
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">
                                    <i class="fas fa-calculator me-2"></i>Subtotal
                                </span>
                                <span class="fw-semibold">A${{ number_format($order->items->sum('total_price'), 2) }}</span>
                            </div>

                            <!-- Delivery Fee -->
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">
                                    <i class="fas fa-shipping-fast me-2"></i>Delivery Fee
                                </span>
                                <span class="fw-semibold">A${{ number_format($order->delivery_fee, 2) }}</span>
                            </div>

                            <!-- Service Fee -->
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted">
                                    <i class="fas fa-concierge-bell me-2"></i>Service Fee
                                </span>
                                <span class="fw-semibold">A${{ number_format($order->order_fee, 2) }}</span>
                            </div>

                            <!-- Gross Value -->
                            <div class="d-flex justify-content-between align-items-center py-2 border-top mt-2 pt-3" style="border-color: #FFE4D6 !important;">
                                <span class="text-dark fw-semibold">
                                    <i class="fas fa-file-invoice-dollar me-2"></i>Gross Value
                                </span>
                                <span class="fw-bold">A${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>

                        <!-- Total Amount -->
                        <div class="p-4 text-white" style="background: linear-gradient(135deg, #FF6B35, #F7931E);">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-credit-card me-2"></i>Total Paid
                                </h5>
                                <h4 class="mb-0 fw-bold">A${{ number_format($order->gross_price, 2) }}</h4>
                            </div>
                            <small class="opacity-75 mt-2 d-block">
                                <i class="fas fa-shield-alt me-2"></i>
                                Payment processed securely via Stripe
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-5">
                    <a href="{{ route('orders.index') }}" class="btn btn-lg text-white fw-bold px-5 py-3 me-3"
                        style="background: linear-gradient(135deg, #28A745, #218838); border: none; border-radius: 50px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);">
                        <i class="fas fa-truck me-2"></i>
                        Track Orders
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-secondary btn-lg px-5 py-3" style="border-radius: 50px;">
                        <i class="fas fa-print me-2"></i>
                        Print Receipt
                    </button>
                </div>

                <!-- Additional Info -->
                <div class="alert alert-info border-0 mt-4 text-center" style="background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%); border-radius: 15px;">
                    <i class="fas fa-info-circle me-2" style="color: #1976D2;"></i>
                    <small>You will receive an email confirmation shortly. Keep this order number for your reference.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

    .success-checkmark {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: block;
        stroke-width: 3;
        stroke: #4CAF50;
        stroke-miterlimit: 10;
        margin: 0 auto;
        box-shadow: inset 0px 0px 0px #4CAF50;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        position: relative;
    }

    .success-checkmark .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: border-box;
        border: 3px solid #4CAF50;
        background: #4CAF50;
    }

    .success-checkmark .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }

    .success-checkmark .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }

    .success-checkmark .check-icon::before,
    .success-checkmark .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: #FFFFFF;
        transform: rotate(-45deg);
    }

    .success-checkmark .check-icon .icon-line {
        height: 3px;
        background: #4CAF50;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }

    .success-checkmark .check-icon .icon-line.line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }

    .success-checkmark .check-icon .icon-line.line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }

    .success-checkmark .check-icon .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 3px solid #4CAF50;
        background: transparent;
    }

    .success-checkmark .check-icon .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background: #FFFFFF;
    }

    @keyframes rotate-circle {
        0% {
            transform: rotate(-45deg);
        }

        5% {
            transform: rotate(-45deg);
        }

        12% {
            transform: rotate(-405deg);
        }

        100% {
            transform: rotate(-405deg);
        }
    }

    @keyframes icon-line-tip {
        0% {
            width: 0;
            left: 1px;
            top: 19px;
        }

        54% {
            width: 0;
            left: 1px;
            top: 19px;
        }

        70% {
            width: 50px;
            left: -8px;
            top: 37px;
        }

        84% {
            width: 17px;
            left: 21px;
            top: 48px;
        }

        100% {
            width: 25px;
            left: 14px;
            top: 45px;
        }
    }

    @keyframes icon-line-long {
        0% {
            width: 0;
            right: 46px;
            top: 54px;
        }

        65% {
            width: 0;
            right: 46px;
            top: 54px;
        }

        84% {
            width: 55px;
            right: 0px;
            top: 35px;
        }

        100% {
            width: 47px;
            right: 8px;
            top: 38px;
        }
    }

    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 30px #4CAF50;
        }
    }

    @keyframes scale {

        0%,
        100% {
            transform: none;
        }

        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }

    /* Print Styles */
    @media print {

        .btn,
        .alert {
            display: none !important;
        }

        .card {
            box-shadow: none !important;
        }
    }
</style>
@endsection