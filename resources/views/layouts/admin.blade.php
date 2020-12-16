@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">

        <div class="card my-4" style="font-size: .8em">
          <ul class="list-group list-group-flush">
            <li class="list-group-item py-1 d-flex justify-content-between">
              <strong>Comercios</strong>
            </li>
            <li class="list-group-item py-1 d-flex justify-content-between">
              <span>Activos</span>
              <span>{{count(App\Restaurant::where('state', 'active')->get())}}</span>
            </li>
            <li class="list-group-item py-1 d-flex justify-content-between">
              <span>Pendientes</span>
              <span>{{count(App\Restaurant::where('state', 'pending')->get())}}</span>
            </li>
            <li class="list-group-item py-1 d-flex justify-content-between">
              <span>Cancelados</span>
              <span>{{count(App\Restaurant::where('state', 'cancelled')->get())}}</span>
            </li>
            <li class="list-group-item py-1 d-flex justify-content-between">
              <span>Total</span>
              <span>{{count(App\Restaurant::all())}}</span>
            </li>
          </ul>
        </div>

        <hr>

        <nav class="nav d-none d-xl-block">
          <ul class="nav flex-column">
            
            <li class="nav-item">
              <a class="nav-link" id="link-comercios" href="{{route('restaurant.admin.list')}}">Comercios</a>
            </li>

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
  const parts = url.split('/');
  var activePage = parts[3];
  
  console.log(url,parts,activePage);
  
  document.getElementById('link-'+activePage).classList.add("txt-bold");

</script>
@endsection