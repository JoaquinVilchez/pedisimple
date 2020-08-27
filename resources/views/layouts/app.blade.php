<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Pedir comida, ahora es más simple">
    <meta property="og:title" content="{{config('app.name')}}" />
    <meta property="og:url" content="{{env('APP_URL')}}" />
    <meta property="og:description" content="Pedir comida, ahora es más simple">
    <meta property="og:image" content="{{asset('images/share_logo.png')}}">
    <meta property="og:locale:alternate" content="es_ES" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(Auth::check())
            @if(Auth::user()->unreadNotifications()->count()>0)
                ({{Auth::user()->unreadNotifications()->count()}})
            @endif 
        @endif    
        {{config('app.name') }}</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-variations.css')}}">

    @yield('css-scripts')

    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> --}}
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mr-0">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{asset('images/logo.png')}}" width="150px" alt="">
                </a>
                
                @if(Auth::user())
                    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <img width="150px" src="{{asset('images/uploads/user/'.Auth::user()->image)}}" class="img-nav d-inline m-1">
                    </button>
                @else
                    <button class="d-block d-sm-block d-md-none" style="background: transparent; border: 0px"type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <i class="fas fa-bars"></i>
                    </button>
                @endif

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" style="text-align: center">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarme') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown d-none d-md-block d-lg-block d-xl-block">
                                <img width="150px" data-original="{{asset('images/uploads/user/'.Auth::user()->image)}}" class="img-nav d-inline m-1" @if(Auth::user()->unreadNotifications()->count()>0) style="border: 3px solid #d60000" @endif>
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-inline pl-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{Auth::user()->first_name}} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <div>
                                        @if(Auth::user()->restaurant || Auth::user()->type=='merchant')
                                        <a class="dropdown-item" href="{{route('product.index')}}">Mi comercio @if(Auth::user()->unreadNotifications()->count()>0)<small><i class="fas fa-circle" style="color: #d60000"></i></small>@endif</a>
                                        @endif

                                        @if(Auth::user()->type=='administrator')
                                        <a class="dropdown-item" href="{{route('restaurant.admin.list')}}">Panel de administración</a>
                                        @endif
                                        <a class="dropdown-item" href="{{route('order.index')}}">Mis pedidos</a>
                                        {{-- <a class="dropdown-item" href="{{route('address.index')}}">Mis direcciones</a> --}}
                                        <a class="dropdown-item" href="{{route('user.index')}}">Mis datos</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Salir') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>

                            <div class="d-block d-sm-block d-md-none" aria-labelledby="navbarDropdown" style="text-align: center">

                                <div class="d-block d-sm-block d-md-none">
                                    <strong><p class="mb-1">{{Auth::user()->fullName()}}</p></strong>
                                    <hr class="my-1">
                                </div>

                                <div>
                                    @if(Auth::user()->restaurant || Auth::user()->type=='merchant')
                                    <a class="dropdown-item" href="{{route('product.index')}}">Mi comercio</a>
                                    @endif

                                    @if(Auth::user()->type=='administrator')
                                    <a class="dropdown-item" href="{{route('restaurant.admin.list')}}">Panel de administración</a>
                                    @endif
                                    <a class="dropdown-item" href="{{route('order.index')}}">Mis pedidos</a>
                                    {{-- <a class="dropdown-item" href="{{route('address.index')}}">Mis direcciones</a> --}}
                                    <a class="dropdown-item" href="{{route('user.index')}}">Mis datos</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Salir') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        @if(!\Cart::isEmpty() and Request::path()!="checkout" and Request::path()!="login" and Request::path()!="register" and Request::path()!="email/verify")
            <div class="alert alert-warning mb-0 text-center" role="alert" id="finishOrder" style="font-size:0.8rem">
                Tienes un pedido pendiente. <a href="{{route('checkout.index')}}" class="alert-link">Finalizar pedido</a> 
                <div class="float-right">
                    <a href="#" id="trash-empty-cart"><i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="bottom" title="Vaciar carrito."></i></a>
                    <a href="#" id="no-confirm-empty-cart" style="background-color: #d60000; color: white; padding: 2px 5px; border-radius:2px">Cancelar</a>
                    <a href="#" id="yes-confirm-empty-cart" onclick="emptyCart({{cartRestaurant()}})" style="background-color: #00c738; color: white; padding: 2px 5px; border-radius:2px">Confirmar</a>
                </div>
            </div>
        @endif

        <main role="main" class="flex-shrink-0">
            @yield('content')
        </main>  
    </div>

<footer class="footer">
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-xl-12 col-xs-12">
                <p class="d-inline">Seguinos</p> 
                <div class="icons d-inline ml-3">
                    <a style="color:white" target=”_blank” href="http://instagram.com/pedisimple"><i class="fab fa-instagram mr-1"></i></a>
                    <a style="color:white" target=”_blank” href="http://facebook.com/pedisimple"><i class="fab fa-facebook-square mr-1"></i></a>
                    <a style="color:white" target=”_blank” href="http://twitter.com/pedisimple"><i class="fab fa-twitter mr-1"></i></a>
                    <a style="color:white" target=”_blank” href="mailto:contacto@pedisimple.com"><i class="far fa-envelope mr-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>

    $(document).ready(function(){
        $('.spinnerSubmitButton').closest('form').on('submit', function(e){
            e.preventDefault();
            $('.loadingIcon').removeClass('d-none');
            $('.spinnerSubmitButton').attr('disabled', true);
            $('.btn-txt').text("Espere por favor...");
            this.submit();
        });

        $('.spinnerClickButton').on('click', function(e){
            e.preventDefault();
            $('.loadingIcon').removeClass('d-none');
            $('.spinnerClickButton').attr('disabled', true);
            $('.btn-txt').text("Espere por favor...");
        });

        $('#trash-empty-cart').show();
        $('#yes-confirm-empty-cart').hide();
        $('#no-confirm-empty-cart').hide();

        $('#trash-empty-cart').on('click', function(){
            $('#trash-empty-cart').hide();
            $('#yes-confirm-empty-cart').fadeIn(500);
            $('#no-confirm-empty-cart').fadeIn(500);
        });

        $('#no-confirm-empty-cart').on('click', function(){
            $('#trash-empty-cart').show();
            $('#yes-confirm-empty-cart').hide();
            $('#no-confirm-empty-cart').hide();
        });

        $('img').lazyload({
            threshold: 200,
            effect: 'fadeIn'
        });
    });

    function emptyCart(restaurant){
        $.ajax({
            url : '/carrito/vaciar',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data:{restaurant:restaurant},
            success:function(data){
                $('#trash-empty-cart').show();
                $('#yes-confirm-empty-cart').hide();
                $('#no-confirm-empty-cart').hide();
                $('#finishOrder').hide();
            }
        });
    }

    $(function () {
        $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    })

     $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        clearBtn: true,
        language: "es",
        autoclose: true,
        todayHighlight: true
    });

    function onlyNumberKey(evt) { 
            // Only ASCII charactar in that range allowed 
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
                return false; 
            return true; 
    }
</script>

@yield('js-scripts-carrito')
@yield('js-scripts')
@yield('messages-script')

</body>
</html>
