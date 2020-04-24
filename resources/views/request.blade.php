@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
      <div class="col-xl-4" style="text-align:center">
        <h3>Completa el siguiente formulario</h3>
        <p>Nos pondremos en contacto contigo una vez enviado el formulario.</p>
      </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
          @include('messages')
            <div class="card my-3">
                {{-- <div class="card-header">Solicitud de registro a la aplicacion</div> --}}
                <div class="card-body">
                  <form action="{{route('restaurant.request')}}" method="POST">
                    @csrf
                        <div class="form-group">
                          <label>Nombre</label>
                          <input name="first_name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Apellido</label>
                          <input name="last_name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>E-Mail</label>
                          <input name="email" type="email" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Telefono</label>
                          <input name="phone" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Comercio</label>
                          <input name="commerce" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Nota adicional</label>
                          <small>(Opcional)</small>
                          <textarea name="aditional_notes" class="form-control" rows="3"></textarea>
                        </div>
                        
                          <button type="submit" class="btn btn-primary btn-block">Enviar solicitud</button>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection