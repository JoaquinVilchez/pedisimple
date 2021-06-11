@extends('layouts.app')

@section('content')

<section class="jumbotron rounded-0 text-center p-0 mb-0" 
    style="background: url('https://images.pexels.com/photos/1435907/pexels-photo-1435907.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px / cover transparent;
    position: relative;">
    <div style="background-color: rgba(0, 0, 0, 0.6);">
        @if($order->state=='pending')
            <div class="container text-white py-2 d-flex justify-content-center align-items-center">
                <div class="content mt-3">
                    <h4 class="txt-bold">¡Listo! Tu pedido fue enviado al comercio</h4>
                    <p>Le hemos enviado una notificación al comercio con tu pedido. <br> El comercio se comunicará por WhatsApp contigo a la brevedad para confirmar el pedido.</p>
                </div>
            </div>
            <div class="footer text-white m-2">
                <small><i class="fas fa-exclamation-circle"></i> Recuerda que debes esperar la confirmación del pedido por parte del comercio para completar el mismo.</small>
            </div>
        @elseif($order->state == 'accepted')
            <div class="container text-white py-2 d-flex justify-content-center align-items-center">
                <div class="content mt-3">
                    <h4 class="txt-bold">¡El comercio aceptó tu pedido!</h4>
                    <p>Te irán informando el transcurso del pedido a través de WhatsApp.</p>
                    <div>
                        <p style="font-size:.8em" class="m-0">Tiempo estimado de entrega</p>
                        <h5 class="txt-bold">{{$order->estimatedDeliveryTime()}}</h5>
                    </div>
                </div>
            </div>
            @if ($order->state=='pending')
                <div class="footer text-white m-2">
                    <small><i class="fas fa-exclamation-circle"></i> Recuerda que debes esperar la confirmación del pedido por parte del comercio para completar el mismo.</small>
                </div>
            @endif
        @elseif($order->state == 'cancelled')
            <div class="container text-white py-2 d-flex justify-content-center align-items-center">
                <div class="content my-3">
                    <h4 class="txt-bold">¡El pedido fue cancelado!</h4>
                    <p>Comunicate con el comercio o realiza un nuevo pedido.</p>
                </div>
            </div>
        @endif
    </div>
</section>

<div class="container">
    @if ($order->state != 'cancelled')
    <div class="row">
        <div class="col-md-8 col-12">
            <h5 class="my-3 text-center">Resumen del pedido realizado a <strong>{{$restaurant->name}}</strong></h5>
            <hr class="my-0">
            <div class="row mt-3">
                <div class="col-md-6 col-12">
                    <ul class="list-unstyled text-md-left text-center">
                        <li>
                            <strong>Responsable del pedido</strong>
                            <small class="text-muted"><p><i class="fas fa-user"></i> {{$order->getFullName()}}</p></small>
                        </li>
                        <li>
                            @if ($order->shipping_method=='delivery')
                                <strong>Dirección de entrega</strong>
                                <small class="text-muted"><p><i class="fas fa-map-marker-alt"></i> {{$order->getFullAddress()}}</p></small>
                            @else
                                <strong>Dirección del comercio</strong>
                                <small class="text-muted"><p><i class="fas fa-map-marker-alt"></i> {{$restaurant->address->getFullAddress()}}</p></small>
                            @endif
                        </li>
                        @if ($order->state=='pending')
                            @if ($restaurant->approximateDeliveryTime()!='no-data')
                                <li>
                                    <strong>Tiempo estimado de entrega</strong>
                                    <small class="text-muted"><p><i class="far fa-clock"></i> {{$restaurant->approximateDeliveryTime()}}</p></small>
                                </li>
                            @endif
                        @else
                            <li>
                                <strong>Demora establecida</strong>
                                <small class="text-muted"><p><i class="far fa-clock"></i> {{$order->getDelayTime()}}</p></small>
                            </li>
                        @endif
                        <li>
                            <small class="text-muted"><a target="_blank" href="{{route('checkout.download', Crypt::encryptString($order->id))}}"><i class="fas fa-receipt"></i> Descargar detalle</a></small>
                        </li>
                        @if($order->user_id!=null)
                            <li>
                                <small class="text-muted"><a target="_blank" href="{{route('order.index')}}"><i class="fas fa-eye"></i> Ver mis pedidos</a></small>
                            </li>
                        @endif
                    </ul>

                    <hr class="d-sm-block d-md-none">
                </div>

                <div class="col-md-6 col-12">
                    <p class="text-muted text-md-left text-center"><i class="fas fa-concierge-bell"></i> Detalle del pedido <small>(Cod Ref: {{$order->code}})</small></p>
                    <ul class="list-group">
                        @foreach($items as $item)
                            <li class="list-group-item d-flex justify-content-between lh-condensed py-1">
                                <p class="my-0">{{ucwords($item->product->name)}} <small class="text-muted">x{{$item->quantity}}</small>
                                    @if(isset($item->variants))
                                    <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="{{implode(', ', $item->showVariants())}}"></i>
                                    @endif
                                </p>
                            <span class="text-muted">${{formatPrice($item->quantity*$item->price)}}</span>
                            </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between py-1" style="border-top:2px solid #ffa64d">
                            <small class="text-mute py-1"><span>Subtotal</span></small>
                            <small class="text-mute py-1"><span>${{$order->subtotal}}</span></small>
                        </li>
                        @if($order->shipping_method=='delivery')
                        <li class="list-group-item d-flex justify-content-between py-1">
                            <small class="text-mute py-1"><span>Delivery</span></small>
                            <small class="text-mute py-1"><span>${{formatPrice($order->delivery)}}</span></small>
                        </li>
                            <div class="alert alert-warning py-1 mb-0" style="font-size: 12px; border-radius: 0px 0px 2px 2px" role="alert">
                                <i class="fas fa-exclamation-circle"></i> El precio del delivery puede variar respecto a la distancia.
                            </div>
                        @endif
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total </span>
                            <strong>${{formatPrice($order->total)}}</strong>
                        </li>
                    </ul>
                    
                    <hr class="d-sm-block d-md-none">
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="row mx-2 text-md-left text-center">
                <ul class="list-unstyled mb-0" style="font-size:.8em">
                    <h5 class="my-3"><strong>Información adicional</strong></h5>
                    <li>
                        @if ($order->state=='pending')
                            @if ($restaurant->averageAcceptanceOfOrders() == 0)
                                <p><i class="far fa-clock"></i> El comercio todavía no aceptó ningún pedido hoy, espera unos minutos y ya lo aceptarán.</p>
                            @else
                                <p><i class="far fa-clock"></i> El comercio hoy esta tardando <strong>aproximadamente {{$restaurant->averageAcceptanceOfOrders()}} minutos</strong> en aceptar un pedido.</p>
                            @endif
                        @endif
                    </li>
                    <li>
                        <p><i class="fas fa-info-circle"></i> Ante cualquier problema con el comercio, podés comunicarte con ellos al <a href="#">{{$restaurant->getPhone()}}</a></p>
                    </li>
                </ul>

                <hr class="d-sm-block d-md-none">

                <div class="col-12 px-0">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12">
                            <div class="accordion" id="problemsAccordion">
                                <div class="card">
                                    <button class="btn btn-sm btn-outline-danger btn-block text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fas fa-life-ring"></i> ¿Algún problema?
                                    </button>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#problemsAccordion">
                                        <div class="card-body p-0 text-center">
                                            <table class="table table-hover p-0 m-0">
                                                <tr>
                                                    <td class="p-1"><a href="#" class="btn btn-sm btn-link p-0" data-toggle="modal" data-target="#cancelOrderModal">Quiero cancelar el pedido.</a></td>
                                                </tr>
                                                @if ($order->state=='pending')
                                                    <tr>
                                                        <td class="p-1">
                                                            <a target=”_blank” href="
                                                                https://wa.me/549{{str_replace('-','',env('APP_NUMBER'))}}?text={{urlencode(delayedOrder($order))}}"
                                                                class="btn btn-sm btn-link p-0">
                                                                El comercio todavía no me confirmó el pedido.
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12 text-center my-3">
            <p>Desconocemos el motivo de la cancelación.</p>
            <p>Puedes comunicarte con {{$restaurant->name}} al {{$restaurant->getPhone()}} o <a href="{{route('restaurant.show', $restaurant->slug)}}" class="docs-link">hacer un nuevo pedido</a></p>
        </div>
    </div>
    @endif
    <div class="row d-flex justify-content-center mt-4">
        <div class="col-md-6 col-12 d-flex justify-content-center">
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#helpUsToImprove">    
                Ayudanos a mejorar
            </button>
        </div>
    </div>
    <hr>

    <div class="row d-flex justify-content-center ">
        <div class="flex-wrap text-center">
            <a style="font-size: .8em;color:#0085FF; text-decoration:underline" href="/" >Volver a inicio</a><br>
            <small><p class="my-0 text-muted text-center m-2"><i class="fas fa-exclamation-circle"></i> Pedí Simple no responsabiliza ante cualquier inconveniente con el producto o envío.</p></small>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="helpUsToImprove" tabindex="-1" aria-labelledby="helpUsToImproveLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <iframe id="" allowtransparency="true" allowfullscreen="true" allow="geolocation; microphone; camera" src="https://my.forms.app/form/60b40e2cb42c292b4c69d6d9" frameborder="0" style="width: 1px; min-width:100%; height:500px; border:none;"></iframe>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cancelOrderLabel">Cancelar pedido</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
            <div id="question">
                <h3 class="loadingIcon d-none"><i class="fas fa-spinner fa-spin"></i></h3>
                <h3 class="questionIcon"><i class="far fa-question-circle"></i></h3>
                <h5>¿Estás seguro de cancelar este pedido?</h5>
                <p>Se le informará al comercio y no se podrá revertir.</p>
            </div>
            <div id="response-success">
                <h3><i class="far fa-check-circle" style="color:#3ac100"></i></h3>
                <h4>Pedido cancelado con éxito</h4>
            </div>
            <div id="response-error">
                <h3><i class="far fa-times-circle" style="color:#d30000"></i></h3>
                <h4>No pudimos cancelar el pedido</h4>
                <p>El comercio ya aceptó o cerró el pedido. Te recomendamos comunicarte con ellos para cancelar el mismo.</p>
                <a target=”_blank” href="https://wa.me/549{{str_replace('-', '', $order->restaurant->getPhone())}}"><i class="fab fa-whatsapp"></i> {{$order->restaurant->getPhone()}}</a>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="cancelOrder({{$order->id}})">Confirmar</button>
        </div>
      </div>
    </div>
</div>

@endsection

@section('js-scripts')
    <script>

        $(document).ready(function() {
            $('#response-success').hide();
            $('#response-error').hide();
        });

        function cancelOrder(orderid){
            $('.loadingIcon').removeClass('d-none');
            $('.questionIcon').addClass('d-none');
            $('#cancelOrderModal').find('.modal-header').hide();
            $('#cancelOrderModal').find('.modal-footer').hide();
            url = "{{env('APP_URL')}}"
            $.ajax({
                url : '{{ route("order.userCancel") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{orderid:orderid},
                success:function(data){
                        if(data==true){
                            $('#question').hide();
                            $('#response-success').show();
                            setTimeout(function(){ 
                                $('#cancelOrderModal').modal('hide');
                                window.location.href = url;
                            }, 500);
                        }else{
                            console.log(data)
                            $('#question').hide();
                            $('#response-error').show();
                        }
                }
            });
        }
    </script>
@endsection