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

        <div id="address_section">
            <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
            <input type="text" name="shipping_address" id="shipping_address" class="form-control" required>
            <input type="hidden" name="shipping_lat" id="shipping_lat">
            <input type="hidden" name="shipping_lng" id="shipping_lng">
        </div>

        <div class="mb-3">
            <label class="form-label">Ongkir</label>
            <p id="shipping_cost_display">-</p>
        </div>

        <div class="mb-3">
            <label for="delivery_note" class="form-label">Catatan Pengiriman</label>
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
    document.getElementById('delivery_option').addEventListener('change', function() {
        if (this.value === 'pickup') {
            // Isi otomatis dari bisnis
            document.getElementById('shipping_address').value = "{{ $cart->business->address }}";
            document.getElementById('shipping_lat').value = "{{ $cart->business->latitude }}";
            document.getElementById('shipping_lng').value = "{{ $cart->business->longitude }}";
            document.getElementById('shipping_address').setAttribute('readonly', true);
            document.getElementById('address_section').style.display = 'block';

            // Flat ongkir $2 AUD
            document.getElementById('shipping_cost_display').textContent = "$2 AUD (Pickup)";

        } else {
            // Reset untuk input manual
            document.getElementById('shipping_address').value = "";
            document.getElementById('shipping_lat').value = "";
            document.getElementById('shipping_lng').value = "";
            document.getElementById('shipping_address').removeAttribute('readonly');
            document.getElementById('address_section').style.display = 'block';
            document.getElementById('shipping_cost_display').textContent = "-";
        }
    });
</script>

<!-- Google Maps Places API -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
<script>
    function initAutocomplete() {
        const input = document.getElementById('shipping_address');
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();

            document.getElementById('shipping_lat').value = lat;
            document.getElementById('shipping_lng').value = lng;

            // Hitung ongkir ke server
            fetch('{{ route("shipping.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        business_id: '{{ $cart->business_id }}',
                        shipping_lat: lat,
                        shipping_lng: lng
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.delivery_fee !== undefined) {
                        document.getElementById('shipping_cost_display').textContent =
                            `$${data.delivery_fee} AUD (jarak ${data.distance_km} km)`;
                    } else {
                        document.getElementById('shipping_cost_display').textContent = 'Tidak dapat menghitung ongkir';
                    }
                })
                .catch(() => {
                    document.getElementById('shipping_cost_display').textContent = 'Error menghitung ongkir';
                });
        });
    }
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>
@endsection