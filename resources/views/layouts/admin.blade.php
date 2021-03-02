@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <hr>

        {{-- <nav class="nav d-none d-xl-block">
          <ul class="nav flex-column">
            
            <li class="nav-item">
              <a class="nav-link" id="link-comercios" href="{{route('restaurant.admin.list')}}">Comercios</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" id="link-invitaciones" href="{{route('invitation.index')}}">Invitaciones</a>
            </li>
            
          </ul>
        </nav> --}}

        <nav class="nav d-none d-xl-block">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" id="link-comercios" href="{{route('restaurant.admin.list')}}">Comercios</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#subscripcionesCollapse" role="button" aria-expanded="false" aria-controls="subscripcionesCollapse">
                <div class="d-flex justify-content-between">
                <span>Subscripciones</span>
                <i class="fas fa-chevron-down"></i>
                </div>
                </a>
            </li>
            <div class="collapse nav-pills" id="subscripcionesCollapse">
              <ul class="list-unstyled ml-3">
                <li class="nav-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <span><a class="nav-link" id="planes" href="{{route('order.new')}}">Planes</a></span>
                  </div>

                </li>
                <li class="nav-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <span><a class="nav-link" id="aceptados" href="{{route('order.accepted')}}">Aceptados</a></span>
                  </div>
                </li>
                <li class="nav-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <a class="nav-link" id="cerrados" href="{{route('order.closed')}}">Cerrados</a>
                  </div>
                </li>
              </ul>
            </div>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#configuracionCollapse" role="button" aria-expanded="false" aria-controls="configuracionCollapse">
                <div class="d-flex justify-content-between">
                <span>Configuración</span>
                <i class="fas fa-chevron-down"></i>
                </div>
              </a>
            </li>
            <div class="collapse nav-pills" id="configuracionCollapse">
              <ul class="list-unstyled ml-3"> 
                <li class="nav-item">
                    <a class="nav-link" id="informacion" href="{{route('restaurant.info')}}">Información</a>
                </li>
              </ul>
            </div>
          </ul>
        </nav>
        
      </div>

    </nav>

    <main role="main" class="col-xl-10 col-lg-12 px-4">
      @yield('main')
    </main>
  </div>
</div>

<script>
  var url = window.location.pathname;  
  const parts = url.split('/');
  var activePage = parts[3];
  
  console.log(url,parts,activePage);
  
  document.getElementById('link-'+activePage).classList.add("txt-bold");

</script>
@endsection