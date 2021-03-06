<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.0/trix.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/dice/favicon-32x32.png') }}" type="image/x-icon">

    <script charset="utf-8">
        window.App = {!! json_encode([
            'user' => Auth::user(),
            'signedIn' => Auth()->check()
        ]) !!};
    </script>

    <style>
        body {
            padding-bottom: 100px;
            background-color: #2b4762;
        }
        .level {
            display: flex;
            align-items: center;
        }
        .flex {
            flex: 1;
        }
        .mr-1 {
            margin-right: 1em;
        }
        .ml-a {
            margin-left: auto;
        }
        .mb-2 {
            margin-bottom: 2em;
        }
        [v-cloak] {
            display: none;
        }
        .ais-highlight > em {
            background-color: yellow;
        }
    </style>

    @yield('header')

</head>
<body style="padding-bottom: 100px;">
    <div id="app">
        @include('layouts.nav')

        @yield('content')

        <flash message="{{ session('flash') }}"></flash>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
