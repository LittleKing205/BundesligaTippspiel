<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bundeliga Tippspiel</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/login-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body class="text-center">
    @yield('content')
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('script')
</body>
</html>
