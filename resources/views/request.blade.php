@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-3">
      <div class="col-xl-4" style="text-align:center">
        <h3>Sumate a <strong>{{config('app.name')}}</strong> e incrementá tus ventas</h3>
      </div>
    </div>
</div>
    <section class="yellow-section py-2" style="text-align: center; color:white">
      <div class="container col-xl-8 my-3">
        <h4 class="txt-bold">¿Cómo funciona Pedí Simple?</h4>
        <div class="row d-flex justify-content-center my-3">
          <div class="col-xl-3 col-lg-3 col-12 mx-1 mt-4">
            <img src="{{asset('images/design/store.svg')}}" class="img-step" alt="">
            <div class="col-xl-12">
              <div class="my-2"><small>1</small></div>
              <h6 class="txt-bold">Elegí un comercio</h6>
                <small>Compará los distintos locales disponibles en nuestra plataforma.</small>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-12 mx-1 mt-4">
            <img src="{{asset('images/design/basket.svg')}}" class="img-step" alt="">
            <div class="col-xl-12">
              <div class="my-2"><small>2</small></div>
              <h6 class="txt-bold">Armá tu pedido</h6>
              <small class="col-md-6">Cargá los productos al carrito y conocé el costo total.</small>
            </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-12 mx-1 mt-4">
            <img src="{{asset('images/design/conversation.svg')}}" class="img-step" alt="">
            <div class="col-xl-12">
              <div class="my-2"><small>3</small></div>
              <h6 class="txt-bold">Coordiná con el local</h6>
              <small class="col-md-6">Llamá al comercio y hacé tu pedido.</small>
            </div>
          </div>
        </div>
        {{-- <hr class="mb-0"> --}}
      </div>
    </section>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @include('messages')
          <p style="text-align: center">Completá el siguiente formulario y nos pondremos en contacto contigo.</p>
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
                          <label>Teléfono</label>
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