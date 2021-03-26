@component('mail::message')
# Hola {{$data['first_name']}}.

Queremos invitarte a que formes parte de <strong>{{env('APP_NAME')}}</strong><br>

Para eso, podés registrarte por medio del siguiente Link.
<a href="{{$data['url']}}"></a>

@component('mail::button', ['url' => $data['url']])
Registrarme
@endcomponent

Muchas gracias, te esperamos.
<br>{{ config('app.name') }}

@component('mail::panel')
<small>Ante cualquier duda, no dudes en contactarnos.</small>
@endcomponent

@endcomponent



