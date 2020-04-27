@component('mail::message')
# El comercio "{{$data['name']}}" fue creado.

Nombre del comercio: {{$data['name']}}

@component('mail::button', ['url' => env('APP_URL').'/administracion/comercios'])
Activar Comercio
@endcomponent

@endcomponent
