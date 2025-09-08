<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Header Styles */
        .invoice-header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .invoice-subtitle {
            font-size: 12px;
            color: #666;
            margin: 5px 0 0 0;
        }

        /* Layout Styles */
        .row {
            width: 100%;
            margin-bottom: 15px;
        }

        .row::after {
            content: "";
            display: table;
            clear: both;
        }

        .col-left {
            float: left;
            width: 60%;
        }

        .col-right {
            float: right;
            width: 35%;
            text-align: right;
        }

        /* Info Boxes */
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .info-title {
            font-weight: bold;
            color: #1e40af;
            font-size: 12px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .info-content {
            color: #374151;
            line-height: 1.5;
        }

        /* Invoice Details */
        .invoice-details {
            background: #2563eb;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .invoice-details .detail-item {
            margin-bottom: 3px;
        }

        .invoice-details .detail-label {
            font-weight: bold;
            display: inline-block;
            width: 70px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .status-failed {
            background: #fecaca;
            color: #991b1b;
        }

        /* Delivery Note */
        .delivery-note {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 10px;
            margin: 15px 0;
        }

        .delivery-note .note-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 3px;
        }

        /* Section Headers */
        .section-header {
            background: #1f2937;
            color: white;
            padding: 8px 12px;
            margin: 20px 0 0 0;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        .items-table th {
            background: #374151;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 8px 5px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .items-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-center {
            text-align: center;
        }

        /* Item Options */
        .item-options {
            font-size: 8px;
            color: #6b7280;
            margin-top: 3px;
            font-style: italic;
        }

        .item-notes {
            font-size: 8px;
            color: #4b5563;
            margin-top: 2px;
        }

        /* Summary Table */
        .summary-table {
            width: 50%;
            float: right;
            margin-top: 20px;
        }

        .summary-table td {
            padding: 5px 8px;
            border: none;
        }

        .summary-table .label {
            text-align: left;
            color: #374151;
        }

        .summary-table .value {
            text-align: right;
            font-weight: bold;
            color: #1f2937;
        }

        .summary-table .total-row {
            border-top: 2px solid #2563eb;
            background: #eff6ff;
        }

        .summary-table .total-row td {
            font-size: 12px;
            font-weight: bold;
            color: #1e40af;
            padding: 8px;
        }

        /* Weight Summary Box */
        .weight-summary {
            background: #ecfdf5;
            border: 1px solid #10b981;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            width: 45%;
            float: left;
        }

        .weight-summary h4 {
            color: #047857;
            margin: 0 0 8px 0;
            font-size: 11px;
            text-transform: uppercase;
        }

        .weight-item {
            display: block;
            margin-bottom: 3px;
            font-size: 10px;
        }

        .weight-label {
            display: inline-block;
            width: 120px;
        }

        .weight-value {
            font-weight: bold;
            color: #065f46;
        }

        /* Footer */
        .invoice-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            color: #6b7280;
            font-style: italic;
        }

        /* Utility Classes */
        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-15 {
            margin-bottom: 15px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-blue {
            color: #2563eb;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Print Optimizations */
        @media print {
            .invoice-header {
                border-bottom-width: 2px;
            }

            .section-header {
                background: #000 !important;
                -webkit-print-color-adjust: exact;
            }

            .items-table th {
                background: #000 !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <h1 class="invoice-title">Invoice</h1>
            <p class="invoice-subtitle">Taste of Indonesia Invoice</p>
        </div>

        <!-- Business and Invoice Info -->
        <div class="row clearfix">
            <div class="col-left">
                <div class="info-box">
                    <div class="info-title">From</div>
                    <div class="info-content">
                        <strong>{{ $order->business->name ?? 'Business Name' }}</strong><br>
                        {{ $order->business->address ?? 'Business Address' }}<br>
                        @if(isset($order->business->phone))
                        Phone: {{ $order->business->phone }}<br>
                        @endif
                        @if(isset($order->business->email))
                        Email: {{ $order->business->email }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-right">
                <div class="invoice-details">
                    <div class="detail-item">
                        <span class="detail-label">Invoice#:</span>
                        <span>{{ $order->order_number }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Date:</span>
                        <span>{{ ($order->created_at ?? now())->format('d M Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Time:</span>
                        <span>{{ ($order->created_at ?? now())->format('H:i') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Delivery:</span>
                        <span>{{ ucfirst($order->delivery_option) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bill To and Status -->
        <div class="row clearfix">
            <div class="col-left">
                <div class="info-box">
                    <div class="info-title">Bill To</div>
                    <div class="info-content">
                        <strong>{{ $order->user->name ?? 'Customer Name' }}</strong><br>
                        {{ $order->shipping_address ?? 'Shipping Address' }}
                        @if(isset($order->user->phone))
                        <br>Phone: {{ $order->user->phone }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Note -->
        @if($order->delivery_note)
        <div class="delivery-note">
            <div class="note-title">Delivery Instructions</div>
            <div>{{ $order->delivery_note }}</div>
        </div>
        @endif

        <!-- Items Section -->
        <div class="section-header">Order Items</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:25%;">Product</th>
                    <th style="width:8%;" class="text-center">Qty</th>
                    <th style="width:12%;" class="text-right">Unit Price</th>
                    <th style="width:12%;" class="text-right">Total</th>
                    <th style="width:10%;" class="text-right">Weight</th>
                    <th style="width:10%;" class="text-right">Vol. Wt</th>
                    <th style="width:13%;">Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product->name ?? 'Item' }}</strong>
                        @if(!empty($item->options))
                        <div class="item-options">
                            @foreach((array) $item->options as $group)
                            @if(!empty($group['items']))
                            <div>{{ $group['label'] ?? 'Options' }}:
                                {{ collect($group['items'])->pluck('name')->implode(', ') }}
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right"><strong>${{ number_format($item->total_price, 2) }}</strong></td>
                    <td class="text-right">{{ number_format($item->weight_actual, 2) }} kg</td>
                    <td class="text-right">{{ number_format($item->weight_volumetric, 2) }} kg</td>
                    <td>
                        @if($item->note)
                        <div class="item-notes"><strong>Note:</strong> {{ $item->note }}</div>
                        @endif
                        @if($item->preference_if_unavailable)
                        <div class="item-notes"><strong>Preference:</strong> {{ $item->preference_if_unavailable }}</div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Weight Summary and Totals -->
        <div class="clearfix mt-20">
            <div class="weight-summary">
                <h4>Shipping Details</h4>
                <span class="weight-item">
                    <span class="weight-label">Total Weight:</span>
                    <span class="weight-value">{{ number_format($order->total_weight_actual, 2) }} kg</span>
                </span>
                <span class="weight-item">
                    <span class="weight-label">Total Volume:</span>
                    <span class="weight-value">{{ number_format($order->total_volume, 2) }} m³</span>
                </span>
                <span class="weight-item">
                    <span class="weight-label">Volumetric Weight:</span>
                    <span class="weight-value">{{ number_format($order->total_weight_volumetric, 2) }} kg</span>
                </span>
                <span class="weight-item">
                    <span class="weight-label">Chargeable Weight:</span>
                    <span class="weight-value">{{ number_format($order->chargeable_weight, 2) }} kg</span>
                </span>
            </div>

            <table class="summary-table">
                <tr>
                    <td class="label">Subtotal:</td>
                    <td class="value">${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Delivery Fee:</td>
                    <td class="value">${{ number_format($order->delivery_fee, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Shipping Cost:</td>
                    <td class="value">${{ number_format($order->shipping_cost, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Order Fee:</td>
                    <td class="value">${{ number_format($order->order_fee, 2) }}</td>
                </tr>
                <tr>
                    <td class="label">Tax:</td>
                    <td class="value">${{ number_format($order->tax, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="label">TOTAL:</td>
                    <td class="value">${{ number_format($order->total_price, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="clearfix"></div>

        <!-- Footer -->
        <div class="invoice-footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>If you have any questions about this invoice, please contact us.</p>
        </div>
    </div>
</body>

</html>