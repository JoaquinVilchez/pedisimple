@extends('layouts.maintenance')

@section('css-scripts')
<style>
    body{
        background-image: url('images/bg.png');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #fffbf5;
    }
    .mnt-title{
        font-weight: 800;
        text-align: center;
        letter-spacing: -1.5px;
    }

    .mnt-description{
        font-weight: 400;
        text-align: center;
        letter-spacing: -.7px;
        font-size: 1.5em;
}

    .mnt-second-description{
        font-weight: 400;
        text-align: center;
        letter-spacing: -.7px;
        margin: auto;
    }

    @media screen and (max-width:767px){
        body{
            background-image: url('images/bg_mobile.png');
            background-attachment: scroll;
        }

        .mnt-title{
            font-size: 25px;
        }
        .mnt-description{
            font-size: 18px;
    }
    }
</style>
@endsection

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mnt-title">¡Página en mantenimiento!</h1>
            <p class="mnt-description">¡En los próximos días estaremos activos con nuevas funciones!</p>
            <hr class="my-1">
            <div class="row">
                <div class="col-12 col-md-5 m-auto">
                    <p class="mnt-second-description">¡Podrás consultar múltiples comercios de la ciudad de Venado Tuerto y hacer tu pedido 100% online!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-7 m-auto" id="success_message" hidden>
            <div class="my-5" style="text-align: center">
                <h5 style="color:#008e15"><i class="fas fa-check-circle"></i> Ya estás suscrito, gracias.</h5>
            </div>
        </div>
        <div class="col-12 col-md-10 col-lg-6 col-xl-6 m-auto d-none d-md-block" id="subscribe-form">
            <div class="my-4" style="text-align: center">
                <small class="txt-mute">Quiero conocer las últimas novedades</small>
                <form action="#" method="POST">
                    @csrf
                    <div class="input-group mb-3 shadow-sm">
                        <input name="email" type="text" class="form-control" placeholder="Ingresa tu correo electrónico" aria-label="Ingresa tu correo electrónico" aria-describedby="button-addon2">
                        <select name="type" class="form-control" style="max-width:35%">
                            <option value="customer">Soy usuario</option>
                            <option value="merchant">Soy comerciante</option>
                        </select>
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" id="button-addon2" onclick="subscribeToNewsletter()">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="alert alert-danger p-1" role="alert" id="error_message" hidden style="text-align: center">
            </div>
        </div>

        {{-- <div class="col-12 col-md-7 m-auto d-md-none" id="subscribe-form">
            <div class="my-4" style="text-align: center">
                <small class="txt-mute">Quiero conocer las últimas novedades</small>
                <form action="#" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="email" type="text" class="form-control" placeholder="Ingresa tu correo electrónico" aria-label="Ingresa tu correo electrónico">
                    </div>
                    <select name="type" class="form-control input-group mb-3">
                        <option value="customer">Soy usuario</option>
                        <option value="merchant">Soy comerciante</option>
                    </select>
                    <div class="input-group mb-3">
                        <div class="input-group mb-3">
                          <button class="btn btn-primary btn-block" type="button" onclick="subscribeToNewsletter()">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="alert alert-danger p-1" role="alert" id="error_message" hidden style="text-align: center">
            </div>
        </div> --}}
        
    </div>
    @if(Auth::guest())
        <div class="row mt-2">
            <div class="col-12 m-auto" style="text-align: center">
                <a href="{{route('register.request')}}" class="btn btn-sm btn-link"> Quiero agregar mi comercio <i class="fas fa-plus-circle"></i></a><br>

                <a href="{{route('login')}}" class="btn btn-sm btn-link"> Ingreso comerciantes <i class="fas fa-sign-in-alt"></i></a>
            </div>
        </div>
    @else
        <div class="row mt-5">
            <div class="col-12 m-auto" style="text-align: center">
                <a href="{{route('product.index')}}" class="btn btn-sm btn-outline-primary"> Ir a mi comercio <i class="fas fa-store"></i></a>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12 col-md-6 m-auto" style="text-align: center">
            <hr class="mb-1">
            <p>¡Seguinos en nuestras redes sociales!</p>
            <span>
                <a target=”_blank” href="http://instagram.com/pedisimple"><i class="fab fa-instagram mr-1"></i></a>
                <a target=”_blank” href="http://facebook.com/pedisimple"><i class="fab fa-facebook-square mr-1"></i></a>
                <a target=”_blank” href="mailto:contacto@pedisimple.com"><i class="far fa-envelope mr-1"></i></a>
            </span>
        </div>
    </div>

</div>
@endsection

@section('js-scripts')
<script>
    function subscribeToNewsletter(){
        let email = $("input[name=email]").val();
        let type = $("select[name=type]").val();
        $.ajax({
        url : '{{ route("mailsubscription.store") }}',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data:{email:email,type:type},
        success:function(data){
            $('#success_message').removeAttr('hidden');
            $('#subscribe-form').hide();
        },
        error:function(data){
            $.each(data.responseJSON.errors, function(key,value) {
                $('#error_message').removeAttr('hidden');
                $('#error_message').html('<i class="fas fa-times-circle"></i> ' + value);
            });
        }
    });
  }
</script>
@endsection
