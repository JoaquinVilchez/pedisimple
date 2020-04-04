@extends('layouts.app')

@section('content')

<section class="jumbotron text-center p-5" style="background: url('https://images.pexels.com/photos/1435907/pexels-photo-1435907.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px / cover transparent;">
    <div class="container">
      <h1 class="text-white" style="text-shadow: 0px 5px 8px rgba(0,0,0,0.6);"><strong>56 locales para Santiago 1078</strong></h1>
    </div>
</section>
  <!-- Page Content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-2">

        <div class="list-group">
            <p><strong>Filtros</strong></p>
            <a href="#" class="list-group-item py-1">Pizzas</a>
            <a href="#" class="list-group-item py-1">Empanadas</a>
            <a href="#" class="list-group-item py-1">Hamburguesas</a>
            
        </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-8">
            <div class="card p-2 mb-2">
                <div class="row">
                    <div class="col-3 pr-0">
                    <img class="d-block border m-1" width="120px" src="https://img.pystatic.com/restaurants/green-eat-billinghurst.jpg" alt="">
                    </div>
                    <div class="col-9 pl-0">
                    <div class="card-block mt-2">
                        <!--           <h4 class="card-title">Small card</h4> -->
                        <h5><strong><a href="#">Green Eat</a></strong></h5>
                        <p>Jujuy 229, Venado Tuerto, Santa Fe</p>
                        <small>Pizzas - Empanadas</small>
                        <br>
                        <a href="{{route('profile')}}" class="btn btn-primary btn-sm float-right">Ver Productos</a>
                    </div>
                    </div>
                </div>
            </div>
            <div class="card p-2 mb-2">
                <div class="row">
                    <div class="col-3 pr-0">
                    <img class="d-block border m-1" width="120px" src="https://img.pystatic.com/restaurants/green-eat-billinghurst.jpg" alt="">
                    </div>
                    <div class="col-9 pl-0">
                    <div class="card-block mt-2">
                        <!--           <h4 class="card-title">Small card</h4> -->
                        <h5><strong><a href="#">Green Eat</a></strong></h5>
                        <p>Jujuy 229, Venado Tuerto, Santa Fe</p>
                        <small>Pizzas - Empanadas</small>
                        <br>
                        <a href="{{route('profile')}}" class="btn btn-primary btn-sm float-right">Ver Productos</a>
                    </div>
                    </div>
                </div>
            </div>
            <div class="card p-2 mb-2">
                <div class="row">
                    <div class="col-3 pr-0">
                    <img class="d-block border m-1" width="120px" src="https://img.pystatic.com/restaurants/green-eat-billinghurst.jpg" alt="">
                    </div>
                    <div class="col-9 pl-0">
                    <div class="card-block mt-2">
                        <!--           <h4 class="card-title">Small card</h4> -->
                        <h5><strong><a href="#">Green Eat</a></strong></h5>
                        <p>Jujuy 229, Venado Tuerto, Santa Fe</p>
                        <small>Pizzas - Empanadas</small>
                        <br>
                        <a href="{{route('profile')}}" class="btn btn-primary btn-sm float-right">Ver Productos</a>
                    </div>
                    </div>
                </div>
            </div>
            <div class="card p-2 mb-2">
                <div class="row">
                    <div class="col-3 pr-0">
                    <img class="d-block border m-1" width="120px" src="https://img.pystatic.com/restaurants/green-eat-billinghurst.jpg" alt="">
                    </div>
                    <div class="col-9 pl-0">
                    <div class="card-block mt-2">
                        <!--           <h4 class="card-title">Small card</h4> -->
                        <h5><strong><a href="#">Green Eat</a></strong></h5>
                        <p>Jujuy 229, Venado Tuerto, Santa Fe</p>
                        <small>Pizzas - Empanadas</small>
                        <br>
                        <a href="{{route('profile')}}" class="btn btn-primary btn-sm float-right">Ver Productos</a>
                    </div>
                    </div>
                </div>
            </div>

            <nav aria-label="..." class="float-right mt-3">
                <ul class="pagination">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
        </div>
    </div>
</div>

<div class="col-12">
<div class="row justify-content-center" style="background-color:white">        
    <section class="text-center">
        <div class="container my-5">
            <p>Tenes un comercio y queres estar en la plataforma? <a href="#">Trabaja con nosotros</a></p>
        </div>
    </section>
</div>
</div>

@endsection