@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body text-center">
        <h4>Aktivasi Fitur Orders</h4>
        <p>Fitur Orders memungkinkan Anda menerima pesanan langsung dari pelanggan. Ajukan sekarang untuk memulai.</p>
        <form action="{{ route('dashboard.orders.request') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Ajukan Aktivasi Orders</button>
        </form>
    </div>
</div>
@endsection
