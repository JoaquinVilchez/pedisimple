@extends('layouts.app')

@section('content')

<section class="jumbotron rounded-0 text-center p-0 mb-0 home-image">
  <div class="element_home">
    <div class="container d-flex align-items-center justify-content-center text-white" style="height:300px;">
        <div>
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
          <a href="{{route('list.index')}}" class="btn btn-sm btn-primary mt-2" style="box-shadow: 0px 2px 10px #3d3d3d;"><strong> Ver todos los comercios</strong></a> 
        </div>
      </div>
    </div>
  </div>
</section>

<section class="text-center">
    <div class="container col-xl-8 my-3">
      <h4 class="txt-bold">¿Cómo funciona Pedí Simple?</h4>
      <hr class="mb-0">
      <div class="row d-flex justify-content-center my-3">
        <div class="col-xl-3 col-lg-3 col-12 mx-1 mt-4">
          <img src="{{asset('images/design/store.svg')}}" class="img-step" alt="">
          <div class="col-xl-12">
            <div class="my-2"><small>1</small></div>
            <h6 class="txt-bold">Elegí un comercio</h6>
              <small>Mira las opciones de los distintos comercios disponibles.</small>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-12 mx-1 mt-4">
          <img src="{{asset('images/design/basket.svg')}}" class="img-step" alt="">
          <div class="col-xl-12">
            <div class="my-2"><small>2</small></div>
            <h6 class="txt-bold">Armá tu pedido</h6>
            <small class="col-md-6">Cargá los productos que desees al carrito.</small>
          </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-12 mx-1 mt-4">
          <img src="{{asset('images/design/conversation.svg')}}" class="img-step" alt="">
          <div class="col-xl-12">
            <div class="my-2"><small>3</small></div>
            <h6 class="txt-bold">Finalizá tu pedido</h6>
            <small class="col-md-6">Envía tu pedido al comercio 100% online.</small>
          </div>
        </div>
      </div>
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
