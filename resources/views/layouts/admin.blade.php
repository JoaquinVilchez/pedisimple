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
          {{-- <img width="100px" src="{{Storage::url(Auth::user()->image)}}" class="img-thumbnail mt-4">
          <h6>{{Auth::user()->fullName()}}</h6> --}}
          <hr>
        </div>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#"><strong>Escritorio</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{route('invitation.index')}}"><strong>Invitaciones</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="{{route('restaurant.admin.list')}}"><strong>Comercios</strong></a>
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