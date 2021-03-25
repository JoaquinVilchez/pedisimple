@component('mail::message')
# Hola {{$data['first_name']}}.

Te informamos que recibimos tu pago y hemos renovamos la suscripción para tu comercio "{{$data['restaurant']}}". <br>

Gracias por seguir confiando en nuestra plataforma.
<br>{{ config('app.name') }}

@component('mail::panel')
<small>Ante cualquier duda, no dudes en contactarnos.</small>
@endcomponent

@endcomponent



