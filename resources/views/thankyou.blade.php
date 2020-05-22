@extends('layouts.app')

@section('content')
{{-- <section class="jumbotron" style="background: url('https://images.pexels.com/photos/2733918/pexels-photo-2733918.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px 40% / cover transparent;">
    <div class="container text-white text-center">
       <h1>Gracias</h1>
    </div>
</section> --}}

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <img src="{{asset('images/design/customer.svg')}}" width="100px" class="my-4">
            <h3>Tu pedido fue enviado al comercio</h3>
            <p>Le hemos enviado una notificación al comercio con el detalle de tu pedido. Si ellos no se comunican a la brevedad contigo, comunicate vos para poder <strong>confirmar el pedido </strong>.</p>
            <hr>
            <h5 class="txt-bold">{{$order->restaurant->name}}</h5>
            <p>Teléfono: <a href="#">{{$order->restaurant->getPhone()}}</a></p>
            <hr>
        </div>
        <div class="col-8">
            <div class="row justify-content-center mt-2">
                <div class="col-md-6 order-md-2 mb-2">
                    <h5 class="d-flex justify-content-center">
                        Código de referencia:
                    </h5>
                    <h5 class="d-flex justify-content-center">
                        <p class="txt-bold d-inline-block ml-2">{{$code}}</p>
                    </h5>
                    <ul class="list-group mb-3">
                    @foreach($items as $item)
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">{{$item->product->name}}</h6>
                            <small class="text-muted">x{{$item->quantity}}</small>
                        </div>
                        <span class="text-muted">${{$item->product->price}}</span>
                        </li>
                    @endforeach
                        <li class="list-group-item d-flex justify-content-between">
                            <small class="text-mute"><span>Subtotal</span></small>
                            <span>${{$order->subtotal}}</span>
                        </li>
                        @if(Cart::getCondition('Delivery'))
                        <li class="list-group-item d-flex justify-content-between">
                            <small class="text-mute"><span>Delivery</span></small>
                            <span>${{$order->delivery}}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total </span>
                            <strong>${{$order->total}}</strong>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <a href="#" class="btn btn-sm btn-outline-danger"><i class="fas fa-receipt"></i> Descargar detalle</a>
            </div>
        </div>

        <div class="col-8">
            <hr>
            <div class="row justify-content-center mt-2">
                <div class="col-6 text-center">
                    <small class="text-muted">Atención: <br> Este detalle no se puede volver a consultar, recomendamos guardar el código de referencia o descargar el detalle.</small>
                </div>
            </div>
            <div class="row justify-content-center my-2">
                <a class="btn btn-primary" href="{{route('home')}}">Volver a inicio</a>
            </div>
        </div>
    </div>
</div>

@endsection