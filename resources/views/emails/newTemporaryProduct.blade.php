@component('mail::message')
# El comercio {{$restaurant['name']}}, acaba de crear un nuevo producto temporal.

Detalles del producto:
@component('mail::panel')
Nombre: <strong>{{$product['name']}}</strong> <br>
Descripción: <strong>{{$product['details']}}</strong> <br>
Precio: <strong>${{$product['price']}}</strong> <br>
Fecha de inicio: <strong>{{date('d-m-Y', strtotime($product['start_date']))}}</strong> <br>
Fecha de fin: <strong>{{date('d-m-Y', strtotime($product['end_date']))}}</strong> <br>
@endcomponent


@endcomponent