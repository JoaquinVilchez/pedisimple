@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="text-align: center">
        <div class="col-md-8">
        <img data-original="{{asset('storage/design/email.svg')}}" alt="" class="img-default my-3">
                    <h4 class="txt-bold">Confirma tu correo electrónico</h4>
            
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    <br><br>

                    <small><strong>El correo puede tardar unos minutos en llegar.</strong></small>
                    <br>
                    <small><strong>Si no te aparece en la bandeja de entrada, revisa en los correos no deseados.</strong></small>

                    <br><br>
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                
        </div>
    </div>
</div>
@endsection
