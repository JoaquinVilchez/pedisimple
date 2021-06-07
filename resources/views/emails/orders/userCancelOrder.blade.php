@component('mail::message')
# Hola {{$data['first_name']}}.

Tu pedido realizado al comercio <strong>{{$data['restaurant']}}</strong> fue cancelado con éxito. <br>

Código de referencia del pedido: <strong>{{$data['order_code']}}</strong>.

¡Te invitamos a realizar otro pedido en nuestra plataforma!
<br>

¡Saludos!
<br>{{ config('app.name') }}

@endcomponent



