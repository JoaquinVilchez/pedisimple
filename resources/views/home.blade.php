@extends('layouts.app')

@section('content')

<div class="text-center px-0 pb-0 mb-0 rounded-0 d-flex align-items-center" style="height:300px; background: url('{{ asset('images/design/home.jpg') }}') no-repeat scroll 0px 100% / cover transparent; black, transparent;">
      <div class="container text-white"">
          <div class="m-auto">
          {{-- <h1 class="txt-shadow"><strong>Pedir comida, ahora es más simple</strong></h1> --}}
          <h1 class="h1-responsive"><strong>Pedir lo que buscás, ahora es más simple</strong></h1>
          <p>Consultá los productos de los comercios de Venado Tuerto y facilitá tu pedido</p>
          {{-- <form action="{{route('list.index')}}" class="form-inline justify-content-center">
            <select class="form-control">
              <option value="1">Pizzas</option>
              <option value="1">Empanadas</option>
            </select>
            <input type="text" placeholder="Buscar comercio" class="form-control">
            <input type="submit" value="Buscar" class="btn btn-primary mx-2">
          </form> --}}
          </div>
        <a href="{{route('list.index')}}" class="btn btn-primary btn-sm mt-2"><strong>Ver todos los comercios</strong></a> 
      </div>
</div>

<section class="text-center">
    <div class="container col-xl-8 my-3">
      <h4 class="txt-bold">¿Cómo funciona Pedí Simple?</h4>
      <hr class="mb-0">
      <div class="row d-flex justify-content-center my-3">
        <div class="col-xl-3 col-lg-3 col-12 mx-1 mt-4">
          <img src="{{asset('images/design/store.svg')}}" class="img-step" alt="">
          <div class="col-xl-12">
            <div class="my-2"><small>1</small></div>
            <h6 class="txt-bold">Elegí tu comercio favorito</h6>
              <small>Consultá productos y precios de los comercios disponibles en nuestra plataforma.</small>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-12 mx-1 mt-4">
          <img src="{{asset('images/design/basket.svg')}}" class="img-step" alt="">
          <div class="col-xl-12">
            <div class="my-2"><small>2</small></div>
            <h6 class="txt-bold">Armá tu pedido</h6>
            <small class="col-md-6">Carga los productos al carrito y conocé el costo de tu pedido.</small>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-12 mx-1 mt-4">
          <img src="{{asset('images/design/conversation.svg')}}" class="img-step" alt="">
          <div class="col-xl-12">
            <div class="my-2"><small>3</small></div>
            <h6 class="txt-bold">Coordiná con el comercio</h6>
            <small class="col-md-6">Llamá al comercio con el pedido previamente armado, evitando demoras telefónicas.</small>
          </div>
        </div>
      </div>
      {{-- <hr class="mb-0"> --}}
    </div>
</section>

<section class="text-center">
  <hr>
  <div class="container col-xl-8 my-3">
  <img src="{{asset('images/design/merchant.svg')}}" width="60px" class="my-2">
    <h4 class="txt-bold">¿Comerciante?</h4>
    <p>Sumate a Pedí Simple y obtené beneficios</p>
    <a class="btn btn-sm btn-primary" href="{{route('register.request')}}">Más información</a>
  </div>
</section>

@endsection
