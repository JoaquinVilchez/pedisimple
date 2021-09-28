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
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mnt-title">¡Página en mantenimiento!</h1>
            <p class="mnt-description">Disculpe, en estos momentos estamos trabajando en mejoras</p>
                <div class="col-12 m-auto">
                    <p style="text-align: center">¡Volveremos lo antes posible!</p>
                </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12 col-md-6 m-auto" style="text-align: center">
            <hr class="mb-1">
            <p>¡Seguinos en nuestras redes sociales!</p>
            <span>
                <a target=”_blank” href="http://instagram.com/pedisimple"><i class="fab fa-instagram mr-1"></i></a>
                <a target=”_blank” href="http://facebook.com/pedisimple"><i class="fab fa-facebook-square mr-1"></i></a>
                <a target=”_blank” href="http://twitter.com/pedisimple"><i class="fab fa-twitter mr-1"></i></a>
                <a target=”_blank” href="mailto:{{env('MAIL_FROM_ADDRESS')}}"><i class="far fa-envelope mr-1"></i></a>
            </span>
        </div>
    </div>

</div>
@endsection
