@component('mail::message')
# Hola {{$data['first_name']}}.

Te informamos que hemos pausado tu suscripción por falta de pago para el comercio "{{$data['restaurant']}}". <br>

Ponte en contacto con nosotros para realizar el pago y así volver a activar el servicio.<br>

Muchas gracias.
<br>{{ config('app.name') }}

@component('mail::panel')
<small>Ante cualquier duda, no dudes en contactarnos.</small>
@endcomponent

@endcomponent



