@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Checkout</h2>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <input type="hidden" name="business_id" value="{{ $cart->business_id }}">

        <div class="mb-3">
            <label for="name" class="form-label">Nama Penerima</label>
            <input type="text" id="name" class="form-control" value="{{ $user->name }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Opsi Pengiriman</label>
            <select id="delivery_option" name="delivery_option" class="form-select" required>
                <option value="delivery">Antar ke alamat</option>
                <option value="pickup">Ambil di resto</option>
            </select>
        </div>

        <!-- Form untuk DELIVERY -->
        <div id="delivery_fields">
            <div class="mb-3">
                <label class="form-label">Alamat Pengiriman</label>
                <input type="text" id="shipping_address" name="shipping_address" class="form-control">
                <input type="hidden" id="shipping_lat" name="shipping_lat">
                <input type="hidden" id="shipping_lng" name="shipping_lng">
            </div>

            <div id="map" style="width: 100%; height: 300px; border-radius: 8px;"></div>

            <div class="form-text">
                Kalau alamat ga ketemu, bisa geser pin di peta buat set lokasi.
            </div>

            <div class="mb-3">
                <label class="form-label">Ongkir + ETA</label>
                <p id="shipping_cost_display">-</p>
            </div>
        </div>

        <!-- Info untuk PICKUP -->
        <div id="pickup_fields" style="display:none;">
            <div class="mb-3">
                <p><strong>Ambil Pesanan di Resto:</strong><br>
                    {{ $cart->business->name }}<br>
                    {{ $cart->business->address }}<br>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $cart->business->latitude }},{{ $cart->business->longitude }}" target="_blank">
                        📍 Buka di Google Maps
                    </a>
                </p>
            </div>
            <div id="pickup_map" style="width: 100%; height: 300px; border-radius: 8px;"></div>
        </div>

        <div class="mb-3">
            <label for="delivery_note" class="form-label">Catatan</label>
            <textarea name="delivery_note" id="delivery_note" class="form-control"></textarea>
        </div>

        <h4>Ringkasan Pesanan</h4>
        <ul class="list-group mb-3">
            @foreach($cart->items as $item)
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    {{ $item->product->name }} (x{{ $item->quantity }})
                </div>
                <span>$ {{ number_format($item->total_price, 0, ',', '.') }}</span>
            </li>
            @endforeach
            <li class="list-group-item d-flex justify-content-between">
                <strong>Total</strong>
                <strong>$ {{ number_format($cart->items->sum('total_price'), 0, ',', '.') }}</strong>
            </li>
        </ul>

        <button type="submit" class="btn btn-primary w-100">Bayar dengan Stripe</button>
    </form>
</div>

<script>
    const productMaxDistances = @json($maxDistances);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
<script>
    const deliveryOption = document.getElementById('delivery_option');
    const deliveryFields = document.getElementById('delivery_fields');
    const pickupFields   = document.getElementById('pickup_fields');

    deliveryOption.addEventListener('change', function () {
        if (this.value === 'pickup') {
            deliveryFields.style.display = 'none';
            pickupFields.style.display = 'block';
        } else {
            deliveryFields.style.display = 'block';
            pickupFields.style.display = 'none';
        }
    });

    function initAutocomplete() {
        const input = document.getElementById('shipping_address');
        const autocomplete = new google.maps.places.Autocomplete(input);

        const businessLocation = { lat: {{ $cart->business->latitude }}, lng: {{ $cart->business->longitude }} };

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
                    // 🔹 Cek apakah ada produk yg melebihi max_distance
                    let exceeded = [];
                    Object.entries(productMaxDistances).forEach(([productId, product]) => {
                        if (product.max_distance && data.distance_km > product.max_distance) {
                            exceeded.push(`- ${product.name} (maksimal ${product.max_distance} km)`);
                        }
                    });

                    if (exceeded.length > 0) {
                        alert("⚠️ Produk berikut tidak bisa dikirim karena jarak terlalu jauh:\n\n" + exceeded.join("\n"));
                        document.getElementById('shipping_cost_display').textContent =
                            '❌ Tidak bisa dikirim (melebihi jarak maksimum produk)';
                        document.querySelector('button[type="submit"]').disabled = true;
                        return;
                    } else {
                        document.querySelector('button[type="submit"]').disabled = false;
                    }

                    // --- Hitung rute + ETA kalau lolos ---
                    directionsService.route({
                        origin: businessLocation,
                        destination: { lat, lng },
                        travelMode: 'DRIVING'
                    }, (response, status) => {
                        if (status === 'OK') {
                            directionsRenderer.setDirections(response);

                            const leg = response.routes[0].legs[0];
                            const eta = leg.duration.text;

                            document.getElementById('shipping_cost_display').textContent =
                                `$${data.delivery_fee} AUD (jarak ${data.distance_km} km, perkiraan ${eta})`;

                            new google.maps.Marker({
                                map: map,
                                position: businessLocation,
                                icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                            });
                        }
                    });
                } else {
                    document.getElementById('shipping_cost_display').textContent = 'Tidak dapat menghitung ongkir';
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
