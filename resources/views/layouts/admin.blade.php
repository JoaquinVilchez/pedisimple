@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <hr>

        <nav class="nav d-none d-xl-block">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" id="link-comercios" href="{{route('restaurant.admin.list')}}">Comercios</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#servicioCollapse" role="button" aria-expanded="false" aria-controls="servicioCollapse">
                <div class="d-flex justify-content-between">
                  Servicio
                <i class="fas fa-chevron-down"></i>
                </div>
                </a>
            </li>
              <div class="collapse nav-pills" id="servicioCollapse">
                <ul class="list-unstyled ml-3">
                  <li class="nav-item">
                      <a class="nav-link" id="link-planes" href="{{route('plan.index')}}">Planes</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="link-suscripciones" href="{{route('subscription.index')}}">Suscripciones</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="link-facturas" href="{{route('plan.index')}}">Facturas</a>
                  </li>
                </ul>
              </div>

            <li class="nav-item">
              <a class="nav-link" id="link-invitaciones" href="{{route('invitation.index')}}">Invitaciones</a>
            </li>
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
  var parts = url.split('/');
  var activeCategory = null;
  var activePage = null;

  if (parts.length==4) {
    activeCategory = parts[2];
    activePage = parts[3];
    console.log('link-'+activePage, parts, parts.length, activeCategory, activePage)
    document.getElementById('link-'+activePage).classList.add("active")
    document.getElementById(activeCategory+'Collapse').classList.add("show")
  }else{
    activePage = parts[2];
    console.log('link-'+activePage, parts, parts.length, activeCategory, activePage)
    document.getElementById('link-'+activePage).classList.add("active")
  }

  console.log('link-'+activePage, parts, parts.length, activeCategory, activePage)


</script>
@endsection