@extends('layouts.app')

@section('content')
<section class="py-5" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="mb-4">
                    <div class="d-inline-block p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
                        <i class="fas fa-store text-white" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <h2 class="display-5 fw-bold mb-3" style="color: #2c3e50;">Register Your Business</h2>
                <p class="lead text-muted">Join Indonesia's business community and achieve success together</p>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <div class="alert alert-success border-0 shadow-sm" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        </div>
        @endif

        <!-- Main Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <!-- Card Header -->
                    <div class="card-header border-0 text-center py-4" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
                        <h4 class="text-white mb-0 fw-bold">Business Registration Form</h4>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-5">
                        <form action="{{ route('business.register.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Business Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-building text-warning me-2"></i>
                                    Business Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    name="name"
                                    id="name"
                                    required
                                    class="form-control form-control-lg border-0 shadow-sm"
                                    style="background: #f8f9fa; border-radius: 12px; padding: 12px 20px;"
                                    value="{{ old('name') }}"
                                    placeholder="Enter your business name">
                            </div>

                            <!-- Business Type -->
                            <div class="mb-4">
                                <label for="type_id" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-tags text-warning me-2"></i>
                                    Business Type <span class="text-danger">*</span>
                                </label>
                                <select name="type_id"
                                    id="type_id"
                                    class="form-select form-select-lg border-0 shadow-sm"
                                    style="background: #f8f9fa; border-radius: 12px; padding: 12px 20px;"
                                    required>
                                    <option value="" disabled selected>Select business type</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-align-left text-warning me-2"></i>
                                    Business Description
                                </label>
                                <textarea name="description"
                                    id="description"
                                    rows="4"
                                    class="form-control border-0 shadow-sm"
                                    style="background: #f8f9fa; border-radius: 12px; padding: 12px 20px; resize: vertical;"
                                    placeholder="Tell us about your business...">{{ old('description') }}</textarea>
                            </div>

                            <!-- Location Section -->
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3" style="color: #ff6b35;">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Location Information
                                </h5>

                                <div class="row">
                                    <!-- Country -->
                                    <div class="col-md-6 mb-3">
                                        <label for="country" class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-globe text-warning me-2"></i>
                                            Country
                                        </label>
                                        <input type="text"
                                            name="country"
                                            id="country"
                                            class="form-control border-0 shadow-sm"
                                            style="background: #f8f9fa; border-radius: 12px; padding: 12px 20px;"
                                            value="{{ old('country', 'Indonesia') }}"
                                            placeholder="Indonesia">
                                    </div>

                                    <!-- City -->
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label fw-semibold text-dark mb-2">
                                            <i class="fas fa-city text-warning me-2"></i>
                                            City
                                        </label>
                                        <input type="text"
                                            name="city"
                                            id="city"
                                            class="form-control border-0 shadow-sm"
                                            style="background: #f8f9fa; border-radius: 12px; padding: 12px 20px;"
                                            value="{{ old('city') }}"
                                            placeholder="City name">
                                    </div>
                                </div>

                                <!-- Full Address -->
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-semibold text-dark mb-2">
                                        <i class="fas fa-home text-warning me-2"></i>
                                        Full Address
                                    </label>
                                    <input type="text"
                                        name="address"
                                        id="address"
                                        class="form-control border-0 shadow-sm"
                                        style="background: #f8f9fa; border-radius: 12px; padding: 12px 20px;"
                                        value="{{ old('address') }}"
                                        placeholder="Street address, district, subdistrict">
                                </div>

                                <!-- Google Maps URL -->
                                <div class="mb-3">
                                    <label for="location" class="form-label fw-semibold text-dark mb-2">
                                        <i class="fas fa-map text-warning me-2"></i>
                                        Google Maps Link
                                    </label>
                                    <input type="url"
                                        name="location"
                                        id="location"
                                        class="form-control border-0 shadow-sm"
                                        style="background: #f8f9fa; border-radius: 12px; padding: 12px 20px;"
                                        value="{{ old('location') }}"
                                        placeholder="https://maps.google.com/...">
                                    <div class="form-text text-muted mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Optional: Enter Google Maps link to help customers find your business location
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mt-5">
                                <button type="submit"
                                    class="btn btn-lg text-white fw-bold py-3 border-0 shadow-sm"
                                    style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%); border-radius: 12px; transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(255,107,53,0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Register My Business
                                </button>
                            </div>

                            <!-- Additional Info -->
                            <div class="text-center mt-4">
                                <p class="text-muted mb-0">
                                    <i class="fas fa-shield-alt text-success me-1"></i>
                                    Your data is secure and will be verified within 1-2 business days
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="text-center mb-4">
                    <h4 class="fw-bold" style="color: #2c3e50;">Benefits of Joining Us</h4>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center p-4 h-100 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);">
                            <div class="mb-3">
                                <i class="fas fa-users text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Wider Reach</h6>
                            <p class="text-muted small mb-0">Reach more customers with our trusted platform</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 h-100 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);">
                            <div class="mb-3">
                                <i class="fas fa-chart-line text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Business Analytics</h6>
                            <p class="text-muted small mb-0">Get deep insights about your business performance</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 h-100 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);">
                            <div class="mb-3">
                                <i class="fas fa-headset text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-2">24/7 Support</h6>
                            <p class="text-muted small mb-0">Support team ready to help whenever you need</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Custom animations and hover effects */
    .card {
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #ff6b35;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        background: #ffffff;
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    /* Icon animations */
    .fas {
        transition: all 0.3s ease;
    }

    .form-group:hover .fas {
        transform: scale(1.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem 1.5rem;
        }

        .display-5 {
            font-size: 2rem;
        }

        .form-control-lg,
        .form-select-lg {
            padding: 10px 16px;
            font-size: 1rem;
        }

        .btn-lg {
            padding: 12px 20px;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 1.5rem 1rem;
        }

        .display-5 {
            font-size: 1.75rem;
        }

        .card {
            margin: 0 10px;
        }

        .form-control,
        .form-select {
            padding: 8px 14px;
            font-size: 0.9rem;
        }

        .btn {
            padding: 10px 16px;
            font-size: 1rem;
        }

        .lead {
            font-size: 1rem;
        }

        .benefits-section .col-md-4 {
            margin-bottom: 1rem;
        }

        .benefits-section .card {
            padding: 1.5rem;
        }
    }

    /* Tablet specific adjustments */
    @media (min-width: 577px) and (max-width: 991px) {
        .card-body {
            padding: 2.5rem 2rem;
        }

        .form-control-lg,
        .form-select-lg {
            padding: 11px 18px;
            font-size: 1.05rem;
        }

        .btn-lg {
            padding: 13px 22px;
            font-size: 1.15rem;
        }
    }

    /* Enhanced mobile form elements */
    @media (max-width: 768px) {
        .form-label {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .form-text {
            font-size: 0.8rem;
        }

        .fas {
            font-size: 1rem;
        }

        .row.g-4 {
            --bs-gutter-x: 1rem;
            --bs-gutter-y: 1rem;
        }
    }
</style>
@endsection