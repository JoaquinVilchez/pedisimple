@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
        @if(isset($person))
            <div style="text-align:center" class="mb-2">
            <img data-original="{{asset('storage/design/chef.svg')}}" alt="" class="img-default mb-3">
                <h5 class="txt-bold">¡Hola {{$person->first_name}}, que gusto tenerte por acá!</h5>
                <p>Este es el primer paso para registrarte en la plataforma.</p>
                <p>Completa el siguiente formulario con tus <strong>datos personales</strong>.<br>
                    Una vez completado te enviaremos un email de confirmación para verificar tu correo electrónico.</p>
            </div>
        @else
            <div style="text-align:center" class="mb-2">
                <img data-original="{{asset('storage/design/man.svg')}}" alt="" class="img-default mb-3">
                <img data-original="{{asset('storage/design/woman.svg')}}" alt="" class="img-default mb-3">
                    <h5 class="txt-bold">¡Hola, que gusto tenerte por acá!</h5>
                    <p>Este es el primer paso para registrarte en la plataforma.</p>
                    <p>Completa el siguiente formulario con tus datos personales. <br>
                        Una vez completado te enviaremos un email de confirmación para verificar tu correo electrónico.</p>
            </div>
        @endif
            <div class="card my-4">

                <div class="col-12">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            @if(isset($person))
                            <input type="text" hidden value="{{$person->token}}" name="token">
                            @endif

                            <div class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" @if(isset($person)) value="{{ old('email', $person->first_name) }}" @else value="{{ old('first_name') }}" @endif autofocus>

                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" @if(isset($person)) value="{{ old('email', $person->last_name) }}" @else value="{{ old('last_name') }}" @endif>

                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" @if(isset($person)) value="{{ old('email', $person->email) }}" @else value="{{ old('email') }}" @endif>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            {!! htmlFormSnippet() !!}
                                        </div>
                                        @if($errors->first('g-recaptcha-response'))
                                            <small style="color:#dc3545"> El captcha es obligatorio.</small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="spinnerSubmitButton btn btn-primary btn-block">
                                        <i class="loadingIcon fas fa-spinner fa-spin d-none"></i> 
                                        <span class="btn-txt">{{ __('Registrarme') }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-scripts')
    <script src="{{asset('/js/inputNumber.js')}}"></script>
@endsection