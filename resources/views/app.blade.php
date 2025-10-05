<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} - Squarico</title>
        <link rel="icon" href="/img/favicon.png" />
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
        <script src="https://kit.fontawesome.com/2a2e08835f.js" crossorigin="anonymous"></script>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        @stack('styles')
    </head>
    <body>
        @yield('content')

        {{-- @include('footer') --}}

        <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('js/bootstrap.js') }}"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        @stack('scripts')
    </body>
</html>
