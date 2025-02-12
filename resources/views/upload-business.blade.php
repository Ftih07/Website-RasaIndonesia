<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload JSON Business</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 50px; }
        .container { width: 50%; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        input[type="file"] { margin: 10px 0; }
        button { padding: 10px 15px; background: blue; color: white; border: none; cursor: pointer; }
        button:hover { background: darkblue; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload File JSON untuk Business</h2>
        
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        
        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form action="{{ url('/upload-business') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="json_file" accept=".json" required>
            <br>
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>
