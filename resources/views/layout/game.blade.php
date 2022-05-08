<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.svg') }}">

        <title>Game In Progress</title>

        <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}" type="text/css" media="all" />
        @livewireStyles
        @stack('styles')
    </head>
    <body class="antialiased">
        @include('layout.flash_messages')

        <main class="min-h-screen">
            @yield('content')
        </main>

        @livewireScripts
        <script src="{{ mix('dist/js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
