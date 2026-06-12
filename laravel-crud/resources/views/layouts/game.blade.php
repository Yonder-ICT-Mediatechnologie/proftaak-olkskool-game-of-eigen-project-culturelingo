<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CultureLingo</title>
    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">
</head>
<body>
    {{ $slot }}
    <script src="{{ asset('JS/app.js') }}"></script>
</body>
</html>