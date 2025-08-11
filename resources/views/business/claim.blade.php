@extends('layouts.app')

@section('content')
<section class="py-5" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 text-center">
                <div class="mb-4">
                    <div class="d-inline-block p-3 rounded-circle shadow-sm" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
                        <i class="fas fa-hand-paper text-white" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <h2 class="display-5 fw-bold mb-3" style="color: #2c3e50;">Claim Your Business</h2>
                <p class="lead text-muted">Take control of your business listing and manage it professionally</p>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-radius: 12px;">
                    <i class="fas fa-check-circle me-3" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center" style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-radius: 12px;">
                    <i class="fas fa-exclamation-circle me-3" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Form -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <!-- Card Header -->
                    <div class="card-header border-0 text-center py-4" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
                        <h4 class="text-white mb-0 fw-bold">
                            <i class="fas fa-clipboard-check me-2"></i>
                            Business Claim Form
                        </h4>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-5">
                        <!-- Info Section -->
                        <div class="alert alert-info border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); border-radius: 12px;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-info-circle me-3 mt-1" style="color: #0c5460; font-size: 1.2rem;"></i>
                                <div>
                                    <h6 class="fw-bold mb-2" style="color: #0c5460;">How Business Claiming Works</h6>
                                    <p class="mb-0 small" style="color: #0c5460;">
                                        Select your business from the list below to claim ownership. Once claimed, you'll be able to manage your business information, respond to reviews, and access analytics.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('business.claim.store') }}" method="POST">
                            @csrf

                            <!-- Business Selection -->
                            <div class="mb-5">
                                <label for="business_id" class="form-label fw-semibold text-dark mb-3">
                                    <i class="fas fa-building text-warning me-2"></i>
                                    Select Your Business <span class="text-danger">*</span>
                                </label>

                                <div class="position-relative">
                                    <input type="text"
                                        id="business_search"
                                        class="form-control form-control-lg border-0 shadow-sm"
                                        style="background: #f8f9fa; border-radius: 12px; padding: 15px 20px;"
                                        placeholder="Type to search for your business..."
                                        autocomplete="off">

                                    <input type="hidden" name="business_id" id="business_id" required>

                                    <div id="search-results"
                                        class="dropdown-menu w-100 shadow-lg border-0 mt-1"
                                        style="max-height: 300px; overflow-y: auto; border-radius: 12px; display: none;">
                                    </div>
                                </div>

                                <div class="form-text text-muted mt-2">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Start typing to search by business name or address. Can't find your business?
                                    <a href="{{ route('business.register') }}" class="text-decoration-none fw-semibold" style="color: #ff6b35;">Register it first</a>
                                </div>
                            </div>

                            <!-- Business Preview Card -->
                            <div id="business-preview" class="d-none mb-4">
                                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%); border-radius: 12px;">
                                    <div class="card-body p-4">
                                        <h6 class="fw-bold mb-3 text-dark">
                                            <i class="fas fa-eye text-warning me-2"></i>
                                            Business Preview
                                        </h6>
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h5 id="preview-name" class="fw-bold mb-2" style="color: #2c3e50;"></h5>
                                                <p id="preview-address" class="text-muted mb-0">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    <span></span>
                                                </p>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <div class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Pending Claim
                                                </div>
                                            </div>
                                        </div>
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
                                    Submit Claim Request
                                </button>
                            </div>

                            <!-- Additional Info -->
                            <div class="text-center mt-4">
                                <p class="text-muted mb-0">
                                    <i class="fas fa-clock text-info me-1"></i>
                                    Claims are typically processed within 2-3 business days
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <div class="text-center mb-4">
                    <h4 class="fw-bold" style="color: #2c3e50;">Benefits of Claiming Your Business</h4>
                </div>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="text-center p-4 h-100 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);">
                            <div class="mb-3">
                                <i class="fas fa-edit text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Edit Information</h6>
                            <p class="text-muted small mb-0">Update your business details, hours, and contact info</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 h-100 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Manage Reviews</h6>
                            <p class="text-muted small mb-0">Respond to customer reviews and build trust</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 h-100 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);">
                            <div class="mb-3">
                                <i class="fas fa-chart-bar text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-2">View Analytics</h6>
                            <p class="text-muted small mb-0">Track views, clicks, and customer engagement</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 h-100 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);">
                            <div class="mb-3">
                                <i class="fas fa-camera text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Add Photos</h6>
                            <p class="text-muted small mb-0">Upload photos to showcase your business</p>
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

    .form-select:focus {
        border-color: #ff6b35;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        background: #ffffff;
    }

    .form-select option {
        padding: 10px;
    }

    /* Icon animations */
    .fas {
        transition: all 0.3s ease;
    }

    .form-group:hover .fas {
        transform: scale(1.1);
    }

    /* Business preview animations */
    #business-preview {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem 1.5rem;
        }

        .display-5 {
            font-size: 2rem;
        }

        .form-select-lg {
            padding: 12px 16px;
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

        .form-select {
            padding: 10px 14px;
            font-size: 0.9rem;
        }

        .btn {
            padding: 10px 16px;
            font-size: 1rem;
        }

        .lead {
            font-size: 1rem;
        }

        .row.g-4 {
            --bs-gutter-x: 1rem;
            --bs-gutter-y: 1rem;
        }

        .col-md-3 {
            margin-bottom: 1rem;
        }
    }

    /* Tablet specific adjustments */
    @media (min-width: 577px) and (max-width: 991px) {
        .card-body {
            padding: 2.5rem 2rem;
        }

        .form-select-lg {
            padding: 13px 18px;
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

        .alert {
            font-size: 0.9rem;
        }

        .badge {
            font-size: 0.8rem;
        }
    }

    /* Search dropdown styles */
    .dropdown-menu {
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);
        color: #ff6b35;
    }

    .business-option {
        transition: all 0.2s ease;
    }

    .business-option:hover {
        transform: translateX(5px);
    }

    /* Focus styles for search input */
    .form-control:focus {
        border-color: #ff6b35;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        background: #ffffff;
    }
</style>

<script>
    // Business data for search
    const businesses = @json($businesses-> map(function($business) {
        return [
            'id' => $business-> id,
            'name' => $business-> name,
            'address' => $business-> address
        ];
    }));

    let selectedBusiness = null;

    // Search functionality
    document.getElementById('business_search').addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        const resultsDiv = document.getElementById('search-results');

        if (query.length === 0) {
            resultsDiv.style.display = 'none';
            return;
        }

        const filteredBusinesses = businesses.filter(business =>
            business.name.toLowerCase().includes(query) ||
            (business.address && business.address.toLowerCase().includes(query))
        );

        if (filteredBusinesses.length > 0) {
            resultsDiv.innerHTML = filteredBusinesses.map(business => `
                <div class="dropdown-item business-option" 
                     data-id="${business.id}" 
                     data-name="${business.name}" 
                     data-address="${business.address || ''}"
                     style="cursor: pointer; padding: 12px 16px; border-bottom: 1px solid #f0f0f0;">
                    <div class="fw-semibold text-dark">${business.name}</div>
                    ${business.address ? `<div class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i>${business.address}</div>` : ''}
                </div>
            `).join('');
            resultsDiv.style.display = 'block';

            // Add click handlers to options
            resultsDiv.querySelectorAll('.business-option').forEach(option => {
                option.addEventListener('click', function() {
                    selectBusiness({
                        id: this.dataset.id,
                        name: this.dataset.name,
                        address: this.dataset.address
                    });
                });
            });
        } else {
            resultsDiv.innerHTML = `
                <div class="dropdown-item text-muted" style="padding: 12px 16px;">
                    <i class="fas fa-search me-2"></i>No businesses found matching "${query}"
                </div>
            `;
            resultsDiv.style.display = 'block';
        }
    });

    // Select business function
    function selectBusiness(business) {
        selectedBusiness = business;
        document.getElementById('business_search').value = business.name;
        document.getElementById('business_id').value = business.id;
        document.getElementById('search-results').style.display = 'none';

        // Show preview
        showBusinessPreview(business);
    }

    // Show business preview
    function showBusinessPreview(business) {
        const previewDiv = document.getElementById('business-preview');

        document.getElementById('preview-name').textContent = business.name;
        document.getElementById('preview-address').querySelector('span').textContent = business.address || 'Address not available';

        previewDiv.classList.remove('d-none');
    }

    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        const searchInput = document.getElementById('business_search');
        const resultsDiv = document.getElementById('search-results');

        if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.style.display = 'none';
        }
    });

    // Clear selection when input is cleared
    document.getElementById('business_search').addEventListener('keyup', function() {
        if (this.value === '') {
            document.getElementById('business_id').value = '';
            document.getElementById('business-preview').classList.add('d-none');
            selectedBusiness = null;
        }
    });
</script>
@endsection