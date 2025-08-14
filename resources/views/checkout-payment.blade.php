@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f7f7f7;
    }

    .checkout-wrapper {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-wrap: wrap;
    }

    .checkout-summary {
        flex: 1 1 50%;
        background: #fafafa;
        padding: 24px;
        border-right: 1px solid #eee;
    }

    .checkout-summary h4 {
        margin-bottom: 16px;
        font-weight: 600;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .summary-item strong {
        font-size: 15px;
    }

    .checkout-payment {
        flex: 1 1 50%;
        padding: 24px;
    }

    #submit {
        background: #00b86b;
        color: #fff;
        font-weight: 600;
        padding: 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
    }

    #submit:hover {
        background: #00a35f;
    }
</style>

<div class="checkout-wrapper">
    {{-- Summary --}}
    <div class="checkout-summary">
        <h4>Order Summary</h4>
        @foreach($order->items as $item)
        <div class="summary-item">
            <div>
                <strong>{{ $item->product->name }}</strong>
                <div style="font-size: 12px; color: #555;">
                    Qty {{ $item->quantity }} × A${{ number_format($item->unit_price, 2) }}
                </div>
            </div>
            <span>A${{ number_format($item->total_price, 2) }}</span>
        </div>
        @endforeach

        <div class="summary-item">
            <span>Subtotal</span>
            <span>A${{ number_format($order->items->sum('total_price'), 2) }}</span>
        </div>
        <div class="summary-item">
            <span>Delivery Fee</span>
            <span>A${{ number_format($order->delivery_fee, 2) }}</span>
        </div>
        <div class="summary-item">
            <span>Service Fee</span>
            <span>A${{ number_format($order->order_fee, 2) }}</span>
        </div>
        <div class="summary-item">
            <span>Gross Value (before Stripe fee)</span>
            <span>A${{ number_format($order->total_price, 2) }}</span>
        </div>
        <hr>
        <div class="summary-item" style="font-size: 16px; font-weight: bold;">
            <span>Total to Pay</span>
            <span>A${{ number_format($order->gross_price, 2) }}</span>
        </div>
    </div>


    {{-- Payment --}}
    <div class="checkout-payment">
        <h4>Payment Details</h4>
        <div id="payment-element" style="margin-bottom: 20px;"></div>
        <button id="submit">Pay A${{ number_format($order->gross_price, 2) }}</button>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const options = {
        clientSecret: "{{ $clientSecret }}"
    };

    const elements = stripe.elements(options);
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    document.getElementById('submit').addEventListener('click', async () => {
        const {
            error
        } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: "{{ route('order.success', $order) }}",
            },
        });
        if (error) {
            alert(error.message);
        }
    });
</script>
@endsection