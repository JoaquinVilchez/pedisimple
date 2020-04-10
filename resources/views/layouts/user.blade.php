@extends('layouts.app')

@section('content')

<section class="jumbotron text-center p-5" style="background: url('https://images.pexels.com/photos/3184192/pexels-photo-3184192.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px / cover transparent;">
    <div class="container">
      <h1 class="text-white" style="text-shadow: 0px 5px 8px rgba(0,0,0,0.6);"><strong>Mi Cuenta</strong></h1>
    </div>
</section>
  <!-- Page Content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-2">
            <img src="https://images.pexels.com/photos/1310522/pexels-photo-1310522.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" class="img-thumbnail">
            <div class="d-flex justify-content-center mb-2">
                <span><strong>{{Auth::user()->first_name}}</strong></span>
            </div>
            <hr>
            
        <div class="list-group mb-3">
            <a href="{{route('myAddresses')}}" class="list-group-item py-1">Mi comercio</a>
        </div>

        <div class="list-group mb-3">
            <a href="{{route('myAddresses')}}" class="list-group-item py-1">Mis direcciones</a>
            <a href="{{route('myOrders')}}" class="list-group-item py-1">Mis pedidos</a>
            <a href="{{route('myAccount')}}" class="list-group-item py-1">Mis datos</a>
        </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-8 mb-3">
                        <!-- Mensajes -->
            @if (session('success_message'))
                <div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
                    <strong>{{session('success_message') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @yield('info-content')
        </div>
            
    </div>
</div>

@endsection