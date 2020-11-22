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

    {{-- <div class="row">
        <div class="col-12 col-md-6 m-auto">
            <div class="my-4" style="text-align: center">
                <small class="txt-mute">Avisarme cuando vuelva</small>
                <form action="#">
                    <div class="input-group mb-3 shadow-sm">
                        <input type="text" class="form-control" placeholder="Ingresa tu correo electrónico" aria-label="Ingresa tu correo electrónico" aria-describedby="button-addon2">
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="button" id="button-addon2">Confirmar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12 col-md-6 m-auto" style="text-align: center">
            <hr class="mb-1">
            <p>¡Seguinos en nuestras redes sociales!</p>
            <span>
                <a target=”_blank” href="http://instagram.com/pedisimple"><i class="fab fa-instagram mr-1"></i></a>
                <a target=”_blank” href="http://facebook.com/pedisimple"><i class="fab fa-facebook-square mr-1"></i></a>
                <a target=”_blank” href="http://twitter.com/pedisimple"><i class="fab fa-twitter mr-1"></i></a>
                <a target=”_blank” href="mailto:contacto@pedisimple.com"><i class="far fa-envelope mr-1"></i></a>
            </span>
        </div>
    </div>

</div>
@endsection
