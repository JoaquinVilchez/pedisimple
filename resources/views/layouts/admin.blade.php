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
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="{{route('restaurant.index')}}"><strong>Escritorio</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#"><strong>Menú</strong></a>
            <ul>
                <li class="nav-item">
                <a class="nav-link active" href="{{route('product.index')}}">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('category.index')}}">Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Tamaños</a>
                </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="#"><strong>Configuración</strong></a>
            <ul>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Información del comercio</a>
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Información general</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Ubicación</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Tamaños</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Cargos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Horarios</a>
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