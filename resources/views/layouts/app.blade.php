<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/extensions/bootstrap-icons/icons/command.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('assets/extensions/bootstrap-icons/icons/command.png') }}">

    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/app-dark.css') }}">
    @stack('styles')
</head>


<body class="py-3 md:py-0"> {{-- Top Bar --}}
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('partials.sidebar')
        <div id="main" class='layout-navbar navbar-fixed'>
            @include('partials.header')
            @yield('content')
            @include('partials.footer')
        </div>
    </div>
    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <!-- END: JS Assets-->
    {{-- Script tambahan dari halaman --}}
    @stack('scripts')
</body>

</html>
