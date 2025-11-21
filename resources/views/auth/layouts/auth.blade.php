<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" class="logo-white"
        href="{{ asset('assets/extensions/bootstrap-icons/icons/command.svg') }}">
    <link rel="alternate icon" type="image/png" class="logo-white"
        href="{{ asset('assets/extensions/bootstrap-icons/icons/command.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/custom.css') }}">
    @stack('styles')
</head>

<body>

    <main class="container">
        @yield('content')
    </main>
    
    <!-- JS Assets -->
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
