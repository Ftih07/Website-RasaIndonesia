@extends('layouts.app')

@section('content')
<h4>Shipping Settings</h4>
<p>Atur ongkir untuk bisnis Anda.</p>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-2 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('dashboard.orders.shipping.update') }}">
    @csrf
    @method('PATCH')

    {{-- Shipping type --}}
    <label class="block mt-4">Shipping Type</label>
    <select name="shipping_type" class="border rounded px-3 py-2 w-full">
        <option value="flat" {{ $business->shipping_type === 'flat' ? 'selected' : '' }}>Flat Rate</option>
        <option value="per_km" {{ $business->shipping_type === 'per_km' ? 'selected' : '' }}>Per Km</option>
        <option value="flat_plus_per_km" {{ $business->shipping_type === 'flat_plus_per_km' ? 'selected' : '' }}>Flat + Per Km</option>
    </select>

    {{-- Flat rate --}}
    <div id="flat-rate-field" class="mt-4" style="display: none;">
        <label>Flat Rate (AUD)</label>
        <input type="number" step="0.01" name="flat_rate" value="{{ old('flat_rate', $business->flat_rate) }}"
            class="border rounded px-3 py-2 w-full">
    </div>

    {{-- Per km rate --}}
    <div id="per-km-field" class="mt-4" style="display: none;">
        <label>Rate per Unit Distance (AUD)</label>
        <input type="number" step="0.01" name="per_km_rate" value="{{ old('per_km_rate', $business->per_km_rate) }}"
            class="border rounded px-3 py-2 w-full">

        <label class="mt-2 block">Distance Unit (km)</label>
        <input type="number" name="per_km_unit" value="{{ old('per_km_unit', $business->per_km_unit) }}"
            class="border rounded px-3 py-2 w-full" min="1">
        <small class="text-gray-500">Contoh: isi 2 berarti tiap 2 km dihitung 1 unit ongkir.</small>
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-6">
        Simpan
    </button>
</form>

<script>
    function toggleFields() {
        const type = document.querySelector('[name="shipping_type"]').value;
        document.getElementById('flat-rate-field').style.display = (type === 'flat' || type === 'flat_plus_per_km') ? 'block' : 'none';
        document.getElementById('per-km-field').style.display = (type === 'per_km' || type === 'flat_plus_per_km') ? 'block' : 'none';
    }
    document.querySelector('[name="shipping_type"]').addEventListener('change', toggleFields);
    window.onload = toggleFields;
</script>
@endsection
