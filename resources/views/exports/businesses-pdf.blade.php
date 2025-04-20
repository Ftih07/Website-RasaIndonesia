<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Business Directory Export</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .page-wrapper {
            padding: 20px;
        }

        .header {
            background-color: #2c78c5;
            /* Blue */
            color: white;
            padding: 25px 40px;
            position: relative;
            margin-bottom: 30px;
            border-radius: 0 0 10px 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            position: relative;
            z-index: 2;
        }

        .header-date {
            position: relative;
            z-index: 2;
            opacity: 0.9;
            font-size: 14px;
            margin-top: 5px;
        }

        .header:after {
            content: '';
            position: absolute;
            right: 40px;
            top: 10px;
            height: 80px;
            width: 80px;
            background-color: #f8b135;
            /* Yellow */
            border-radius: 50%;
            opacity: 0.5;
            z-index: 1;
        }

        .header:before {
            content: '';
            position: absolute;
            right: 80px;
            top: 30px;
            height: 50px;
            width: 50px;
            background-color: #ff7f41;
            /* Orange */
            border-radius: 50%;
            opacity: 0.6;
            z-index: 1;
        }

        .business-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
            page-break-inside: avoid;
            overflow: hidden;
            position: relative;
            border: 1px solid #e0e0e0;
        }

        .business-card:before {
            content: '';
            position: absolute;
            right: -20px;
            bottom: -20px;
            width: 140px;
            height: 140px;
            border-radius: 70px;
            background-color: rgba(248, 177, 53, 0.1);
            /* Yellow with opacity */
            z-index: 0;
        }

        .business-header {
            position: relative;
            padding: 0;
            background-color: #2c78c5;
            /* Blue */
            color: white;
            overflow: hidden;
        }

        .business-header-content {
            display: flex;
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        .business-header:after {
            content: '';
            position: absolute;
            right: -30px;
            top: -10px;
            height: 100px;
            width: 100px;
            background-color: #ff7f41;
            /* Orange */
            border-radius: 50%;
            opacity: 0.2;
            z-index: 1;
        }

        .logo-container {
            width: 90px;
            height: 90px;
            margin-right: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .logo {
            max-width: 85px;
            max-height: 85px;
        }

        .business-title {
            flex-grow: 1;
        }

        .business-name {
            margin: 0 0 8px 0;
            font-size: 22px;
            color: white;
            font-weight: 600;
        }

        .business-type {
            margin: 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            background-color: rgba(0, 0, 0, 0.15);
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
        }

        .business-id {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            margin-top: 8px;
        }

        .section {
            padding: 15px 20px;
            position: relative;
            z-index: 1;
        }

        .section-blue {
            background-color: rgba(44, 120, 197, 0.05);
            /* Very light blue */
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .section-icon {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            background-color: #2c78c5;
            /* Blue */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        .section-title {
            font-weight: 600;
            color: #2c78c5;
            /* Blue */
            font-size: 16px;
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .gallery-item {
            width: 110px;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .gallery-image-container {
            height: 110px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
        }

        .gallery-image {
            max-width: 110px;
            max-height: 110px;
        }

        .gallery-title {
            font-size: 11px;
            padding: 6px;
            text-align: center;
            background-color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-list {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-item {
            padding: 10px 15px;
            border-bottom: 1px dashed #e0e0e0;
        }

        .product-item:nth-child(odd) {
            background-color: rgba(248, 177, 53, 0.05);
            /* Very light yellow */
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-name {
            font-weight: 600;
            color: #333;
        }

        .product-price {
            color: #ff7f41;
            /* Orange */
            font-weight: 500;
        }

        .flex-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col-half {
            width: 50%;
            box-sizing: border-box;
            padding: 0 10px;
        }

        .info-group {
            margin-bottom: 10px;
        }

        .meta-label {
            font-weight: 600;
            margin-right: 5px;
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            display: block;
        }

        .meta-value {
            color: #333;
            background-color: white;
            padding: 5px 10px;
            border-radius: 5px;
            border-left: 3px solid #2c78c5;
            /* Blue */
            display: block;
        }

        .tag {
            display: inline-block;
            background-color: #f8b135;
            /* Yellow */
            border-radius: 15px;
            padding: 3px 10px;
            margin-right: 5px;
            margin-bottom: 5px;
            font-size: 11px;
            color: white;
            font-weight: 500;
        }

        .page-break {
            page-break-after: always;
        }

        .json-content {
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: white;
            border-radius: 5px;
            padding: 10px;
            margin: 0;
            font-family: monospace;
            font-size: 11px;
            border-left: 3px solid #ff7f41;
            /* Orange */
        }

        .contact-icons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .contact-icon {
            width: 30px;
            height: 30px;
            background-color: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2c78c5;
            /* Blue */
            font-weight: bold;
            font-size: 14px;
        }

        .ribbon {
            width: 150px;
            height: 150px;
            overflow: hidden;
            position: absolute;
            top: -10px;
            right: -10px;
            z-index: 2;
        }

        .ribbon-content {
            position: absolute;
            display: block;
            width: 225px;
            padding: 6px 0;
            background-color: #ff7f41;
            /* Orange */
            color: white;
            text-align: center;
            right: -25px;
            top: 30px;
            transform: rotate(45deg);
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e0e0e0, transparent);
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Business Directory</h1>
        <div class="header-date">Generated on {{ date('F j, Y') }}</div>
    </div>

    @foreach ($businesses as $business)
    <div class="page-wrapper">
        <div class="business-card">
            @if($business->unique_code)
            <div class="ribbon">
                <span class="ribbon-content">ID: {{ $business->unique_code }}</span>
            </div>
            @endif

            <div class="business-header">
                <div class="business-header-content">
                    <div class="logo-container">
                        @if ($business->logo)
                        <img class="logo" src="{{ public_path('storage/' . $business->logo) }}" alt="Logo" style="width: 100px; height: auto;">
                        @endif
                    </div>
                    <div class="business-title">
                        <h2 class="business-name">{{ $business->name }}</h2>
                        <div class="business-type">{{ $business->type->title ?? 'No Type' }}</div>
                        <div class="business-id">Business Unique ID: {{ $business->unique_code }}</div>
                        <div class="business-id">ID: {{ $business->id }}</div>
                        <div class="section-title">Business Data Updated On: {{ \Carbon\Carbon::parse($business->updated_at)->format('D F d, Y \a\t gA') }}</div>
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="section-header">
                    <div class="section-icon">i</div>
                    <div class="section-title">Basic Information</div>
                </div>

                <div class="flex-row">
                    <div class="col-half">
                        <div class="info-group">
                            <span class="meta-label">Address</span>
                            <span class="meta-value">{{ $business->address ?: 'Not provided' }}</span>
                        </div>

                        <div class="info-group">
                            <span class="meta-label">Location</span>
                            <span class="meta-value">{{ $business->location ?: 'Not provided' }}</span>
                        </div>
                    </div>

                    <div class="col-half">
                        <div class="info-group">
                            <span class="meta-label">Coordinates</span>
                            <span class="meta-value">{{ ($business->latitude && $business->longitude) ? $business->latitude . ', ' . $business->longitude : 'Not provided' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($business->document)
            <div class="section section-blue">
                <div class="section-header">
                    <div class="section-icon">D</div>
                    <div class="section-title">Document</div>
                </div>
                <div class="meta-value">
                    <a href="{{ asset('storage/' . $business->document) }}" target="_blank">
                        {{ basename($business->document) }}
                    </a>
                </div>
            </div>
            @endif

            @if($business->qrLink && $business->qrLink->qr_path)
            <div class="section section-blue">
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


            <div class="section section-blue">
                <div class="section-header">
                    <div class="section-icon">D</div>
                    <div class="section-title">Description</div>
                </div>
                <div>{{ $business->description ?: 'No description provided' }}</div>
            </div>

            @if(count($business->food_categories) > 0)
            <div class="section">
                <div class="section-header">
                    <div class="section-icon">C</div>
                    <div class="section-title">Food Categories</div>
                </div>
                <div>
                    @foreach($business->food_categories as $category)
                    <span class="tag">{{ $category->title }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if(count($business->products) > 0)
            <div class="section section-blue">
                <div class="section-header">
                    <div class="section-icon">P</div>
                    <div class="section-title">Products</div>
                </div>
                <div class="product-list">
                    @foreach($business->products as $product)
                    <div class="product-item">
                        <span class="product-name">{{ $product->name }}</span> -
                        <span class="product-price">{{ $product->price }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($business->open_hours)
            <div class="section">
                <div class="section-header">
                    <div class="section-icon">T</div>
                    <div class="section-title">Opening Hours</div>
                </div>
                <pre class="json-content">{{ is_string($business->open_hours) ? json_encode(json_decode($business->open_hours), JSON_PRETTY_PRINT) : json_encode($business->open_hours, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif

            @if($business->contact)
            <div class="section section-blue">
                <div class="section-header">
                    <div class="section-icon">C</div>
                    <div class="section-title">Contact Information</div>
                </div>
                <pre class="json-content">{{ is_string($business->contact) ? json_encode(json_decode($business->contact), JSON_PRETTY_PRINT) : json_encode($business->contact, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif

            @if($business->media_social)
            <div class="section">
                <div class="section-header">
                    <div class="section-icon">S</div>
                    <div class="section-title">Social Media</div>
                </div>
                <pre class="json-content">{{ is_string($business->media_social) ? json_encode(json_decode($business->media_social), JSON_PRETTY_PRINT) : json_encode($business->media_social, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif

            @if($business->services)
            <div class="section section-blue">
                <div class="section-header">
                    <div class="section-icon">S</div>
                    <div class="section-title">Services</div>
                </div>
                <pre class="json-content">{{ is_string($business->services) ? json_encode(json_decode($business->services), JSON_PRETTY_PRINT) : json_encode($business->services, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif

            @if($business->order)
            <div class="section">
                <div class="section-header">
                    <div class="section-icon">O</div>
                    <div class="section-title">Order Information</div>
                </div>
                <pre class="json-content">{{ is_string($business->order) ? json_encode(json_decode($business->order), JSON_PRETTY_PRINT) : json_encode($business->order, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif

            @if($business->reserve)
            <div class="section section-blue">
                <div class="section-header">
                    <div class="section-icon">R</div>
                    <div class="section-title">Reservation Information</div>
                </div>
                <pre class="json-content">{{ is_string($business->reserve) ? json_encode(json_decode($business->reserve), JSON_PRETTY_PRINT) : json_encode($business->reserve, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif

            @if($business->iframe_url)
            <div class="section">
                <div class="section-header">
                    <div class="section-icon">I</div>
                    <div class="section-title">Iframe URL</div>
                </div>
                <div class="meta-value">{{ $business->iframe_url }}</div>
            </div>
            @endif

            @if($business->menu)
            <div class="section section-blue">
                <div class="section-header">
                    <div class="section-icon">M</div>
                    <div class="section-title">Menu</div>
                </div>
                <div class="meta-value">{{ $business->menu }}</div>
            </div>
            @endif

            @if(count($business->galleries) > 0)
            <div class="section">
                <div class="section-header">
                    <div class="section-icon">G</div>
                    <div class="section-title">Gallery</div>
                </div>
                <div class="gallery-container">
                    @foreach($business->galleries as $gallery)
                    <div class="gallery-item">
                        <div class="gallery-image-container">
                            @if($gallery->image)
                            <img class="gallery-image" src="{{ public_path('storage/' . $gallery->image) }}" alt="Gallery">
                            @endif
                        </div>
                        <div class="gallery-title">{{ $gallery->title }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    @if(!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>

</html>