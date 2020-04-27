@component('mail::message')
# Hola {{$data['user_name']}}, tu comercio "{{$data['name']}}" fue <strong>activado</strong>.

Entra a tu perfil y carga los tus primeros productos para que estos se
encuentren publicados en {{config('app.name')}}

<br>
¡Recuerda mantener actualizada toda la información!

Muchas gracias
<br>{{ config('app.name') }}

@component('mail::panel')
<small>Ante cualquier duda, no dudes en contactarnos.</small>
@endcomponent

@endcomponent