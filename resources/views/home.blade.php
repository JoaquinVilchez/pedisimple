@extends('layouts.app')

@section('content')

<section class="jumbotron rounded-0 text-center p-0 mb-0 home-image">
  <div class="element_home">
    <div class="container d-flex align-items-center justify-content-center text-white" style="height:300px;">
        <div>
          <h1 class="txt-shadow"><strong>Pedir lo que buscás, ahora es más simple</strong></h1>
          <p>Consultá los productos de los comercios de Venado Tuerto y hace tu pedido 100% online</p>
          {{-- <form action="{{route('list.index')}}" class="form-inline justify-content-center">
            <select class="form-control">
              <option value="1">Pizzas</option>
              <option value="1">Empanadas</option>
            </select>
            <input type="text" placeholder="Buscar comercio" class="form-control">
            <input type="submit" value="Buscar" class="btn btn-primary mx-2">
          </form> --}}
          <a href="{{route('home.index')}}" class="btn btn-sm btn-primary mt-2"><strong> Ver todos los comercios</strong></a> 
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
        <div class="col-12 col-md-4 text-center">
            <div class="d-flex flex-column align-items-center">
                <i class="fas fa-store fa-3x text-primary mb-3"></i>
                <h5>Elige tu comercio</h5>
                <p class="text-muted">Selecciona entre los mejores restaurantes y comercios gastronómicos de tu zona</p>
            </div>
        </div>
        <div class="col-12 col-md-4 text-center">
            <div class="d-flex flex-column align-items-center">
                <i class="fas fa-shopping-cart fa-3x text-success mb-3"></i>
                <h5>Realiza tu pedido</h5>
                <p class="text-muted">Agrega al carrito los productos que desees y confirma tu compra</p>
            </div>
        </div>
        <div class="col-12 col-md-4 text-center">
            <div class="d-flex flex-column align-items-center">
                <i class="fas fa-comments fa-3x text-info mb-3"></i>
                <h5>Recibe notificaciones</h5>
                <p class="text-muted">Te informamos en tiempo real sobre el estado de tu pedido</p>
            </div>
        </div>
      </div>
    </div>
</section>

<section class="text-center">
  <hr>
  <div class="container col-xl-8 my-3">
  <img src="{{asset('storage/design/merchant.svg')}}" width="60px" class="my-2">
    <h4 class="txt-bold">¿Comerciante?</h4>
    <p>Sumate a Pedí Simple y obtené beneficios</p>
    <a class="btn btn-sm btn-primary" href="{{route('register.request')}}">Más información</a>
  </div>
</section>

@endsection
