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
        <div class="card mb-4" id="orderHeader" style="font-size:15px">
            <div class="border-bottom px-2">
                <table class="table table-borderless" id="orderTable">
                    <thead>
                        <tr>
                        <th>Código</th>
                        <th>Fecha y hora</th>
                        <th>Solicitante</th>
                        <th>Contacto<i class="fab fa-whatsapp ml-1"></i></th>
                        <th>Dirección de entrega</th>
                        <th>Método de envío</th>
                        <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>{{$order->code}}</td>
                        <td>{{ucfirst($order->created_at->calendar())}}</td>
                        @if($order->user_id!=null)
                            <td>{{$order->user->fullName()}}</td>
                            <td>
                                <a target=”_blank” href="
                                https://wa.me/549{{str_replace('-', '', whatsappNumberCustomer($order))}}">
                                
                                {{$order->user->getPhone()}}
                                </a>
                            </td>
                            @if($order->shipping_method=='delivery')
                                @if ($order->address_id==null)
                                    <td>{{getGuestAddress($order)}}</td>  
                                @else
                                    <td>{{$order->address->getAddress()}}</td>      
                                @endif
                            @else
                                <td> - </td>
                            @endif
                        @else
                            <td>{{$order->guest_first_name.' '.$order->guest_last_name}}</td>
                            <td>
                                <a target=”_blank” href="
                                https://wa.me/549{{str_replace('-', '', whatsappNumberCustomer($order))}}">
                                {{$order->guest_characteristic.'-'.$order->guest_phone}}
                                </a>
                            </td>
                            @if($order->shipping_method=='delivery')
                                @if ($order->address_id==null)
                                    <td>{{getGuestAddress($order)}}</td>  
                                @else
                                    <td>{{$order->address->getAddress()}}</td>      
                                @endif
                            @else
                                <td> - </td>
                            @endif
                        @endif                    
                        <td>
                            @if($order->shipping_method=='delivery')
                                Delivery
                            @else
                                Retiro por local
                            @endif    
                        </td>
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
                                <span class="btn btn-sm btn-checkbox">{{$item->product->name.'  x'.$item->quantity}}</span>
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
                                    class="btn btn-sm btn-warning"><i class="fas fa-motorcycle"></i> Pedir un Gluber</a>
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