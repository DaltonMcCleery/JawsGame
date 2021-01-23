<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.svg') }}">

        <title>Jaws</title>

        <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}" type="text/css" media="all" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
              integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
              crossorigin="anonymous">

        @livewireStyles
    </head>
    <body class="antialiased">

        @include('layout.navigation')
        @include('layout.flash_messages')

        @yield('content')

        @include('layout.footer')

        <script src="{{ mix('dist/js/app.js') }}"></script>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
