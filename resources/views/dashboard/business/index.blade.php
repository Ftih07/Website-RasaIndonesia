<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Dashboard - Taste of Indonesia</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        :root {
            --primary-orange: #ff6b35;
            --secondary-orange: #ffa500;
            --accent-yellow: #ffd700;
            --light-gray: #f8f9fa;
            --border-color: #e9ecef;
        }
        
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .form-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }
        
        .form-section-header {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            padding: 1.5rem;
            border-radius: 12px 12px 0 0;
            margin: -1px -1px 0 -1px;
        }
        
        .form-section-body {
            padding: 2rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
        }
        
        .btn-outline-danger {
            border: 2px solid #dc3545;
            color: #dc3545;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .btn-outline-success {
            border: 2px solid #28a745;
            color: #28a745;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .repeater-item {
            background: var(--light-gray);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
        }
        
        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .admin-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
        
        .current-file {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            padding: 0.75rem;
            border-radius: 6px;
            margin-top: 0.5rem;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background: var(--light-gray);
            border: 2px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .checkbox-item:hover {
            border-color: var(--primary-orange);
            background: #fff5f2;
        }
        
        .checkbox-item input[type="checkbox"] {
            margin-right: 0.5rem;
            accent-color: var(--primary-orange);
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
            padding: 3rem 0;
            margin-bottom: 3rem;
            border-radius: 0 0 20px 20px;
        }
        
        .operating-hours-item {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .operating-hours-item input {
            flex: 1;
        }
        
        @media (max-width: 768px) {
            .form-section-body {
                padding: 1rem;
            }
            
            .operating-hours-item {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .operating-hours-item input {
                width: 100%;
            }
            
            .btn-primary {
                width: 100%;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    @include('dashboard.partials.navbar')

    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-5 fw-bold mb-2">
                        <i class="fas fa-store me-3"></i>Business Dashboard
                    </h1>
                    <p class="lead mb-0">Manage your restaurant information on Taste of Indonesia</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <form action="{{ route('dashboard.business.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Basic Information
                    </h3>
                </div>
                <div class="form-section-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Business Type</label>
                            <select name="type_id" class="form-select" required>
                                @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ $business->type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unique Code</label>
                            <input type="text" name="unique_code" class="form-control" 
                                   value="{{ $business->unique_code }}" disabled>
                            <div class="admin-notice">
                                <i class="fas fa-lock me-2"></i>Only Taste of Indonesia admin can modify this unique code
                            </div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">Business Name</label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ $business->name }}" required>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">Food Categories</label>
                            <select id="food-categories" name="food_categories[]" class="form-select" multiple>
                                @foreach($foodCategories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ in_array($category->id, $business->food_categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple categories</small>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ $business->description }}</textarea>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">Business Logo</label>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            @if($business->logo)
                            <div class="current-file mt-2">
                                <img src="{{ asset('storage/' . $business->logo) }}" alt="Current Logo" 
                                     class="img-thumbnail" style="max-width: 100px;">
                                <small class="d-block text-muted mt-1">Current logo</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location & Contact -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Location & Contact
                    </h3>
                </div>
                <div class="form-section-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" 
                                   value="{{ $business->country }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" 
                                   value="{{ $business->city }}">
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">Full Address</label>
                            <textarea name="address" class="form-control" rows="3">{{ $business->address }}</textarea>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Google Maps Link</label>
                            <input type="url" name="location" class="form-control" 
                                   value="{{ $business->location }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Iframe Embed URL</label>
                            <input type="url" name="iframe_url" class="form-control" 
                                   value="{{ $business->iframe_url }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" class="form-control" 
                                   value="{{ $business->latitude }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" class="form-control" 
                                   value="{{ $business->longitude }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-phone me-2"></i>Contact Information
                    </h3>
                </div>
                <div class="form-section-body">
                    <div id="contact-container">
                        @php
                        $contacts = old('contact', $business->contact ?? [['type' => 'email', 'details' => '']]);
                        @endphp
                        @foreach($contacts as $index => $contact)
                        <div class="repeater-item">
                            <h5>Contact {{ $index + 1 }}</h5>
                            @if($index > 0)
                            <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeContact(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Contact Type</label>
                                    <select name="contact[{{ $index }}][type]" class="form-select" required>
                                        <option value="email" {{ ($contact['type'] ?? '') == 'email' ? 'selected' : '' }}>Email</option>
                                        <option value="wa" {{ ($contact['type'] ?? '') == 'wa' ? 'selected' : '' }}>WhatsApp</option>
                                        <option value="telp" {{ ($contact['type'] ?? '') == 'telp' ? 'selected' : '' }}>Telephone</option>
                                        <option value="telegram" {{ ($contact['type'] ?? '') == 'telegram' ? 'selected' : '' }}>Telegram</option>
                                    </select>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Contact Details</label>
                                    <input type="text" name="contact[{{ $index }}][details]" 
                                           class="form-control" value="{{ $contact['details'] ?? '' }}" 
                                           required placeholder="Enter contact information">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-success" onclick="addContact()">
                        <i class="fas fa-plus me-2"></i>Add Contact
                    </button>
                </div>
            </div>

            <!-- Business Operations -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-business-time me-2"></i>Business Operations
                    </h3>
                </div>
                <div class="form-section-body">
                    <!-- Operating Hours -->
                    <div class="mb-4">
                        <label class="form-label">Operating Hours</label>
                        <div id="operating-hours-container">
                            @php
                            $open_hours = old('open_hours_keys', array_keys($business->open_hours ?? []));
                            $open_hours_values = old('open_hours_values', array_values($business->open_hours ?? []));
                            @endphp
                            @foreach ($open_hours as $index => $day)
                            <div class="operating-hours-item">
                                <input type="text" name="open_hours_keys[]" class="form-control" 
                                       value="{{ $day }}" placeholder="Day(s)" required>
                                <input type="text" name="open_hours_values[]" class="form-control" 
                                       value="{{ $open_hours_values[$index] ?? '' }}" placeholder="Hours" required>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeOperatingHour(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm mt-2" onclick="addOperatingHour()">
                            <i class="fas fa-plus me-2"></i>Add Operating Hour
                        </button>
                        <small class="d-block text-muted mt-2">Example: Monday => 08.00 - 17.00</small>
                    </div>

                    <!-- Services -->
                    <div class="mb-4">
                        <label class="form-label">Available Services</label>
                        <div class="services-grid">
                            @php $services = $business->services ?? []; @endphp
                            <label class="checkbox-item">
                                <input type="checkbox" name="services[]" value="Dine In" 
                                       {{ in_array('Dine In', $services) ? 'checked' : '' }}>
                                <i class="fas fa-utensils me-2"></i>Dine In
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="services[]" value="Delivery" 
                                       {{ in_array('Delivery', $services) ? 'checked' : '' }}>
                                <i class="fas fa-motorcycle me-2"></i>Delivery
                            </label>
                        </div>
                    </div>

                    <!-- Menu Upload -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Menu List (PDF or Images)</label>
                            <input type="file" name="menu" class="form-control" accept=".pdf,image/*">
                            @if($business->menu)
                            <div class="current-file mt-2">
                                <a href="{{ asset('storage/' . $business->menu) }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-file me-2"></i>View Current Menu
                                </a>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Business Sticker (PDF)</label>
                            <input type="file" name="document" class="form-control" accept=".pdf" disabled>
                            <div class="admin-notice">
                                <i class="fas fa-lock me-2"></i>Only Taste of Indonesia admin can upload or edit this document
                            </div>
                            @if($business->document)
                            <div class="current-file mt-2">
                                <a href="{{ asset('storage/' . $business->document) }}" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-file-pdf me-2"></i>View Current Document
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code & External Links -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-qrcode me-2"></i>QR Code Business
                    </h3>
                </div>
                <div class="form-section-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">QR Code</label>
                            <select name="qr_link_id" class="form-select" disabled>
                                <option value="">-- Select QR Code --</option>
                                @foreach($qrLinks as $qr)
                                <option value="{{ $qr->id }}" {{ $business->qr_link_id == $qr->id ? 'selected' : '' }}>
                                    {{ $qr->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="admin-notice">
                                <i class="fas fa-lock me-2"></i>Only Taste of Indonesia admin can select QR Code
                            </div>
                        </div>
                        
                        @if($business->qrLink && $business->qrLink->qr_path)
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Current QR Code</label>
                            <div class="current-file">
                                <img src="{{ asset('storage/' . $business->qrLink->qr_path) }}" 
                                     class="img-thumbnail" style="max-width: 150px;">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Platforms -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>Order Platforms
                    </h3>
                </div>
                <div class="form-section-body">
                    <div id="order-container">
                        @php $orders = old('order', $business->order ?? []); @endphp
                        @foreach($orders as $i => $order)
                        <div class="repeater-item">
                            <h5>Order Platform {{ $i + 1 }}</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeRepeater(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Platform</label>
                                    <select name="order[{{ $i }}][platform]" class="form-select">
                                        <option value="Menulog" {{ ($order['platform'] ?? '') === 'Menulog' ? 'selected' : '' }}>Menulog</option>
                                        <option value="DoorDash" {{ ($order['platform'] ?? '') === 'DoorDash' ? 'selected' : '' }}>DoorDash</option>
                                        <option value="UberEAST" {{ ($order['platform'] ?? '') === 'UberEAST' ? 'selected' : '' }}>UberEAST</option>
                                        <option value="Abacus" {{ ($order['platform'] ?? '') === 'Abacus' ? 'selected' : '' }}>Abacus</option>
                                        <option value="Fantuan" {{ ($order['platform'] ?? '') === 'Fantuan' ? 'selected' : '' }}>Fantuan</option>
                                        <option value="Website" {{ ($order['platform'] ?? '') === 'Website' ? 'selected' : '' }}>Website</option>
                                        <option value="HungryPanda" {{ ($order['platform'] ?? '') === 'HungryPanda' ? 'selected' : '' }}>HungryPanda</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Link</label>
                                    <input type="url" name="order[{{ $i }}][link]" class="form-control" 
                                           value="{{ $order['link'] ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Display Name</label>
                                    <input type="text" name="order[{{ $i }}][name]" class="form-control" 
                                           value="{{ $order['name'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-success" onclick="addRepeater('order')">
                        <i class="fas fa-plus me-2"></i>Add Order Platform
                    </button>
                </div>
            </div>

            <!-- Reservation Platforms -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Reservation Platforms
                    </h3>
                </div>
                <div class="form-section-body">
                    <div id="reserve-container">
                        @php $reserves = old('reserve', $business->reserve ?? []); @endphp
                        @foreach($reserves as $i => $res)
                        <div class="repeater-item">
                            <h5>Reservation Platform {{ $i + 1 }}</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeRepeater(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Platform</label>
                                    <select name="reserve[{{ $i }}][platform]" class="form-select">
                                        <option value="OpenTable" {{ ($res['platform'] ?? '') === 'OpenTable' ? 'selected' : '' }}>OpenTable</option>
                                        <option value="Quandoo" {{ ($res['platform'] ?? '') === 'Quandoo' ? 'selected' : '' }}>Quandoo</option>
                                        <option value="Website" {{ ($res['platform'] ?? '') === 'Website' ? 'selected' : '' }}>Website</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Link</label>
                                    <input type="url" name="reserve[{{ $i }}][link]" class="form-control" 
                                           value="{{ $res['link'] ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Display Name</label>
                                    <input type="text" name="reserve[{{ $i }}][name]" class="form-control" 
                                           value="{{ $res['name'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-success" onclick="addRepeater('reserve')">
                        <i class="fas fa-plus me-2"></i>Add Reservation Platform
                    </button>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-share-alt me-2"></i>Social Media Links
                    </h3>
                </div>
                <div class="form-section-body">
                    <div id="media_social-container">
                        @php $medias = old('media_social', $business->media_social ?? []); @endphp
                        @foreach($medias as $i => $media)
                        <div class="repeater-item">
                            <h5>Social Media {{ $i + 1 }}</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeRepeater(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Platform</label>
                                    <select name="media_social[{{ $i }}][platform]" class="form-select">
                                        <option value="website" {{ ($media['platform'] ?? '') === 'website' ? 'selected' : '' }}>Website</option>
                                        <option value="instagram" {{ ($media['platform'] ?? '') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                                        <option value="facebook" {{ ($media['platform'] ?? '') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                                        <option value="twitter" {{ ($media['platform'] ?? '') === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                        <option value="tiktok" {{ ($media['platform'] ?? '') === 'tiktok' ? 'selected' : '' }}>TikTok</option>
                                        <option value="youtube" {{ ($media['platform'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Link</label>
                                    <input type="url" name="media_social[{{ $i }}][link]" class="form-control" 
                                           value="{{ $media['link'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-success" onclick="addRepeater('media_social')">
                        <i class="fas fa-plus me-2"></i>Add Social Media
                    </button>
                </div>
            </div>

            <!-- Image Gallery -->
            <div class="form-section">
                <div class="form-section-header">
                    <h3 class="mb-0">
                        <i class="fas fa-images me-2"></i>Image Gallery
                    </h3>
                </div>
                <div class="form-section-body">
                    <div id="gallery-container">
                        @php
                        $galleries = old('gallery_data', $business->galleries->map(function ($g) {
                            return ['id' => $g->id, 'title' => $g->title];
                        })->toArray());
                        @endphp
                        @foreach ($galleries as $i => $gallery)
                        <div class="repeater-item" data-existing-id="{{ $gallery['id'] ?? '' }}">
                            <h5>Image {{ $i + 1 }}</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeRepeater(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            <input type="hidden" name="gallery_data[{{ $i }}][id]" value="{{ $gallery['id'] ?? '' }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="gallery_data[{{ $i }}][title]" class="form-control" 
                                           value="{{ $gallery['title'] ?? '' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Upload New Image (optional)</label>
                                    <input type="file" name="gallery_data[{{ $i }}][image]" class="form-control" accept="image/*">
                                </div>
                            </div>
                            @if (!empty($gallery['id']))
                            @php
                            $galleryModel = $business->galleries->firstWhere('id', $gallery['id']);
                            @endphp
                            @if ($galleryModel && $galleryModel->image)
                            <div class="current-file">
                                <img src="{{ asset('storage/' . $galleryModel->image) }}" alt="{{ $galleryModel->title }}" 
                                     class="img-thumbnail" style="max-width: 120px;">
                                <small class="d-block text-muted mt-1">Current image: {{ $galleryModel->title }}</small>
                            </div>
                            @endif
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-success" onclick="addGalleryRepeater()">
                        <i class="fas fa-plus me-2"></i>Add Image
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i>Update Business Information
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect('#food-categories', {
            plugins: ['remove_button'],
            create: false,
            maxItems: null,
            placeholder: "Select food categories...",
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let contactIndex = {{ count($contacts ?? []) }};
            let repeaterIndex = {
                order: {{ count($orders ?? []) }},
                reserve: {{ count($reserves ?? []) }},
                media_social: {{ count($medias ?? []) }},
            };
            let galleryIndex = {{ count($galleries ?? []) }};

            // Contact functions
            window.addContact = function() {
                const container = document.getElementById('contact-container');
                const newContact = document.createElement('div');
                newContact.className = 'repeater-item';
                newContact.innerHTML = `
                    <h5>Contact ${contactIndex + 1}</h5>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeContact(this)">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Contact Type</label>
                            <select name="contact[${contactIndex}][type]" class="form-select" required>
                                <option value="email">Email</option>
                                <option value="wa">WhatsApp</option>
                                <option value="telp">Telephone</option>
                                <option value="telegram">Telegram</option>
                            </select>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Contact Details</label>
                            <input type="text" name="contact[${contactIndex}][details]" class="form-control" 
                                   required placeholder="Enter contact information">
                        </div>
                    </div>
                `;
                container.appendChild(newContact);
                contactIndex++;
            }

            window.removeContact = function(button) {
                button.closest('.repeater-item').remove();
            }

            // Operating hours functions
            window.addOperatingHour = function() {
                const container = document.getElementById('operating-hours-container');
                const div = document.createElement('div');
                div.className = 'operating-hours-item';
                div.innerHTML = `
                    <input type="text" name="open_hours_keys[]" class="form-control" placeholder="Day(s)" required>
                    <input type="text" name="open_hours_values[]" class="form-control" placeholder="Hours" required>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeOperatingHour(this)">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                container.appendChild(div);
            }

            window.removeOperatingHour = function(btn) {
                btn.closest('.operating-hours-item').remove();
            }

            // General repeater functions
            window.addRepeater = function(type) {
                const container = document.getElementById(`${type}-container`);
                const index = repeaterIndex[type];
                let html = '';

                if (type === 'order') {
                    html = `
                        <div class="repeater-item">
                            <h5>Order Platform ${index + 1}</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeRepeater(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Platform</label>
                                    <select name="order[${index}][platform]" class="form-select">
                                        <option value="Menulog">Menulog</option>
                                        <option value="DoorDash">DoorDash</option>
                                        <option value="UberEAST">UberEAST</option>
                                        <option value="Abacus">Abacus</option>
                                        <option value="Fantuan">Fantuan</option>
                                        <option value="Website">Website</option>
                                        <option value="HungryPanda">HungryPanda</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Link</label>
                                    <input type="url" name="order[${index}][link]" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Display Name</label>
                                    <input type="text" name="order[${index}][name]" class="form-control">
                                </div>
                            </div>
                        </div>
                    `;
                } else if (type === 'reserve') {
                    html = `
                        <div class="repeater-item">
                            <h5>Reservation Platform ${index + 1}</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeRepeater(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Platform</label>
                                    <select name="reserve[${index}][platform]" class="form-select">
                                        <option value="OpenTable">OpenTable</option>
                                        <option value="Quandoo">Quandoo</option>
                                        <option value="Website">Website</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Link</label>
                                    <input type="url" name="reserve[${index}][link]" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Display Name</label>
                                    <input type="text" name="reserve[${index}][name]" class="form-control">
                                </div>
                            </div>
                        </div>
                    `;
                } else if (type === 'media_social') {
                    html = `
                        <div class="repeater-item">
                            <h5>Social Media ${index + 1}</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeRepeater(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Platform</label>
                                    <select name="media_social[${index}][platform]" class="form-select">
                                        <option value="website">Website</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="facebook">Facebook</option>
                                        <option value="twitter">Twitter</option>
                                        <option value="tiktok">TikTok</option>
                                        <option value="youtube">YouTube</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Link</label>
                                    <input type="url" name="media_social[${index}][link]" class="form-control">
                                </div>
                            </div>
                        </div>
                    `;
                }

                container.insertAdjacentHTML('beforeend', html);
                repeaterIndex[type]++;
            }

            window.removeRepeater = function(button) {
                button.closest('.repeater-item').remove();
            }

            // Gallery functions
            window.addGalleryRepeater = function() {
                const container = document.getElementById('gallery-container');
                const item = document.createElement('div');
                item.className = 'repeater-item';
                item.innerHTML = `
                    <h5>Image ${galleryIndex + 1}</h5>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-btn" onclick="removeRepeater(this)">
                        <i class="fas fa-times"></i>
                    </button>
                    <input type="hidden" name="gallery_data[${galleryIndex}][id]" value="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="gallery_data[${galleryIndex}][title]" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Image</label>
                            <input type="file" name="gallery_data[${galleryIndex}][image]" class="form-control" accept="image/*">
                        </div>
                    </div>
                `;
                container.appendChild(item);
                galleryIndex++;
            }

            // Add smooth scrolling to form sections
            document.querySelectorAll('.form-section-header').forEach(header => {
                header.style.cursor = 'pointer';
                header.addEventListener('click', function() {
                    const body = this.nextElementSibling;
                    if (body.style.display === 'none') {
                        body.style.display = 'block';
                    } else {
                        body.style.display = 'none';
                    }
                });
            });

            // Form validation feedback
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first invalid field
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });

            // Real-time validation
            document.querySelectorAll('input[required], select[required], textarea[required]').forEach(field => {
                field.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
</body>
</html>