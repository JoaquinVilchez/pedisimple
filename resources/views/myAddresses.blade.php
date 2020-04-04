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
                <span><strong>Joaquin</strong></span>
            </div>
            <hr>
            
            <div class="list-group mb-3">
                <a href="{{route('myAddresses')}}" class="list-group-item active py-1">Mis direcciones</a>
                <a href="{{route('myOrders')}}" class="list-group-item py-1">Mis pedidos</a>
                <a href="{{route('myAccount')}}" class="list-group-item py-1">Mis datos</a>
                
            </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-8 mb-3">
            <h5>Mis direcciones <small>(2)</small></h5>
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td>Chacacbuco 315 - Venado Tuerto</td>
                        <td><a href="#"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                    <tr>
                        <td>Saavedra 663 - Venado Tuerto</td>
                        <td><a href="#"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                </tbody>
            </table>
            <a href="#">+ Agregar direccion</a>
        </div>
            
    </div>
</div>

@endsection