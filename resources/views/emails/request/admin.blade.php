@component('mail::message')
# Nueva solicitud de registro

Datos de la solicitud: <br>
Nombre: {{$data['name']}} <br>
Email: {{$data['email']}} <br>
Teléfono: {{$data['phone']}} <br>
Comercio: {{$data['commerce']}} <br>
Dirección: {{$data['address']}} <br>
Posee computadora: {{$data['havecomputer']}} <br>
Información sobre el comercio: {{$data['commercerole']}} <br>

@endcomponent
