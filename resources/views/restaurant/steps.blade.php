@extends('layouts.app')

@section('css-scripts')
<style>
    .card {
        margin:5% 0 5% 0px; /* Added */
        float: none; /* Added */
}
</style>
@endsection

@section('content')

        <div class="row d-flex justify-content-center my-auto mx-0 vh-100" style="background-color: #FFC500">
            <div class="col-12 col-md-8">
                {{-- <div class="card text-center" id="card-step1">
                    <div class="card-body">
                        <h4 class="my-2 txt-semi-bold">Recibe notificaciones de un nuevo pedido por WhatsApp</h4>
                        <hr class="m-0">

                        <div class="row my-4">
                            <i class="fab fa-whatsapp fa-4x text-success m-auto"></i>
                        </div>

                        <p class="mt-2">
                            Haz click en el siguiente botón y envía el texto predefinido al número establecido para poder adherirte a la casilla de notificaciones.
                            Una vez que lo envíes, el sistema te enviará un mensaje confirmando tu suscripción.
                        </p>
                        <div>
                            <div class="col-12 col-lg-8 m-auto">
                                <div class="alert alert-primary" role="alert">
                                    <small>Es necesario que te adhieras con el teléfono al que quieres que te llegen las notificaciones.</small>
                                </div>
                            </div>
                            <p>Por defecto enviaremos las notificaciones al siguiente número:</p>
                            <div class="col-12 col-lg-6 m-auto">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5 col-5 pr-1">
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="addon-wrapping">0</span>
                                                </div>
                                                <input type="text"
                                                    @if(Auth::user()->restaurant->notification_characteristic == '')
                                                        value="{{Auth::user()->characteristic}}"
                                                    @else
                                                        value="{{Auth::user()->restaurant->notification_characteristic}}"
                                                    @endif
                                                        class="form-control" name="notification-characteristic" autocomplete="false" placeholder="Prefijo" maxlength="4" onkeypress="return onlyNumberKey(event)">
                                            </div>
                                        </div>

                                        <div class="col-md-7 col-7 pr-1">
                                            <div class="input-group flex-nowrap">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="addon-wrapping">15</span>
                                                </div>
                                                    <input id="phone"
                                                        @if(Auth::user()->restaurant->notification_number == '')
                                                            value="{{Auth::user()->phone}}"
                                                        @else
                                                            value="{{Auth::user()->restaurant->notification_number}}"
                                                        @endif
                                                        type="text" class="form-control" name="notification-phone" autocomplete="false" placeholder="Teléfono" maxlength="6" onkeypress="return onlyNumberKey(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <small><p>Puedes modificar el número si así lo deseas.</p></small>
                            </div>
                        </div>
                        <a class="btn btn-success" target="_blank" id="button-step1" href="https://api.whatsapp.com/send?phone=+14155238886&text=join%20story-exciting&source=&data=&app_absent="><i class="fab fa-whatsapp"></i> Enviar mensaje</a>
                    </div>
                </div> --}}
                <div class="card text-center my-4" id="card-step2">
                    <div class="card-body">
                        <h4 class="my-2 txt-semi-bold">Configura tus horarios para continuar</h4>
                        <hr class="m-0">
                        <p class="mt-2">Para poder activar el servicio es obligatorio que configures los horarios de apertura de tu comercio.</p>
                        <div class="row my-4">
                            <i class="fas fa-calendar-alt fa-4x text-primary m-auto"></i>
                        </div>
                        <a class="btn btn-primary" href="{{route('restaurant.times')}}" id="button-step2">Establecer horarios</a>
                    </div>
                    {{-- <div class="float-left">
                        <a href="#" class="text-muted" id="back-to-step1">< Volver atrás</a>
                    </div> --}}
                </div>
            </div>
        </div>
@endsection
