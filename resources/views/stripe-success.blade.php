{{-- resources/views/stripe-success.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <title>Payment Success</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>✅ Payment Successful</h1>
    <p>Terima kasih, pembayaran Anda sudah kami terima.</p>

    @if(isset($order))
    <h2>Order #{{ $order->id }}</h2>
    <p>Status: {{ $order->delivery_status }}</p>

    <a href="{{ route('order.success', $order->id) }}">
        Lihat Detail Order
    </a>
    @endif
</body>

</html>