<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.admin_name', 'MercaTodo Admin') }}</title>
    <meta name="description" content="MercaTodo admin site">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    {{--
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    --}}
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Initial page</a>
                <h3>{{ config('app.admin_name', 'MercaTodo Admin') }}</h3>
                <a class="navbar-brand" href="{{ route('home') }}">Home</a>
            </div>
        </nav>
        <div class="container">
            @yield('main')
        </div>
    </div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
