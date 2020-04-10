@extends('layouts.auth')

@section('content')
<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 d-none d-md-flex bg-image"></div>


        <!-- The content half -->
        <div class="col-md-6 bg-light">
            <div class="login d-flex align-items-center py-5">

                <!-- Demo content-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-7 mx-auto">
                        <h3 class="pb-2">Registrarme</h3>
                            {{-- <p class="text-muted mb-4">Create a login split page using Bootstrap 4.</p> --}}
                            <form method="POST" action="{{ route('register') }}"">
                                @csrf
                                @method('post')
                                <div class="form-group mb-3">
                                    <input name="firstName" type="text" autocomplete="off" placeholder="Nombre" required="" autofocus="" class="form-control border-0 shadow-sm px-4">
                                </div>
                                <div class="form-group mb-3">
                                    <input name="lastName" type="text" autocomplete="off" placeholder="Apellido" required="" class="form-control border-0 shadow-sm px-4">
                                </div>
                                <div class="form-group mb-3">
                                    <input name="email" type="email" autocomplete="off" placeholder="Email" required="" class="form-control border-0 shadow-sm px-4">
                                </div>
                                <div class="form-group mb-3">
                                    <input name="password" type="password" autocomplete="off" placeholder="Contraseña" required="" class="form-control border-0 shadow-sm px-4 text-primary">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" autocomplete="off" placeholder="Confirmar contraseña" required="" class="form-control border-0 shadow-sm px-4 text-primary">
                                </div>
                                {{-- <div class="custom-control custom-checkbox mb-3">
                                    <input id="customCheck1" type="checkbox" checked class="custom-control-input">
                                    <label for="customCheck1" class="custom-control-label">Remember password</label>
                                </div> --}}
                                <button type="submit" class="btn btn-primary btn-block text-uppercase mb-2 shadow-sm">Registrarme</button>
                                <div class="text-center d-flex justify-content-start mt-2">
                                <p>¿Ya tienes una cuenta? <a href="{{route('login')}}" class="mx-2">Ingresar</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- End -->

            </div>
        </div><!-- End -->

    </div>
    
    @endsection