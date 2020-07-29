@extends('layouts.commerce')

@section('css-scripts')
<style>
    #orderTable thead tr th{
        padding-bottom:0px;
        font-size: 13px;
    }
    #orderTable tbody tr td{
        padding-top:0px;
        padding-bottom: 2px;
        font-size: 13px;
    }

    #orderFooter p{
        margin-bottom: 0px;
        font-size: 13px;
    }
</style>
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-4">
        <h1 class="h2"><strong>Pedidos aceptados</strong></h1>
    </div>

    @include('messages')
    @if(count($orders)==0)
    <div style="text-align:center" class="m-auto">
        <img src="{{asset('images/design/complete.svg')}}" alt="" class="img-default my-2">
        <p>No tienes pedidos aceptados.<br>
    </div>  
    @else
        @foreach($orders as $order)
        {{-- MOBILE --}}
        <div class="col-12">
            <div class="order-mobile d-xl-none" width="100%">
                <div class="card mb-2">
                    <div class="card-header" style="border-bottom:10px solid #ffa64d; border-radius: 5px;padding-bottom:0px;font-size:15px" id="headingOne">
                        <div class="details">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mobile-title">Solicitante</p>  
                                    <p class="mobile-description"><strong>{{$order->getFullName()}}</strong></p>
                                    <p class="text-muted mobile-title">Código</p>  
                                    <p class="mobile-description"><strong>{{$order->code}}</strong></p>
                                </div>
                                <div class="col-6" style="text-align: right">
                                    <p class="text-muted mobile-title">Metodo de envío</p>
                                    <p class="mobile-description">{{$order->getShippingMethod()}}</p>
                                    <p class="text-muted mobile-title">Total</p>
                                    <p class="mobile-description">${{$order->total}}</p>
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
                                            <li class="list-group-item"><strong>Fecha: </strong>{{ucfirst($order->created_at->calendar())}} </li>
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
                                    @if($order->shipping_method=='delivery')
                                            <a target=”_blank” href="
                                            https://wa.me/549{{str_replace('-', '', env('GLUBER_NUMBER'))}}?text=
                                            {{urlencode(gluberMessage($order))}}" 
                                            class="btn btn-sm btn-warning btn-block" data-toggle="tooltip" data-placement="bottom" title="Los Glubbers son deliverys particulares que puedes pedir en cualquier momento de manera opcional."><i class="fas fa-motorcycle"></i>
                                            Pedir un Gluber</a>
                                    @endif
                                        <a target=”_blank” href="
                                        https://wa.me/549{{str_replace('-', '', whatsappNumberCustomer($order))}}" 
                                        class="btn btn-sm btn-block btn-success"><i class="fab fa-whatsapp"></i> Hablar con el cliente</a>
                                        <a data-orderid="{{$order->id}}" data-toggle="modal" data-target="#closeOrderModal" href="#" class="btn btn-sm btn-block btn-danger">Cerrar pedido</a>
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
                <div class="card mb-4" id="orderHeader" style="font-size:15px">
                    <div class="border-bottom px-2">
                        <table class="table table-borderless" id="orderTable">
                            <thead>
                                <tr>
                                <th>Código</th>
                                <th>Fecha y hora</th>
                                <th>Solicitante</th>
                                <th>Contacto <i class="fab fa-whatsapp ml-1"></i></th>
                                <th>Dirección de entrega</th>
                                <th>Método de envío</th>
                                <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>{{$order->code}}</td>
                                <td>{{ucfirst($order->created_at->calendar())}}</td>
                                <td>{{$order->getfullName()}}</td>
                                <td>
                                    <a target=”_blank” href="
                                    https://wa.me/549{{str_replace('-', '', whatsappNumberCustomer($order))}}">
                                    
                                    {{$order->getPhone()}}
                                    </a>
                                </td>
                                @if($order->shipping_method=='delivery')
                                    <td>{{$order->getFullAddress()}}
                                @else
                                    <td> - </td>
                                @endif
                                <td>{{$order->getShippingMethod()}}</td>
                                <td>${{$order->total}}</td>
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
                            <div class="col-6">
                                <p class="txt-bold">Información adicional del cliente</p>
                                @if($order->client_aditional_notes!=null)
                                    <p>{{$order->client_aditional_notes}}</p>
                                @else
                                    <p> - </p>
                                @endif
                            </div>
                            <div class="col-6">
                                <div class="float-right d-flex">
                                    @if($order->shipping_method=='delivery')
                                        <div class="d-inline mr-2">
                                            <a target=”_blank” href="
                                            https://wa.me/549{{str_replace('-', '', env('GLUBER_NUMBER'))}}?text=
                                            {{urlencode(gluberMessage($order))}}" 
                                            class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Los Glubbers son deliverys particulares que puedes pedir en cualquier momento de manera opcional."><i class="fas fa-motorcycle"></i> Pedir un Gluber</a>
                                        </div>
                                    @endif
                                    <div class="d-inline mr-2">
                                        <a target=”_blank” href="
                                        https://wa.me/549{{str_replace('-', '', whatsappNumberCustomer($order))}}" 
                                        class="btn btn-sm btn-success"><i class="fab fa-whatsapp"></i> Hablar con el cliente</a>
                                    </div>
                                    <div class="d-inline mr-2">
                                        <a data-orderid="{{$order->id}}" data-toggle="modal" data-target="#closeOrderModal" href="#" class="btn btn-sm btn-danger">Cerrar pedido</a>
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

    <!-- Modal -->
    <div class="modal fade" id="closeOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Cerrar pedido</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{route('order.close')}}" method="POST">
                @csrf
            <div class="modal-body">
                <h5>¿Estás seguro de cerrar este pedido?</h5>  
                <input type="hidden" id="orderid" name="orderid" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Cerrar</button>
            </form>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('js-scripts')
<script>

$('#closeOrderModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget)
    
    var orderid = button.data('orderid')
    var modal = $(this)
    
    modal.find('.modal-body #orderid').val(orderid)
})

</script>
@endsection