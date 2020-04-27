@component('mail::message')
# Solicitud recibida con éxito

Gracias por enviar tu solicitud, nos pondremos en contacto contigo a la brevedad.

¡Muchas gracias!
<br><br> Equipo de {{ config('app.name') }}

@component('mail::panel')
<small>Ante cualquier duda, no dudes en contactarnos.</small>
@endcomponent

@endcomponent
