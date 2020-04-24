@extends('layouts.app')

@section('css-scripts')
<style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
</style>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <div style="text-align:center">
          <img width="100px" src="{{Storage::url(Auth::user()->restaurant->image)}}" class="img-thumbnail mt-4">
          <h6>{{Auth::user()->restaurant->name}}</h6>
          @if(Auth::user()->restaurant->state=='active')
            @if(count(Auth::user()->restaurant->products)==0)
            <div class="alert alert-warning m-2" role="alert">Para que tu comercio esté visible debes: <br><a href="{{route('product.create')}}" class="alert-link">Crear un producto</a></div>
            @else
              <a href="{{route('restaurant.show', Auth::user()->restaurant->slug)}}" target=”_blank” >Ver perfil</a>
            @endif
          @elseif(Auth::user()->restaurant->state=='pending')
            <div class="alert alert-warning m-2" role="alert">Tu comercio está pendiente de aprobación</div>
          @elseif(Auth::user()->restaurant->state=='cancelled')
            <div class="alert alert-danger m-2" role="alert">Tu comercio fue cancelado</div>
          @endif
          <hr>
        </div>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="{{route('restaurant.index')}}"><strong>Escritorio</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{route('product.index')}}"><strong>Menú</strong></a>
            <ul>
                <li class="nav-item">
                <a class="nav-link active" href="{{route('product.index')}}">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('category.index')}}">Categorías</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link active" href="#">Tamaños</a>
                </li> --}}
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#"><strong>Configuración</strong></a>
            <ul>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('restaurant.info')}}">Información del comercio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('restaurant.times')}}">Horarios</a>
                </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      @yield('main')
    </main>
  </div>
</div>
@endsection