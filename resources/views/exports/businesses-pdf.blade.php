<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Business Directory Export</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #2c3e50;
        }

        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }

        .business-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            page-break-inside: avoid;
            overflow: hidden;
        }

        .business-header {
            display: flex;
            padding: 15px;
            background-color: #f5f7fa;
            border-bottom: 1px solid #eaeaea;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
        }

        .logo {
            max-width: 80px;
            max-height: 80px;
        }

        .business-title {
            flex-grow: 1;
        }

        .business-name {
            margin: 0 0 5px 0;
            font-size: 18px;
            color: #2c3e50;
        }

        .business-type {
            margin: 0;
            color: #7f8c8d;
            font-size: 14px;
        }

        .business-id {
            color: #95a5a6;
            font-size: 11px;
            margin-top: 5px;
        }

        .section {
            padding: 12px 15px;
            border-bottom: 1px solid #eaeaea;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
            color: #34495e;
            font-size: 18px;
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .gallery-item {
            width: 100px;
            margin-bottom: 10px;
        }

        .gallery-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 4px;
        }

        .gallery-title {
            font-size: 11px;
            margin-top: 3px;
            text-align: center;
        }

        .product-item {
            padding: 5px 0;
            border-bottom: 1px dotted #eaeaea;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .flex-row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-half {
            width: 50%;
            box-sizing: border-box;
            padding-right: 10px;
        }

        .meta-label {
            font-weight: bold;
            margin-right: 5px;
            color: #7f8c8d;
        }

        .meta-value {
            color: #333;
        }

        .tag {
            display: inline-block;
            background-color: #ecf0f1;
            border-radius: 3px;
            padding: 2px 6px;
            margin-right: 5px;
            margin-bottom: 5px;
            font-size: 11px;
            color: #7f8c8d;
        }

        .page-break {
            page-break-after: always;
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: #f9f9f9;
            border-radius: 3px;
            padding: 8px;
            margin: 0;
            font-family: monospace;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Business Directory Export</h1>
        <div>Generated on {{ date('F j, Y') }}</div>
    </div>

    @foreach ($businesses as $business)
    <div class="business-card">
        <div class="business-header">
            <div class="logo-container">
                @if ($business->logo)
                <img class="logo" src="{{ public_path('storage/' . $business->logo) }}" alt="Logo">
                @endif
            </div>
            <div class="business-title">
                <h2 class="business-name">{{ $business->name }}</h2>
                <div class="business-type">{{ $business->type->title ?? 'No Type' }}</div>
                <div class="business-id">ID: {{ $business->id }} | Code: {{ $business->unique_code }}</div>
                <p>Business Data Updated On: {{ \Carbon\Carbon::parse($business->updated_at)->format('D F d, Y \a\t gA') }}</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Basic Information</div>
            <div class="flex-row">
                <div class="col-half">
                    <div><span class="meta-label">Address:</span> <span class="meta-value">{{ $business->address }}</span></div>
                    <div><span class="meta-label">Location:</span> <span class="meta-value">{{ $business->location }}</span></div>
                    <div><span class="meta-label">Coordinates:</span> <span class="meta-value">{{ $business->latitude }}, {{ $business->longitude }}</span></div>
                </div>
                <div class="col-half">
                    @if($business->document)
                    <div><span class="meta-label">Business Unique Sticker:</span>
                        <a href="{{ asset('storage/' . $business->document) }}" target="_blank">
                            {{ basename($business->document) }}
                        </a>
                    </div>
                    @else
                    <div><span class="meta-label">Document:</span> None</div>
                    @endif
                </div>
            </div>
        </div>

        @if($business->qrLink && $business->qrLink->qr_path)
        <div class="section">
            <div class="section-title">QR Link</div>
            <div style="border:1px solid #ccc;padding:10px;display:inline-block;">
                <img src="{{ public_path('storage/' . $business->qrLink->qr_path) }}" style="width:100px;">
                <br>
                <small>{{ asset('storage/' . $business->qrLink->qr_path) }}</small>
            </div>
        </div>
        @else
        <div><span class="meta-label">QR Link:</span> <span class="meta-value">None</span></div>
        @endif

        <div class="section">
            <div class="section-title">Description</div>
            <div>{{ $business->description }}</div>
        </div>

        @if(count($business->food_categories) > 0)
        <div class="section">
            <div class="section-title">Food Categories</div>
            <div>
                @foreach($business->food_categories as $category)
                <span class="tag">{{ $category->title }}</span>
                @endforeach
            </div>
        </div>
        @endif

        @if($business->open_hours)
        <div class="section">
            <div class="section-title">Opening Hours</div>
            <pre>{{ is_string($business->open_hours) ? json_encode(json_decode($business->open_hours), JSON_PRETTY_PRINT) : json_encode($business->open_hours, JSON_PRETTY_PRINT) }}</pre>
        </div>
        @endif

        @if($business->contact)
        <div class="section">
            <div class="section-title">Contact Information</div>
            <pre>{{ is_string($business->contact) ? json_encode(json_decode($business->contact), JSON_PRETTY_PRINT) : json_encode($business->contact, JSON_PRETTY_PRINT) }}</pre>
        </div>
        @endif

        @if($business->media_social)
        <div class="section">
            <div class="section-title">Social Media</div>
            <pre>{{ is_string($business->media_social) ? json_encode(json_decode($business->media_social), JSON_PRETTY_PRINT) : json_encode($business->media_social, JSON_PRETTY_PRINT) }}</pre>
        </div>
        @endif

        @if($business->services)
        <div class="section">
            <div class="section-title">Services</div>
            <pre>{{ is_string($business->services) ? json_encode(json_decode($business->services), JSON_PRETTY_PRINT) : json_encode($business->services, JSON_PRETTY_PRINT) }}</pre>
        </div>
        @endif

        @if($business->order)
        <div class="section">
            <div class="section-title">Order Information</div>
            <pre>{{ is_string($business->order) ? json_encode(json_decode($business->order), JSON_PRETTY_PRINT) : json_encode($business->order, JSON_PRETTY_PRINT) }}</pre>
        </div>
        @endif

        @if($business->reserve)
        <div class="section">
            <div class="section-title">Reservation Information</div>
            <pre>{{ is_string($business->reserve) ? json_encode(json_decode($business->reserve), JSON_PRETTY_PRINT) : json_encode($business->reserve, JSON_PRETTY_PRINT) }}</pre>
        </div>
        @endif

        @if($business->iframe_url)
        <div class="section">
            <div class="section-title">Iframe URL</div>
            <div>{{ $business->iframe_url }}</div>
        </div>
        @endif

        @if($business->menu)
        <div class="section">
            <div class="section-title">Menu</div>
            <div>{{ $business->menu }}</div>
        </div>
        @endif

        @if(count($business->products) > 0)
        <div class="section">
            <div class="section-title">Products</div>
            @foreach($business->products as $product)
            <div class="product-item">
                <strong>{{ $product->name }}</strong> - {{ $product->price }}
            </div>
            @endforeach
        </div>
        @endif

        @if(count($business->galleries) > 0)
        <div class="section">
            <div class="section-title">Gallery</div>
            <div class="gallery-container">
                @foreach($business->galleries as $gallery)
                <div class="gallery-item">
                    @if($gallery->image)
                    <img class="gallery-image" src="{{ public_path('storage/' . $gallery->image) }}" alt="Gallery">
                    @endif
                    <div class="gallery-title">{{ $gallery->title }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @if(!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>

</html>