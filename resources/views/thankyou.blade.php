@extends('layouts.app')

@section('content')
<section class="jumbotron" style="background: url('https://images.pexels.com/photos/2733918/pexels-photo-2733918.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px 40% / cover transparent;">
    <div class="container text-white text-center">
       <h1>Gracias</h1>
    </div>
</section>

<div class="container">
    <div class="row text-center">
        <div class="col-12">
        <h1>Tu pedido fue enviado al comercio</h1>
        <p>Te llegara un email cuando el comercio confirme tu pedido</p>

        <div class="row justify-content-center mt-5">
            <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-center align-items-center mb-3">
                <span>Tu pedido</span>
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">Product name</h6>
                    <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$12</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">Second product</h6>
                    <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$8</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <h6 class="my-0">Third item</h6>
                    <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$5</span>
                </li>
                <li class="list-group-item d-flex justify-content-between bg-light">
                <div class="text-success">
                    <h6 class="my-0">Promo code</h6>
                    <small>EXAMPLECODE</small>
                </div>
                <span class="text-success">-$5</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                <span>Total </span>
                <strong>$20</strong>
                </li>
            </ul>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="d-flex justify-content-center mb-5">
            <a class="btn btn-primary" href="{{route('home')}}">Volver a inicio</a>
        </div>
    </div>
</div>

@endsection