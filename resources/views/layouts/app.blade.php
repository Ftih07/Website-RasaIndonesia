<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taste of Indonesia</title>
</head>

<body>
    <!-- Content section to be defined by child templates -->
    @yield('content')

    <!-- Stack for additional scripts from child templates -->
    @stack('scripts')
</body>

</html>