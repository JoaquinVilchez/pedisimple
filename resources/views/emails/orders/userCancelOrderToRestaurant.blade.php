@component('mail::message')

Te informamos que el solicitante <strong>{{$data['first_name']}} {{$data['last_name']}}</strong> canceló el pedido con codigo de referencia <strong>{{$data['order_code']}}</strong>.
<br>

¡Saludos!
<br>{{ config('app.name') }}

@endcomponent



