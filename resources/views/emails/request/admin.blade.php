@component('mail::message')
# Nueva solicitud de registro

Datos de la solicitud: <br>
Nombre: {{$data['first_name'].' '.$data['last_name']}} <br>
Email: {{$data['email']}} <br>
Teléfono: {{$data['phone']}} <br>
Comercio: {{$data['commerce']}} <br>
Nota adicional: {{$data['aditional_notes']}} <br>

@endcomponent
