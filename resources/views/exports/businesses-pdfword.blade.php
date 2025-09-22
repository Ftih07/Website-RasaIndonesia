<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Business Export</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        .business { margin-bottom: 20px; }
        .separator { border-top: 1px solid #000; margin: 15px 0; }
    </style>
</head>
<body>
    <h2>Taste of Indonesia Business Export - {{ now()->format('d M Y H:i') }}</h2>

    @foreach($businesses as $business)
        <div class="business">
            <strong>ID:</strong> {{ $business->id }} <br>
            <strong>Name:</strong> {{ $business->name }} <br>
            <strong>Type:</strong> {{ $business->type->title ?? '-' }} <br>
            <strong>Country:</strong> {{ $business->country }} <br>
            <strong>City:</strong> {{ $business->city }} <br>
            <strong>Address:</strong> {{ $business->address }} <br>
            <strong>Location:</strong> {{ $business->location }} <br>
            <strong>Latitude:</strong> {{ $business->latitude }} <br>
            <strong>Longitude:</strong> {{ $business->longitude }} <br>
            <strong>Description:</strong> {{ $business->description }} <br>
            <strong>Updated At:</strong> {{ $business->updated_at }} <br>
        </div>
        <div class="separator"></div>
    @endforeach
</body>
</html>
