@extends('layouts.app')

@section('content')
<div class="container-fluid">
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
          @elseif(Auth::user()->restaurant->state=='without-times')
          <div class="alert alert-danger m-2" role="alert">Tu comercio fue inhabilitado temporalmente. <a href="{{route('restaurant.times')}}" class="alert-link">Establece los horarios de apertura</a> y se activará automáticamente.</div>
          @endif
          <hr>
        </div>

        <nav class="nav justify-content-center d-xl-none mb-3">
          <ul class="nav justify-content-center">
            <li class="nav-item">
              <a class="nav-link" href="{{route('order.new')}}">Pedidos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-checkbox m-1" href="{{route('product.index')}}">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-checkbox m-1" href="{{route('category.index')}}">Categorías</a>
            </li>
            <li class="nav-item">
              <a class="nav-link">Configuración</a>
            </li>
            <ul class="nav justify-content-center">
              <li class="nav-item">
                  <a class="nav-link btn btn-checkbox m-1" href="{{route('restaurant.info')}}">Información del comercio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-checkbox m-1" href="{{route('restaurant.times')}}">Horarios</a>
              </li>
            </ul>
          </ul>
        </nav>

        <nav class="nav d-none d-xl-block">
          <ul class="nav flex-column">
            
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#orderCollapse" role="button" aria-expanded="false" aria-controls="orderCollapse">
                Pedidos <i class="fas fa-chevron-down"></i>
              </a>
            </li>
            <div class="collapse" id="orderCollapse">
              <ul>
                <li class="nav-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <span><a class="nav-link" href="{{route('order.new')}}">Nuevos</a></span>
                      @if((Auth::user()->unreadNotifications()->count())>0)
                        <span class="badge badge-pill badge-danger ml-2">{{Auth::user()->unreadNotifications()->count()}} </span>
                      @else
                        <span class="text-muted mx-4"><small>{{Auth::user()->restaurant->newOrders()}}</small></span> 
                      @endif
                  </div>
                    
                </li>
                <li class="nav-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <span><a class="nav-link" href="{{route('order.accepted')}}">Aceptados</a></span>
                    <span class="text-muted mx-4"><small>{{Auth::user()->restaurant->acceptedOrders()}}</small></span>
                  </div>
                </li>
                <li class="nav-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <a class="nav-link" href="{{route('order.closed')}}">Cerrados</a>
                    <span class="text-muted mx-4"><small>{{Auth::user()->restaurant->closedOrders()}}</small></span>
                  </div>
                </li>
              </ul>
            </div>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#productCollapse" role="button" aria-expanded="false" aria-controls="productCollapse">
                  Productos <i class="fas fa-chevron-down"></i>
                </a> 
            </li>
            <div class="collapse" id="productCollapse">
              <ul>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('product.index')}}">Menú</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('variant.index')}}">Variantes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('product.temporaries')}}">Temporales</a>
                </li>
              </ul>
            </div>

            <li class="nav-item">
                <a class="nav-link" href="{{route('category.index')}}">Categorías</a>
            </li>

            <a class="nav-link" data-toggle="collapse" href="#configCollapse" role="button" aria-expanded="false" aria-controls="configCollapse">
              Configuración <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse" id="configCollapse">
              <ul>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('restaurant.info')}}">Información del comercio</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('restaurant.times')}}">Horarios</a>
                </li>
              </ul>
            </div>
          </ul>
        </nav>
      </div>
    </nav>

    <main role="main" class="col-auto ml-sm-auto col-xl-10 col-12">
      @yield('main')
    </main>
  </div>
</div>
@endsection
