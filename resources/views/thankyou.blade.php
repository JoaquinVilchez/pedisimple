@extends('layouts.app')

@section('content')

<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 text-center">
            <img src="{{asset('images/design/customer.svg')}}" width="80px" class="my-4">
            <h4 class="txt-bold">¡Listo!</h4>
            <h4 class="txt-bold">Tu pedido fue enviado al comercio</h4>
            <p>Le hemos enviado una notificación al comercio con tu pedido.<br>El comercio se comunicará por WhatsApp contigo a la brevedad.</p>
            <div class="d-flex justify-content-center my-2">
                <div class="border rounded" style="width:70%">
                    <small>Código de referencia <i class="far fa-question-circle"  data-toggle="tooltip" data-placement="right" title="Este código identifica a tu pedido."></i></small>
                    <h1 class="txt-bold">{{$code}}</h1>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="d-flex justify-content-center my-4">
        <div class="col-12 col-md-10">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 mb-3">
                    <h5 class="text-muted">Productos pedidos</h5>
                    <ul class="list-group">
                    @foreach($items as $item)
                        <li class="list-group-item d-flex justify-content-between lh-condensed py-2">
                        <div>
                            <h6 class="my-0">{{ucwords($item->product->name)}} <small class="text-muted">x{{$item->quantity}}</small>
                                @if(isset($item->variants))
                                <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="{{implode(', ', $item->showVariants())}}"></i>
                                @endif                        
                            </h6>
                        </div>
                        <span class="text-muted">${{$item->quantity*$item->price}}</span>
                        </li>
                    @endforeach
                        <li class="list-group-item d-flex justify-content-between py-1" style="border-top:2px solid #ffa64d">
                            <small class="text-mute py-1"><span>Subtotal</span></small>
                            <small class="text-mute py-1"><span>${{$order->subtotal}}</span></small>
                        </li>
                        @if($order->shipping_method=='delivery')
                        <li class="list-group-item d-flex justify-content-between py-1">
                            <small class="text-mute py-1"><span>Delivery</span></small>
                            <small class="text-mute py-1"><span>${{$order->delivery}}</span></small>
                        </li>
                            <div class="alert alert-warning py-1 mb-0" style="font-size: 12px; border-radius: 0px 0px 2px 2px" role="alert">
                                <i class="fas fa-exclamation-circle"></i> El precio del delivery puede variar en base a la distancia.
                            </div>
                        @endif
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total </span>
                            <strong>${{$order->total}}</strong>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <hr class="d-block d-md-none">
                    <h5 class="text-muted">Detalles del pedido</h5>
                    <div class="row ml-3">
                        <div class="d-flex align-items-center">
                            <div class="float-right">
                                <img src="{{asset('images/uploads/commerce/'.$restaurant->image)}}" width="80px" class="border rounded mr-2">
                            </div>
                            <div class="float-left">
                                <h5 class="txt-bold mb-0">{{$restaurant->name}}</h5>
                                <div class="mt-1">
                                    <small><p class="ml-1 my-0"><i class="fab fa-whatsapp"></i><a target=”_blank” href="https://wa.me/549{{str_replace('-','',$restaurant->getPhone())}}"> {{$restaurant->getPhone()}}</a></p></small>
                                    <small><p class="ml-1 my-0"> @if($order->shipping_method=='pickup') <i class="fas fa-store"></i> @else <i class="fas fa-motorcycle"></i> @endif {{ucwords($order->getShippingMethod())}}</p></small>
                                </div>
                            </div>            
                        </div>
                    </div>
                    <div class="m-3">
                        <a target="_blank" href="{{route('checkout.download', $order)}}" class="btn btn-sm btn-outline-danger mb-3"><i class="far fa-file-alt"></i> Descargar detalle</a>
                        @if($order->user_id==null)
                            <p style="font-size: .8em" class="mb-1"><strong>Atención:</strong> Al realizar el pedido como invitado, este detalle no se puede volver a consultar, te recomendamos guardar el código de referencia o descargar el detalle.</p>
                        @else
                            <p style="font-size: .8em" class="mb-1">Podés consultar todos tus pedidos haciendo <a style="color:#0085FF; text-decoration:underline" target="_blank" href="{{route('order.index')}}" >click aquí</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center my-4">
        <div class="row" style="text-align: center">
            <a style="font-size: .8em;color:#0085FF; text-decoration:underline" href="/" >Volver a inicio</a>
        </div>
    </div>
    <hr class="mb-1">
    <div class="d-flex justify-content-center mb-4">
        <small><p class="my-0 text-muted" style="text-align: center"><i class="fas fa-exclamation-circle"></i> Pedí Simple no responsabiliza ante cualquier inconveniente con el producto o envío.</p></small>
    </div>
</div>

@endsection
