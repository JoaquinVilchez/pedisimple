@extends('layouts.commerce')

@section('css-scripts')
<link rel="stylesheet" href="{{asset('css/ordertable.css')}}">
<link rel="stylesheet" href="{{asset('css/switch.css')}}">
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-4">
        <div class="header-left d-flex align-items-center">
            <h1 class="h2"><strong>Nuevos pedidos</strong> @if(count($orders)>0)<small>({{count($orders)}})</small>@endif</h1>
            <div class="switcher ml-4">
                <label class="switch" data-toggle="tooltip" data-placement="bottom" title="Pausar pedidos">
                    <form action="{{route('restaurant.pauseOrders')}}" method="post" id="pauseOrderForm">
                        @csrf
                        <input name="status" id="pauseOrderStatus" type="checkbox" value="runOrders"
                        @if (Auth::user()->restaurant->getOrderStatus()===1)
                            checked
                        @endif
                        >
                        <span class="slider round"></span>
                    </form>
                </label>
                {{-- <span class="text-muted"><small>Pausar pedidos</small></span> --}}
            </div>
        </div>
        <div class="header-right">
            <div class="mb-2" style="font-size: .8em;">
                <i class="fas fa-question-circle"></i> ¿Tenés dudas? <a target="_autoblank" href="{{route('help.documentation')}}#docs-pedidos" class="txt-semi-bold">Consultar documentación</a>.
            </div>
        </div>
    </div>

    @include('messages')
    @if (Auth::user()->restaurant->getOrderStatus()===0)
        <div class="alert alert-warning" role="alert">
            Ya no recibirás más pedidos hasta que vuelvas a activarlos.
        </div>
    @endif
    @if(count($orders)==0)
    <div style="text-align:center" class="m-auto">
        <img data-original="{{asset('storage/design/complete.svg')}}" alt="" class="img-default my-2">
        <p>No tienes nuevos pedidos.<br>
    </div>  
    @else
        @foreach($orders as $order)
        {{-- MOBILE --}}
        <div class="col-12">
            <div class="order-mobile d-xl-none" width="100%" style="font-size:15px;">
                <div class="card mb-2">
                    <div class="card-header" style="border-bottom:10px solid #ffa64d; border-radius: 5px;padding-bottom:0px;font-size:15px; background-color: white;" id="headingOne">
                        <div class="details">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mobile-title mb-1">Solicitante</p>
                                    <p class="mobile-description"><strong>{{$order->getFullName()}}</strong></p>
                                    <p class="text-muted mobile-title mb-1">Código</p>
                                    <p class="mobile-description"><strong>{{$order->code}}</strong></p>
                                </div>
                                <div class="col-6" style="text-align: right">
                                    <p class="text-muted mobile-title mb-1">Metodo de envío</p>
                                    <p class="mobile-description">{{$order->getShippingMethod()}}</p>
                                    <p class="text-muted mobile-title mb-1">Total</p>
                                    <p class="mobile-description">${{formatPrice($order->total)}}</p>
                                </div>
                            </div>
                        </div>
                    <a class="btn btn-link btn-block mb-0" id="orderButton" type="button" data-toggle="collapse" data-target="#order{{$order->code}}" aria-expanded="true" aria-controls="order{{$order->code}}">
                        Ver detalles <i class="fas fa-chevron-down"></i>
                    </a>
                </div>

                <div id="order{{$order->code}}" class="collapse" aria-labelledby="headingOne" data-parent="#orderButton">
                    <div class="card-body">
                        <div class="container">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="d-block">Productos pedidos: </div>
                                        @foreach($order->lineitems as $item)
                                            <span class="btn btn-sm btn-checkbox my-1">{{$item->product->name}} <small>(x{{$item->quantity}})</small>
                                            @if ($item->variants!=null)
                                                <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="{{implode(', ', $item->showVariants())}}"></i>
                                            @endif
                                            @if ($item->aditional_notes!=null)
                                                <i class="fas fa-sticky-note" data-toggle="tooltip" data-placement="bottom" title="Nota: {{$item->aditional_notes}}"></i>
                                            @endif
                                            </span>
                                        @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <ul class="list-group list-group-flush">
                                        @if($order->shipping_method=='delivery')
                                            <li class="list-group-item"><strong>Dirección: </strong>{{$order->getFullAddress()}}</li>
                                        @endif
                                        <li class="list-group-item"><strong>Contacto: <i class="fab fa-whatsapp mr-1"></i> </strong>
                                            <td>
                                                <a target=”_blank” href="
                                                https://wa.me/549{{str_replace('-','',whatsappNumberCustomer($order))}}?text=
                                                {{urlencode(whatsappMessageCustomer($order))}}
                                                ">
                                                {{whatsappNumberCustomer($order)}}
                                                </a>
                                            </td>
                                        </li>
                                        <li class="list-group-item"><strong>Fecha: </strong>{{ucfirst($order->created_at->diffForHumans())}} </li>
                                    </ul>
                                    <div class="row mt-2">
                                        <p class="txt-bold">Información adicional del cliente:</p><br>
                                        @if($order->client_aditional_notes!=null)
                                            <p>{{$order->client_aditional_notes}}</p>
                                        @else
                                            <p> - </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <a href="#" class="btn btn-secondary btn-block" data-deleteorderid="{{$order->id}}" data-toggle="modal" data-target="#deleteOrderModal">Rechazar</a>
                                <a href="#" class="btn btn-primary btn-block" data-acceptorderid="{{$order->id}}" data-toggle="modal" data-target="#acceptOrderModal">Aceptar</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        {{-- FIN MOBILE --}}
        {{-- DESKTOP --}}
        <div class="col-12">
            <div class="order d-none d-xl-block" width="100%" style="font-size:15px" id="orderHeader" style="font-size:15px">
                <div class="card mb-4">
                    <div class="border-bottom px-2">
                        <table class="table table-borderless" id="orderTable">
                            <thead>
                                {!!$order->delayAlert()!!}
                                <tr>
                                <th>Código</th>
                                <th>Fecha y hora</th>
                                <th>Solicitante</th>
                                <th>Contacto<i class="fab fa-whatsapp ml-1"></i></th>
                                <th>Dirección de entrega</th>
                                <th>Método de envío</th>
                                <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$order->code}}</td>
                                    <td>{{ucfirst($order->created_at->diffForHumans())}}</td>
                                        <td>{{$order->getFullName()}}</td>
                                        <td>
                                            <a target=”_blank” href="
                                            https://wa.me/549{{str_replace('-','',whatsappNumberCustomer($order))}}?text=
                                            {{urlencode(whatsappMessageCustomer($order))}}
                                            ">
                                            {{whatsappNumberCustomer($order)}}
                                            </a>
                                        </td>
                                        @if($order->shipping_method=='delivery')
                                            <td>{{$order->getFullAddress()}}</td>
                                            @else
                                            <td> - </td>
                                        @endif
                                    <td>{{$order->getShippingMethod()}}</td>
                                    <td>${{formatPrice($order->total)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body" id="orderBody">
                        <div class="row mb-2">
                            <div class="col-2">
                                <div class="d-inline" style="width: 10px">Productos pedidos: </div>
                            </div>
                            <div class="col-8">
                                <div class="d-inline">
                                    @foreach($order->lineitems as $item)
                                        <span class="btn btn-sm btn-checkbox my-1">{{$item->product->name}} <small>(x{{$item->quantity}})</small>
                                        @if ($item->variants!=null)
                                            <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="{{implode(', ', $item->showVariants())}}"></i>
                                        @endif
                                        @if ($item->aditional_notes!=null)
                                            <i class="fas fa-sticky-note" data-toggle="tooltip" data-placement="bottom" title="Nota: {{$item->aditional_notes}}"></i>
                                        @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-2">
                            </div>
                        </div>
                    </div>
                    <div id="orderFooter" class="px-4">
                        <div class="row mb-2">
                            <div class="col-8">
                                <p class="txt-bold">Información adicional del cliente</p>
                                @if($order->client_aditional_notes!=null)
                                    <p>{{$order->client_aditional_notes}}</p>
                                @else
                                    <p> - </p>
                                @endif
                            </div>
                            <div class="col-4">
                                <div class="float-right d-flex">
                                    <div class="d-inline mr-2">
                                        @if($order->delayHours() >= 24)
                                            <form action="{{route('order.cancel')}}" method="POST">
                                                @csrf
                                                <input type="hidden" id="orderid" name="orderid" value="{{$order->id}}">
                                                <button type="submit" class="btn btn-danger">Cancelar pedido</button>
                                            </form>
                                        @else
                                            <a href="#" class="btn btn-secondary" data-deleteorderid="{{$order->id}}" data-toggle="modal" data-target="#deleteOrderModal">Rechazar</a>
                                            <a href="#" class="btn btn-primary" data-acceptorderid="{{$order->id}}" data-toggle="modal" data-target="#acceptOrderModal">Aceptar</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- FIN DESKTOP --}}
        @endforeach
    @endif

@if(count($orders)!=0)
    <!-- Modal -->
    <div class="modal fade" id="acceptOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Aceptar pedido</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" style="text-align: center">
                <h5>¿Estás seguro de aceptar este pedido?</h5>
                <div class="row d-flex justify-content-center mt-4">
                    <label><i class="far fa-clock"></i> Indica a tu cliente la demora del pedido</label>
                    <div class="col-6">
                        <div class="form-group" width="50%">
                            <select name="delay_time" id="delay_time" class="form-control">
                                @for ($i = 10; $i <= 60; $i=$i+5)
                                    <option value="{{$i}}" @if (Auth::user()->restaurant->shipping_time == $i) selected @endif>{{$i}} Minutos</option>
                                @endfor
                                <option value="0">Más de una hora</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <small>Al aceptar el pedido te redireccionaremos a WhatsApp con un mensaje que contiene el detalle completo del pedido para tu cliente.</small>
                <input type="hidden" id="acceptorderid" name="acceptorderid" value="" hidden>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-outline-secondary btn-block" data-dismiss="modal">Cancelar</button> --}}
                <button type="button" href="#"
                    class="btn btn-success btn-block" onclick="acceptOrder()"><i class="fab fa-whatsapp"></i> Confirmar
                </button>
                <div class="mx-auto">
                    <small><a href="#" data-dismiss="modal" class="docs-link">Cancelar</a></small>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Rechazar pedido</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <h5>¿Estás seguro de rechazar este pedido?</h5>
                <input type="hidden" id="deleteorderid" name="deleteorderid" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" href="#" class="btn btn-danger" onclick="rejectOrder()"><i class="fab fa-whatsapp"></i>Eliminar</button>
            </div>
        </div>
        </div>
    </div>
@endif

@endsection

@section('js-scripts')
<script>

$('#pauseOrderStatus').on('change', function(){
    $('#pauseOrderForm').submit();
})

$('#deleteOrderModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget)

    var deleteorderid = button.data('deleteorderid')
    var modal = $(this)

    modal.find('.modal-body #deleteorderid').val(deleteorderid)
})

$('#acceptOrderModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget)

    var acceptorderid = button.data('acceptorderid')
    var modal = $(this)

    modal.find('.modal-body #acceptorderid').val(acceptorderid)
})

function acceptOrder(){
    var acceptorderid = $('#acceptorderid').val();
    var delay_time = $('#delay_time').val();
    $.ajax({
        url:"{{ route('order.accept') }}",
        type:"POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data:{acceptorderid:acceptorderid,delay_time:delay_time},
        success:function(data) {
            var id = (new Date()).getTime();
            var myWindow = window.open(data, id);
            $.post("{{ route('order.accept') }}", data).done(function(htmlContent) {
                myWindow.document.write(htmlContent);
                myWindow.focus();
            });
            location.reload();
        }
    })
};

function rejectOrder(){
    var deleteorderid = $('#deleteorderid').val();
    $.ajax({
        url:"{{ route('order.reject') }}",
        type:"POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data:{deleteorderid:deleteorderid},
        success:function(data) {
            var id = (new Date()).getTime();
            var myWindow = window.open(data, id);
            $.post("{{ route('order.reject') }}", data).done(function(htmlContent) {
                myWindow.document.write(htmlContent);
                myWindow.focus();
            });
            location.reload();
        }
    })
};

</script>
@endsection