<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="{{ asset('images/couch.png') }}">
    <meta name="description" content="" />
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('style')
</head>

<body>
    <!-- Start Header/Navigation -->
    @include('components.header')
    <!-- End Header/Navigation -->
    <div class="py-5">
        @yield('main')
    </div>
    <!-- Start Footer Section -->
    @include('components.footer')
    <!-- End Footer Section -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('scripts')

</body>

</html>
