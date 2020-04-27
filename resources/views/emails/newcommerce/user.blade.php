@component('mail::message')
# Tu solicitud fue generada de manera correcta
Tu comercio "{{$data['name']}}" se encuentra en <strong>estado pendiente de aprobación</strong>. 
<br><br>
Te enviaremos un correo notificando la activación del mismo.
<br>

Muchas gracias
<br>{{ config('app.name') }}

@component('mail::panel')
<small>Ante cualquier duda, no dudes en contactarnos.</small>
@endcomponent

@endcomponent
