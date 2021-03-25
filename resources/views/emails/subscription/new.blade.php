@component('mail::message')
# Hola {{$data['first_name']}}.

Te informamos que hemos asignado una nueva suscripción para tu comercio "{{$data['restaurant']}}". <br>

Recuerda que tienes 30 días gratis para probar la plataforma.<br>

¡Esperemos que te guste y poder contar con tu comercio de acá en adelante!

Muchas gracias.
<br>{{ config('app.name') }}

@component('mail::panel')
<small>Ante cualquier duda, no dudes en contactarnos.</small>
@endcomponent

@endcomponent



