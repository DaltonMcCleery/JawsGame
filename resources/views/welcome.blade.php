<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ mix('dist/css/app.css') }}">

        <title>Laravel</title>
    </head>
    <body class="antialiased">

        <script src="{{ mix('dist/js/app.js') }}"></script>
{{--        <script>--}}
{{--            Echo.channel('test')--}}
{{--                .listen('.test.message', (e) => {--}}
{{--                    console.log(e);--}}
{{--                });--}}
{{--        </script>--}}
    </body>
</html>
