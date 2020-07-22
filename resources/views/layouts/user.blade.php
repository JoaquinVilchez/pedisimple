@extends('layouts.app')

@section('content')

<section class="jumbotron text-center p-5 rounded-0" style="background: url('{{asset('images/banners/food.png')}}') no-repeat scroll 0px / cover transparent;">
    {{-- {{asset('images/banners/food.png')}} --}}
    <div class="container">
      <h1 class="text-white txt-bold" style="text-shadow: 0px 5px 8px rgba(0,0,0,0.6);">Mi Cuenta</h1>
    </div>
</section>
  <!-- Page Content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-3" style="text-align:center">
            <img src="{{asset('images/uploads/user/'.Auth::user()->image)}}" class="img-thumbnail" width="100px">
            <div class="d-flex justify-content-center mb-2">
                <span class="mt-2"><strong>{{Auth::user()->first_name}}</strong></span>
            </div>
            <hr>
            
            {{-- <div class="list-group mb-3">
                <a href="{{route('restaurant.index', Auth::user()->restaurant)}}" class="list-group-item py-1">Mi comercio</a>
            </div> --}}

            <div class="list-group mb-3">
                @role('merchant')
                <a href="{{route('product.index')}}" class="list-group-item py-1">Mi comercio</a>
                @endrole
                <a href="{{route('address.index')}}" class="list-group-item py-1">Mis direcciones</a>
                <a href="{{route('order.index')}}" class="list-group-item py-1">Mis pedidos</a>
                <a href="{{route('user.index')}}" class="list-group-item py-1">Mis datos</a>
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