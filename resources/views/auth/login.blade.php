@extends('layouts.app')
@section('css-scripts')
<style>
    .demo-card {
        width: 500px;
        max-width: 100%;
        padding: 0 30px;
        border: none;
        box-shadow: 0px 4px 97px rgba(0, 0, 0, 0.07);
        border-radius: 17px;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-12 col-md-8">
            <div class="image my-4" style="text-align:center">
                <img data-original="{{asset('images/logo.png')}}" class="mt-1" width="300px">
                <div class="icons d-block ml-3">
                    <a target=”_blank” href="http://instagram.com/pedisimple"><i class="fab fa-instagram mr-1"></i></a>
                    <a target=”_blank” href="http://facebook.com/pedisimple"><i class="fab fa-facebook-square mr-1"></i></a>
                    {{-- <a target=”_blank” href="http://twitter.com/pedisimple"><i class="fab fa-twitter mr-1"></i></a> --}}
                    <a target=”_blank” href="mailto:{{env('MAIL_FROM_ADDRESS')}}"><i class="far fa-envelope mr-1"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="container d-flex justify-content-center">
                    <div class="card demo-card text-center">
                        <div class="card-body">
                          <h5 class="text-title">Comerciante</h5>
                          <p class="mb-0"><strong>user:</strong> pedisimple@gmail.com</p>
                          <p class="mb-0"><strong>pass:</strong> 12345678</p>
                          <h5 class="text-title mt-4">Usuario</h5>
                          <p class="mb-0"><strong>user:</strong> juanperez@gmail.com</p>
                          <p class="mb-0"><strong>pass:</strong> 12345678</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="container mt-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="spinnerSubmitButton btn btn-primary">
                                <i class="loadingIcon fas fa-spinner fa-spin d-none"></i> 
                                <span class="btn-txt">{{ __('Login') }}</span>
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

