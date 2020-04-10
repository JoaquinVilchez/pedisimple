<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/e739f5c7c6.js" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>        
        .login,
        .image {
        min-height: 100vh;
        }

        .bg-image {
        background-image: url('https://images.pexels.com/photos/2260200/pexels-photo-2260200.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');
        background-size: cover;
        background-position: center center;
        }
    </style>
    @yield('css-scripts')

</head>
<body class="d-flex flex-column">
    <div id="app">

        <main role="main" class="flex-shrink-0">
            @yield('content')
        </main>  
    </div>

@yield('js-scripts')

</body>
</html>
