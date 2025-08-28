@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #FFF5E6 0%, #FFF8F0 100%);">
    <div class="container-fluid py-5">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <div class="d-inline-block position-relative">
                <h1 class="display-4 fw-bold text-dark mb-2" style="font-family: 'Playfair Display', serif;">Checkout</h1>
                <div class="position-absolute top-100 start-50 translate-middle-x" style="width: 80px; height: 4px; background: linear-gradient(90deg, #FF6B35, #F7931E); border-radius: 2px;"></div>
            </div>
            <p class="text-muted mt-4">Complete your order and enjoy authentic Indonesian cuisine</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                    <!-- Card Header with Indonesian Pattern -->
                    <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%); position: relative;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><circle cx=\"20\" cy=\"20\" r=\"2\" fill=\"white\"/><circle cx=\"80\" cy=\"20\" r=\"2\" fill=\"white\"/><circle cx=\"20\" cy=\"80\" r=\"2\" fill=\"white\"/><circle cx=\"80\" cy=\"80\" r=\"2\" fill=\"white\"/><circle cx=\"50\" cy=\"50\" r=\"3\" fill=\"white\"/></svg>'); background-size: 50px 50px;"></div>
                        <h3 class="mb-0 fw-bold position-relative">Order Details</h3>
                        <small class="opacity-75 position-relative">Please review your information</small>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="business_id" value="{{ $cart->business_id }}">

                            <!-- Customer Information -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF6B35, #F7931E);">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold text-dark">Customer Information</h5>
                                </div>
                                <div class="form-floating">
                                    <input type="text" id="name" class="form-control border-2" style="border-color: #FFE4D6 !important; background-color: #FFF8F5;" value="{{ $user->name }}" readonly>
                                    <label for="name" class="text-muted">Recipient Name</label>
                                </div>
                            </div>

                            <!-- Delivery Options -->
                            @if($business->supports_delivery || $business->supports_pickup)
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF6B35, #F7931E);">
                                        <i class="fas fa-shipping-fast text-white"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold text-dark">Delivery Options</h5>
                                </div>

                                <div class="row g-3">
                                    @if($business->supports_delivery)
                                    <div class="col-md-6">
                                        <div class="form-check custom-radio">
                                            <input class="form-check-input" type="radio" name="delivery_option" id="delivery_radio" value="delivery" {{ $business->supports_delivery ? 'checked' : '' }}>
                                            <label class="form-check-label card h-100 border-2 p-3 cursor-pointer" for="delivery_radio" style="border-color: #FFE4D6 !important;">
                                                <div class="text-center">
                                                    <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: #FFF5E6;">
                                                        <i class="fas fa-motorcycle" style="color: #FF6B35; font-size: 1.2rem;"></i>
                                                    </div>
                                                    <h6 class="mb-1 fw-bold">Home Delivery</h6>
                                                    <small class="text-muted">Delivered to your address</small>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    @endif

                                    @if($business->supports_pickup)
                                    <div class="col-md-6">
                                        <div class="form-check custom-radio">
                                            <input class="form-check-input" type="radio" name="delivery_option" id="pickup_radio" value="pickup" {{ !$business->supports_delivery ? 'checked' : '' }}>
                                            <label class="form-check-label card h-100 border-2 p-3 cursor-pointer" for="pickup_radio" style="border-color: #FFE4D6 !important;">
                                                <div class="text-center">
                                                    <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: #FFF5E6;">
                                                        <i class="fas fa-store" style="color: #FF6B35; font-size: 1.2rem;"></i>
                                                    </div>
                                                    <h6 class="mb-1 fw-bold">Restaurant Pickup</h6>
                                                    <small class="text-muted">Pick up at {{ $business->name }}</small>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Hidden select untuk form submission -->
                                <select id="delivery_option" name="delivery_option" class="form-select d-none" required>
                                    @if($business->supports_delivery)
                                    <option value="delivery">Antar ke alamat</option>
                                    @endif
                                    @if($business->supports_pickup)
                                    <option value="pickup">Ambil di resto</option>
                                    @endif
                                </select>
                            </div>
                            @endif

                            <!-- Delivery Address Fields -->
                            <div id="delivery_fields" class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF6B35, #F7931E);">
                                        <i class="fas fa-map-marker-alt text-white"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold text-dark">Delivery Address</h5>
                                </div>
                                
                                <div class="form-floating mb-3">
                                    <input type="text" id="shipping_address" name="shipping_address" class="form-control border-2" style="border-color: #FFE4D6 !important; background-color: #FFF8F5;" placeholder="Enter your delivery address">
                                    <label for="shipping_address" class="text-muted">Delivery Address</label>
                                    <input type="hidden" id="shipping_lat" name="shipping_lat">
                                    <input type="hidden" id="shipping_lng" name="shipping_lng">
                                </div>

                                <div class="card border-2 mb-3" style="border-color: #FFE4D6 !important;">
                                    <div id="map" style="width: 100%; height: 300px; border-radius: 8px;"></div>
                                </div>

                                <div class="alert alert-info border-0 mb-3" style="background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);">
                                    <i class="fas fa-info-circle me-2" style="color: #1976D2;"></i>
                                    <small>If the address is not found, you can drag the pin on the map to set the exact location.</small>
                                </div>

                                <div class="card border-2" style="border-color: #FFE4D6 !important; background: #FFF8F5;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calculator me-3" style="color: #FF6B35;"></i>
                                            <div>
                                                <h6 class="mb-1 fw-bold">Shipping Cost & ETA</h6>
                                                <p id="shipping_cost_display" class="mb-0 text-muted">Select delivery address to calculate</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pickup Information -->
                            <div id="pickup_fields" style="display:none;" class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF6B35, #F7931E);">
                                        <i class="fas fa-store text-white"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold text-dark">Pickup Location</h5>
                                </div>

                                @if($cart->business->is_virtual)
                                    <div class="form-floating mb-3">
                                        <select id="pickup_business_id" name="pickup_business_id" class="form-select border-2" style="border-color: #FFE4D6 !important; background-color: #FFF8F5;" required>
                                            <option value="">-- Select Pickup Location --</option>
                                            @foreach($cart->business->pickupLocations as $location)
                                                <option value="{{ $location->id }}"
                                                    data-lat="{{ $location->latitude }}"
                                                    data-lng="{{ $location->longitude }}"
                                                    data-address="{{ $location->address }}">
                                                    {{ $location->name }} - {{ $location->address }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="pickup_business_id" class="text-muted">Choose where you want to pickup</label>
                                    </div>

                                    <div id="pickup_info" class="card border-2 mb-3 d-none" style="border-color: #FFE4D6 !important; background: #FFF8F5;">
                                        <div class="card-body">
                                            <h6 id="pickup_name" class="fw-bold text-dark mb-2"></h6>
                                            <p id="pickup_address" class="text-muted mb-3"></p>
                                            <a id="pickup_directions" href="#" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-directions me-2"></i>Get Directions
                                            </a>
                                        </div>
                                    </div>

                                    <div class="card border-2" style="border-color: #FFE4D6 !important;">
                                        <div id="pickup_map" style="width: 100%; height: 300px; border-radius: 8px;"></div>
                                    </div>
                                @else
                                    <!-- Kalau resto fisik biasa -->
                                    <div class="card border-2 mb-3" style="border-color: #FFE4D6 !important; background: #FFF8F5;">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-dark mb-2">{{ $cart->business->name }}</h6>
                                            <p class="text-muted mb-3">{{ $cart->business->address }}</p>
                                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $cart->business->latitude }},{{ $cart->business->longitude }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-directions me-2"></i>Get Directions
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card border-2" style="border-color: #FFE4D6 !important;">
                                        <div id="pickup_map" style="width: 100%; height: 300px; border-radius: 8px;"></div>
                                    </div>
                                @endif
                            </div>

                            <!-- Order Notes -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF6B35, #F7931E);">
                                        <i class="fas fa-sticky-note text-white"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold text-dark">Special Instructions</h5>
                                </div>
                                <div class="form-floating">
                                    <textarea name="delivery_note" id="delivery_note" class="form-control border-2" style="border-color: #FFE4D6 !important; background-color: #FFF8F5; min-height: 100px;" placeholder="Any special instructions for your order..."></textarea>
                                    <label for="delivery_note" class="text-muted">Additional Notes (Optional)</label>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF6B35, #F7931E);">
                                        <i class="fas fa-receipt text-white"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold text-dark">Order Summary</h5>
                                </div>
                                
                                <div class="card border-2" style="border-color: #FFE4D6 !important;">
                                    <div class="card-body p-0">
                                        @foreach($cart->items as $index => $item)
                                        <div class="d-flex justify-content-between align-items-center p-3 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: #FFE4D6 !important;">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: #FFF5E6 !important;">
                                                    <span class="fw-bold" style="color: #FF6B35;">{{ $item->quantity }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">Quantity: {{ $item->quantity }}</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="fw-bold" style="color: #FF6B35; font-size: 1.1rem;">${{ number_format($item->total_price, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                        <div class="p-3 text-white" style="background: linear-gradient(135deg, #FF6B35, #F7931E);">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0 fw-bold">Total Amount</h5>
                                                <h4 class="mb-0 fw-bold">${{ number_format($cart->items->sum('total_price'), 0, ',', '.') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg text-white fw-bold px-5 py-3 btn-stripe">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Pay with Stripe
                                </button>
                                <p class="text-muted mt-3 mb-0">
                                    <small>
                                        <i class="fas fa-shield-alt me-1" style="color: #28a745;"></i>
                                        Secure payment powered by Stripe
                                    </small>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-stripe {
        background: linear-gradient(135deg, #FF6B35, #F7931E);
        border: none;
        border-radius: 50px;
        min-width: 250px;
        box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    /* Hover animasi */
    .btn-stripe:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 107, 53, 0.6);
    }

    /* Klik efek */
    .btn-stripe:active {
        transform: scale(0.97);
    }

    /* Tambahin subtle shine effect */
    .btn-stripe::before {
        content: "";
        position: absolute;
        top: 0;
        left: -75%;
        width: 50%;
        height: 100%;
        background: linear-gradient(120deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 80%);
        transform: skewX(-25deg);
    }

    .btn-stripe:hover::before {
        animation: shine 0.8s forwards;
    }

    @keyframes shine {
        100% {
            left: 125%;
        }
    }
    .custom-radio .form-check-input:checked ~ .form-check-label {
        border-color: #FF6B35 !important;
        background: linear-gradient(135deg, #FFF5E6, #FFE4D6) !important;
        box-shadow: 0 0 0 2px rgba(255, 107, 53, 0.2) !important;
    }
    
    .custom-radio .form-check-input {
        display: none;
    }
    
    .custom-radio .form-check-label {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .custom-radio .form-check-label:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #FF6B35 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25) !important;
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');
</style>

<script>
    const productMaxDistances = @json($maxDistances);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
<script>
    // Update radio button functionality
    const deliveryRadio = document.getElementById('delivery_radio');
    const pickupRadio = document.getElementById('pickup_radio');
    const deliveryOption = document.getElementById('delivery_option');
    const deliveryFields = document.getElementById('delivery_fields');
    const pickupFields = document.getElementById('pickup_fields');

    function toggleRequired() {
        const pickupSelect = document.getElementById('pickup_business_id');
        const pickupFields = document.getElementById('pickup_fields');
        if (!pickupSelect) return;

        if (pickupFields && pickupFields.style.display !== 'none') {
            pickupSelect.setAttribute('required', 'required');
        } else {
            pickupSelect.removeAttribute('required');
        }
    }

    function updateDeliveryOption() {
        if (deliveryRadio && deliveryRadio.checked) {
            deliveryOption.value = 'delivery';
            if (deliveryFields) deliveryFields.style.display = 'block';
            if (pickupFields) pickupFields.style.display = 'none';
        } else if (pickupRadio && pickupRadio.checked) {
            deliveryOption.value = 'pickup';
            if (deliveryFields) deliveryFields.style.display = 'none';
            if (pickupFields) pickupFields.style.display = 'block';
        }

        // ⬅️ selalu update required setelah show/hide
        toggleRequired();
    }

    // Pasang event listener kalau radio ada
    if (deliveryRadio) deliveryRadio.addEventListener('change', updateDeliveryOption);
    if (pickupRadio) pickupRadio.addEventListener('change', updateDeliveryOption);

    // Sync hidden select
    if (deliveryOption) {
        deliveryOption.addEventListener('change', function () {
            if (this.value === 'pickup') {
                if (deliveryFields) deliveryFields.style.display = 'none';
                if (pickupFields) pickupFields.style.display = 'block';
                if (pickupRadio) pickupRadio.checked = true;
            } else {
                if (deliveryFields) deliveryFields.style.display = 'block';
                if (pickupFields) pickupFields.style.display = 'none';
                if (deliveryRadio) deliveryRadio.checked = true;
            }

            // ⬅️ update required juga di sini
            toggleRequired();
        });
    }

    // Atur default tampilan field saat load
    window.addEventListener('DOMContentLoaded', function () {
        updateDeliveryOption(); // inisialisasi + toggle required
    });

    function initAutocomplete() {
        // Pickup dropdown handler (khusus Virtual Store)
        const pickupSelect = document.getElementById('pickup_business_id');
        if (pickupSelect) {
            pickupSelect.addEventListener('change', function () {
                const selected = this.options[this.selectedIndex];
                if (!selected.value) return;

                const lat = parseFloat(selected.dataset.lat);
                const lng = parseFloat(selected.dataset.lng);
                const address = selected.dataset.address;
                const name = selected.text.split(" - ")[0];

                // Update info card
                document.getElementById('pickup_name').innerText = name;
                document.getElementById('pickup_address').innerText = address;
                document.getElementById('pickup_directions').href =
                    `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
                document.getElementById('pickup_info').classList.remove('d-none');

                // Update map
                const pickupMap = new google.maps.Map(document.getElementById("pickup_map"), {
                    zoom: 15,
                    center: { lat, lng }
                });
                new google.maps.Marker({
                    map: pickupMap,
                    position: { lat, lng },
                    title: name
                });
            });
        }

        const input = document.getElementById('shipping_address');
        const autocomplete = new google.maps.places.Autocomplete(input);

        // Tentukan center map
        @if ($cart->business->is_virtual)
            // Virtual Store → default ke Victoria (Melbourne CBD misalnya)
            const businessLocation = { lat: -37.8136, lng: 144.9631 };
        @else
            // Real Store → pakai koordinat resto
            const businessLocation = { lat: {{ $cart->business->latitude }}, lng: {{ $cart->business->longitude }} };
        @endif

        // Map Delivery
        const map = new google.maps.Map(document.getElementById("map"), {
            center: businessLocation,
            zoom: 13
        });

        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer({ suppressMarkers: true });
        directionsRenderer.setMap(map);

        const geocoder = new google.maps.Geocoder();

        // Marker User
        const marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: businessLocation
        });

        // Autocomplete alamat
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();

            marker.setPosition({ lat, lng });
            map.setCenter({ lat, lng });

            updateShipping(lat, lng, directionsService, directionsRenderer);
        });

        // Drag marker manual
        google.maps.event.addListener(marker, 'dragend', function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();

            geocoder.geocode({ location: { lat, lng } }, function(results, status) {
                if (status === 'OK' && results[0]) {
                    input.value = results[0].formatted_address;
                }
            });

            updateShipping(lat, lng, directionsService, directionsRenderer);
        });

        function updateShipping(lat, lng, directionsService, directionsRenderer) {
            document.getElementById('shipping_lat').value = lat;
            document.getElementById('shipping_lng').value = lng;

            fetch('{{ route("shipping.calculate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    business_id: '{{ $cart->business_id }}',
                    shipping_lat: lat,
                    shipping_lng: lng,
                    delivery_option: 'delivery'
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.delivery_fee !== undefined) {
                    // 🔹 Cek max distance
                    let exceeded = [];
                    Object.entries(productMaxDistances).forEach(([productId, product]) => {
                        if (product.max_distance && data.distance_km > product.max_distance) {
                            exceeded.push(`- ${product.name} (maksimal ${product.max_distance} km)`);
                        }
                    });

                    if (exceeded.length > 0) {
                        alert("⚠️ Produk berikut tidak bisa dikirim karena jarak terlalu jauh:\n\n" + exceeded.join("\n"));
                        document.getElementById('shipping_cost_display').innerHTML =
                            '<span class="text-danger"><i class="fas fa-exclamation-circle me-2"></i>Cannot deliver (exceeds maximum product distance)</span>';
                        document.querySelector('button[type="submit"]').disabled = true;
                        return;
                    } else {
                        document.querySelector('button[type="submit"]').disabled = false;
                    }

                    // --- 🔹 Bedakan Virtual Store vs Real Store ---
                    @if ($cart->business->is_virtual)
                        // 👉 Virtual: flat ongkir aja, tanpa jarak & ETA
                        document.getElementById('shipping_cost_display').innerHTML =
                            `<span class="text-success fw-bold">$${data.delivery_fee} AUD</span>`;
                    @else
                        // 👉 Resto asli: hitung rute + ETA
                        directionsService.route({
                            origin: businessLocation,
                            destination: { lat, lng },
                            travelMode: 'DRIVING'
                        }, (response, status) => {
                            if (status === 'OK') {
                                directionsRenderer.setDirections(response);
                                const leg = response.routes[0].legs[0];
                                const eta = leg.duration.text;

                                document.getElementById('shipping_cost_display').innerHTML =
                                    `<span class="text-success fw-bold">$${data.delivery_fee} AUD</span> <small class="text-muted">(${data.distance_km} km, ETA: ${eta})</small>`;

                                new google.maps.Marker({
                                    map: map,
                                    position: businessLocation,
                                    icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                                });
                            }
                        });
                    @endif
                } else {
                    document.getElementById('shipping_cost_display').innerHTML =
                        '<span class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Unable to calculate shipping cost</span>';
                }
            });
        }

        // Map Pickup
        const pickupLocation = businessLocation;
        const pickupMap = new google.maps.Map(document.getElementById("pickup_map"), {
            zoom: 15,
            center: pickupLocation
        });
        new google.maps.Marker({
            map: pickupMap,
            position: pickupLocation,
            title: "Lokasi Restoran"
        });
    }

    google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>
@endsection