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

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Fin-Favicon -->


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(Auth::check())
            @if(Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()>0)
                ({{Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()}})
            @endif
        @endif
        {{config('app.name') }}
    </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-variations.css')}}">

    <!-- Datepicker Files -->
    <link rel="stylesheet" href="{{asset('datepicker\css\bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('datepicker\css\bootstrap-datepicker.standalone.css')}}">
    <script src="{{asset('datepicker\js\bootstrap-datepicker.js')}}"></script>
    <!-- Languaje -->

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
    @if (env('APP_ENV')=='production')
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-165580235-1');
        </script>
    @endif
    <script src="{{asset('datepicker\locales\bootstrap-datepicker.es.min.js')}}"></script>

    {{-- Cleave --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js"></script>

    {{-- reCaptcha --}}
    {!! htmlScriptTagJsApi(['lang' => 'es']) !!}


</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mr-0"">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home.index') }}">
                <img src="{{asset('images/logo.png')}}" width="150px" alt="">
                </a>

                @if(Auth::user())
                    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <img width="150px" src="{{asset('storage/uploads/user/'.Auth::user()->image)}}" class="img-nav d-inline m-1" @if(Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()>0) style="border: 3px solid #d60000" @endif>
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
                                @if(env('MAINTENANCE')=='NO')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarme') }}</a>
                                        </li>
                                    @endif
                                @endif
                            @else
                                <li class="nav-item dropdown d-none d-md-block d-lg-block d-xl-block">
                                    <img width="150px" data-original="{{asset('storage/uploads/user/'.Auth::user()->image)}}" class="img-nav d-inline m-1 border" @if(Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()>0) style="border: 3px solid #d60000" @endif>
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-inline pl-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{Auth::user()->first_name}} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <div>
                                            @if(Auth::user()->restaurant || Auth::user()->type=='merchant')
                                            <a class="dropdown-item" href="{{route('product.index')}}">Mi comercio @if(Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()>0)<small><i class="fas fa-circle" style="color: #d60000"></i></small>@endif</a>
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
                                        <a class="dropdown-item" href="{{route('product.index')}}">Mi comercio @if(Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()>0)<small><i class="fas fa-circle" style="color: #d60000"></i></small>@endif</a>
                                        @endif

                                        @if(Auth::user()->type=='administrator')
                                        <a class="dropdown-item" href="{{route('restaurant.admin.list')}}">Panel de administración</a>
                                        @endif
                                        <a class="dropdown-item" href="{{route('order.index')}}">Mis pedidos</a>
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
            <div class="alert alert-warning mb-0 text-center" role="alert" id="finishOrder" style="font-size:0.8rem;">
                Tienes un pedido pendiente. <a href="{{route('checkout.index')}}" class="alert-link">Finalizar pedido</a> 
                <div class="float-right">
                    <a href="#" id="trash-empty-cart"><i class="fas fa-trash-alt"></i></a>
                    <a href="#" id="yes-confirm-empty-cart" onclick="emptyCart({{cartRestaurant()}})" style="background-color: #00c738; color: white; padding: 2px 5px; border-radius:2px">Confirmar</a>
                    <a href="#" id="no-confirm-empty-cart" style="background-color: #d60000; color: white; padding: 2px 5px; border-radius:2px">Cancelar</a>
                </div>
            </div>
        @endif

        <main role="main" class="flex-shrink-0">
            @if(Auth::check() and Auth::user()->type == 'merchant')
                <div class="alert alert-success rounded-0 py-1 my-0" style="font-size: .8em; text-align:center;" role="alert">
                    Estas loggeado como <strong>comerciante</strong>
                    <p class="m-0"><strong>Para ver todas las funcionalidades de este rol ingresar desde una PC</strong></p>
                </div>
            @elseif(Auth::check() and Auth::user()->type == 'customer')
                <div class="alert alert-primary rounded-0 py-1 my-0" style="font-size: .8em; text-align:center;" role="alert">
                    Estas loggeado como <strong>usuario</strong>
                </div>
            @endif
            {{-- @if(env('MAINTENANCE')=='YES')
                <div class="alert alert-primary rounded-0 py-1 my-0" style="font-size: .8em; text-align:center;" role="alert">
                    La página no está disponible al público en este momento. Únicamente pueden ingresar los comerciantes para configurar sus productos.
                </div>
            @endif --}}
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
                    <a style="color:white" target=”_blank” href="mailto:{{env('MAIL_FROM_ADDRESS')}}"><i class="far fa-envelope mr-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Modal -->
<div class="modal fade" id="newNotificationModal" tabindex="-1" aria-labelledby="newNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
            <div style="text-align: center">
                <div class="py-2">
                    <h5 class="modal-title txt-bold" id="NewOrderModalTitle">¡Tienes un nuevo pedido!</h5>
                    <img class="my-4" src="{{asset('storage/design/desk-bell.svg')}}" alt="" width="80px">
                </div>
                <div class="container">
                    <a href="{{route('order.new')}}" class="btn btn-block btn-sm btn-primary">Ver pedidos</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

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
            // e.preventDefault();
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

        var MerchantUser = "{{{ (Auth::check()) ? ((Auth::user()->type=='merchant') ? true : false) : false }}}";

        if(MerchantUser==1){
            loadNotifications();
            setInterval(function(){
                loadNotifications();
            }, 30000);
        }
    });

    function addNotificationNumber(){
        let characteristic = $("input[name=notification-characteristic]").val();
        let phone = $("input[name=notification-phone]").val();
        $.ajax({
        url : '{{ route("restaurant.notificationnumber") }}',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data:{characteristic:characteristic,phone:phone}
        });
    }

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

    function loadNotifications(){
        $.ajax({
            url : '/notifications/load',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function(data){
                if(parseInt(data)>0){
                    ion.sound.play("door_bell");
                    $('#countNotification').show();
                    $('#countNotification').html(data);
                    var appName = document.title = '('+data+') {{{config('app.name') }}}';
                    if(data==1){
                        $('#NewOrderModalTitle').html('¡Tienes un nuevo pedido!');
                    }else{
                        $('#NewOrderModalTitle').html('¡Tienes '+data+' nuevos pedidos!');
                    }
                    if($('#newNotificationModal').is(':hidden')){
                        $('#newNotificationModal').modal('toggle');
                        $('#newNotificationModal').modal('show');
                    }
                }
            }
        });

    }

    ion.sound({
            sounds: [
                {
                    name: "door_bell"
                },
            ],
            volume: 1,
            path: "{{asset('/ionsound/sounds/')}}/",
            preload: true
    });

</script>

@yield('js-scripts-carrito')
@yield('js-scripts')
@yield('messages-script')

</body>
</html>
