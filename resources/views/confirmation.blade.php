@extends('layouts.app')

@section('css-scripts')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('css/bs-stepper.min.css')}}">
@endsection

@section('content')
<section class="jumbotron" style="background: url('https://images.pexels.com/photos/2733918/pexels-photo-2733918.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px 40% / cover transparent;">
    <div class="container text-white text-center">
       <h1>Tu Pedido</h1>
    </div>
</section>
<div class="container">
        <div class="row">
            <div class="col-md-12">        
                <div class="container flex-grow-1 flex-shrink-0">
                    <div class="p-0">
                      <div id="stepper1" class="bs-stepper">
                        <div class="bs-stepper-header" role="tablist">

                          <div class="step" data-target="#test-l-1">
                              <span class="bs-stepper-circle success"><i class="fas fa-check"></i></span>
                              <span class="bs-stepper-label">Confirmado</span>
                          </div>

                          <div class="bs-stepper-line"></div>
                          <div class="step" data-target="#test-l-2">
                            
                              <span class="bs-stepper-circle">2</span>
                              <span class="bs-stepper-label">En camino</span>
                            
                          </div>
                          <div class="bs-stepper-line"></div>
                          <div class="step" data-target="#test-l-3">
                            
                              <span class="bs-stepper-circle">3</span>
                              <span class="bs-stepper-label">Entregado</span>
                            
                          </div>
                        </div>
                    </div>
                </div>

            <div class="justify-content-center text-center my-4">
                <h1>Tu pedido fue confirmado</h1>
                <p>El comercio esta preparando tu pedido</p>
                <hr width="30%" style="p-0">
                <small>Tiempo estimado de entrega: <strong>30 minutos</strong></small><br>

                <img width="30%" src="https://st4.depositphotos.com/16470190/22711/v/1600/depositphotos_227117196-stock-illustration-concept-illustration-of-the-restaurant.jpg" alt="">
            </div>
        </div>

</div>
  <!-- /.Horizontal Steppers -->
@endsection

@section('js-scripts')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="dist/js/bs-stepper.min.js"></script>
    <script src="js/main.js"></script>
@endsection