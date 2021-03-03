<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Pedir lo que buscás, ahora es más simple">
    <meta property="og:title" content="{{config('app.name')}}" />
    <meta property="og:url" content="{{env('APP_URL')}}" />
    <meta property="og:description" content="Pedir lo que buscás, ahora es más simple">
    <meta property="og:image" content="{{asset('images/share_logo.png')}}">
    <meta property="og:locale:alternate" content="es_ES" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{config('app.name') }}
    </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-variations.css')}}">

    @yield('css-scripts')

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> --}}
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('ionsound/ion.sound.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-es_ES.min.js"></script>
    <script src="{{asset('js/jquery-lazyload/jquery.lazyload.js')}}"></script>

    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/e739f5c7c6.js" crossorigin="anonymous"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-165580235-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-165580235-1');
    </script>

    <!-- Datepicker Files -->
    <link rel="stylesheet" href="{{asset('datepicker\css\bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('datepicker\css\bootstrap-datepicker.standalone.css')}}">
    <script src="{{asset('datepicker\js\bootstrap-datepicker.js')}}"></script>
    <!-- Languaje -->
    <script src="{{asset('datepicker\locales\bootstrap-datepicker.es.min.js')}}"></script>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light mr-0" >
            <div class="container">
                    <img class="m-auto pt-3" src="{{asset('images/logo.png')}}" width="150px" alt="">
            </div>
        </nav>

        <main role="main" class="flex-shrink-0">
            @yield('content')
        </main>
    </div>

@yield('js-scripts')
</body>
</html>
