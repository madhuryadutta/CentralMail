<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMTP Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto mt-10">
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 mb-3">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
