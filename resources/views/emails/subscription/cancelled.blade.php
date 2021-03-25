@component('mail::message')
# Hola {{$data['first_name']}}.

Te informamos que hemos eliminado tu suscripción para el comercio "{{$data['restaurant']}}". <br>

Ponte en contacto con nosotros para realizar el pago o volver a suscribirte a nuestra plataforma.<br>

¡Te esperamos! <br>

Muchas gracias.
<br>{{ config('app.name') }}

@component('mail::panel')
<small>Ante cualquier duda, no dudes en contactarnos.</small>
@endcomponent

@endcomponent



