@extends('layouts.app')

@section('content')
<div class="container-fluid">
  {{-- <div class="row">
    <div class="col-12 px-0">
      <div style="text-align:center" class="alert alert-warning mb-0 rounded-0 mw-100" role="alert">
        <strong>Recuerda: </strong>La plataforma momentáneamente está abierta solo para que cargues tus datos. Te avisaremos cuando esté abierta al público.
      </div>
    </div>
  </div> --}}
  <div class="row">
    <nav class="col-xl-2 bg-light sidebar ">      
      <div class="sidebar-sticky">
        <div style="text-align:center">
          <img width="100px" src="{{asset('images/uploads/commerce/'.Auth::user()->restaurant->image)}}" class="img-thumbnail mt-4">
          <h6>{{Auth::user()->restaurant->name}}</h6>
          @if(Auth::user()->restaurant->state=='active')
            @if(count(Auth::user()->restaurant->products)==0)
            <div class="alert alert-warning m-2" role="alert">Para que tu comercio esté visible debes: <br><a href="{{route('product.create')}}" class="alert-link">Crear un producto</a></div>
            @else
              <a class="btn btn-sm btn-primary" href="{{route('restaurant.show', Auth::user()->restaurant->slug)}}" target=”_blank” >Ver perfil</a>
            @endif
          @elseif(Auth::user()->restaurant->state=='pending')
            <div class="alert alert-warning p-0" role="alert">
                <img src="{{asset('images/design/padlock.svg')}}" alt="" width="50px" class="d-block mx-auto my-2">  
                <p class="d-block m-0">Tu comercio está pendiente de aprobación</p>
                <a class="btn btn-sm btn-danger my-2" href="{{route('restaurant.show', Auth::user()->restaurant->slug)}}" target=”_blank” >Vista previa del perfil</a>
            </div>
          @elseif(Auth::user()->restaurant->state=='cancelled')
            <div class="alert alert-danger m-2" role="alert">Tu comercio fue cancelado</div>
          @endif
          <hr>
        </div>

        <nav class="nav justify-content-center d-xl-none mb-3">
          <ul class="nav justify-content-center">
            <li class="nav-item">
              <a class="nav-link btn btn-checkbox m-1" href="{{route('product.index')}}">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-checkbox m-1" href="{{route('category.index')}}">Categorías</a>
            </li>
            <ul class="nav justify-content-center">
              <li class="nav-item">
                <a class="nav-link btn btn-checkbox m-1" href="{{route('restaurant.info')}}">Información del comercio</a>
              </li>
            </ul>
          </ul>
        </nav>

        <nav class="nav d-none d-xl-block">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="{{route('product.index')}}">Pedidos</a>
          </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('product.index')}}">Productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('category.index')}}">Categorías</a>
            </li>
            <li class="nav-item">
              <a class="nav-link">Configuración</a>
            </li>
            <ul>
              <li class="nav-item">
                  <a class="nav-link" href="{{route('restaurant.info')}}">Información del comercio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('restaurant.times')}}">Horarios</a>
              </li>
            </ul>
          </ul>
        </nav>
      </div>
    </nav>

    <main role="main" class="col-auto ml-sm-auto col-xl-10 px-4" onload="">
      @yield('main')
    </main>
  </div>
</div>
@endsection
