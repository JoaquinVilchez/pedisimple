@extends('layouts.app')
@section('content')

<section class="jumbotron rounded-0 text-center p-0 mb-0" style="background: url('https://images.pexels.com/photos/1435907/pexels-photo-1435907.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px / cover transparent;">
  <div class="gradient">
    <div class="container d-flex align-items-center justify-content-center" style="height:200px;">
        <h2 class="text-white" style="text-shadow: 0px 5px 8px rgba(0,0,0,0.6);"><strong>¡Únase hoy para aumentar sus ventas en línea!</strong></h2>
      </div>
    </div>
  </div>
</section>

<div class="container">
    <div class="row justify-content-center mt-3">
      <div class="col-12 col-md-6" style="text-align:center">
        <h3>Completá el siguiente formulario</h3>
        <p>Nos pondremos en contacto contigo una vez enviado el formulario.</p>
      </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
          @include('messages')
            <div class="card my-3">
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
                          <label>Teléfono</label>
                          <input name="phone" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Nombre de tu comercio</label>
                          <input name="commerce" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Cuéntanos un poco sobre tu comercio</label>
                          <textarea name="aditional_notes" class="form-control" rows="3"></textarea>
                        </div>

                        <button type="submit" class="spinnerSubmitButton btn btn-block btn-primary">
                          <i class="loadingIcon fas fa-spinner fa-spin d-none"></i> 
                          Enviar solicitud
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection