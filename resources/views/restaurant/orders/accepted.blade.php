@extends('layouts.commerce')

@section('css-scripts')
<style>
    #orderTable thead tr th{
        padding-bottom:0px;
        padding-top: 0px;
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
        <h1 class="h2"><strong>Pedidos aceptados</strong> @if(count($orders)>0)<small>({{count($orders)}})</small>@endif</h1>
        <div class="mb-2" style="font-size: .8em;">
            <i class="fas fa-question-circle"></i> ¿Tenés dudas? <a target="_autoblank" href="{{route('help.documentation')}}#docs-pedidos" class="txt-semi-bold">Consultar documentación</a>.
        </div>
    </div>

    @include('messages')
    @if(count($orders)==0)
    <div style="text-align:center" class="m-auto">
        <img data-original="{{asset('storage/design/complete.svg')}}" alt="" class="img-default my-2">
        <p>No tienes pedidos aceptados.<br>
    </div>
    @else
        @foreach($orders as $order)
        {{-- MOBILE --}}
        <div class="col-12">
            <div class="order-mobile d-lg-none d-xl-none" width="100%">
                <div class="card mb-2">
                    <div class="dropdown">
                        <i class="float-right py-0 mb-0 mr-1 fas fa-ellipsis-h" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </i>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 16px">
                          <h6 class="dropdown-header">Opciones de pedido</h6>
                          <hr class="m-0">
                          <a class="dropdown-item" target=”_blank” href="https://wa.me/549{{str_replace('-', '', whatsappNumberCustomer($order))}}?text={{urlencode(whatsappMessageCustomer($order))}}">Reenviar detalle de pedido</a>
                          <a class="dropdown-item" href="#" onclick="editOrder({{$order->id}})" data-toggle="modal" data-target="#editOrderModal" >Editar pedido</a>
                          <a class="dropdown-item" target=”_blank” href="https://wa.me/549{{str_replace('-', '', whatsappNumberCustomer($order))}}">Hablar con el cliente</a>
                            @if(gluberStatus())
                                <a class="dropdown-item" target=”_blank” href="https://wa.me/549{{str_replace('-', '', env('GLUBER_NUMBER'))}}?text={{urlencode(gluberMessage($order))}}" data-toggle="tooltip" data-placement="left" title="Los Glubers son deliverys particulares que puedes pedir en cualquier momento de manera opcional.">Pedir un Gluber</a>
                            @endif
                          <a class="dropdown-item" data-orderid="{{$order->id}}" data-toggle="modal" data-target="#cancelOrderModal" href="#">Cancelar pedido</a>
                        </div>
                    </div>
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
            <div class="order d-none d-lg-block d-xl-block" width="100%" style="font-size:15px" id="orderHeader" style="font-size:15px">
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
                                <th>Total</th>
                                </tr>
                                <div class="dropdown">
                                    <i class="float-right py-0 mb-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </i>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 14px">
                                      <h6 class="dropdown-header">Opciones de pedido</h6>
                                      <hr class="m-0">
                                      <a class="dropdown-item" target=”_blank” href="https://wa.me/549{{str_replace('-', '', whatsappNumberCustomer($order))}}?text={{urlencode(whatsappMessageCustomer($order))}}">Reenviar detalle de pedido</a>
                                      <a class="dropdown-item" href="#" onclick="editOrder({{$order->id}})" data-toggle="modal" data-target="#editOrderModal" >Editar pedido</a>
                                      <a class="dropdown-item" target=”_blank” href="https://wa.me/549{{str_replace('-', '', whatsappNumberCustomer($order))}}">Hablar con el cliente</a>
                                        @if(gluberStatus())
                                            <a class="dropdown-item" target=”_blank” href="https://wa.me/549{{str_replace('-', '', env('GLUBER_NUMBER'))}}?text={{urlencode(gluberMessage($order))}}" data-toggle="tooltip" data-placement="left" title="Los Glubers son deliverys particulares que puedes pedir en cualquier momento de manera opcional.">Pedir un Gluber</a>
                                        @endif
                                      <a class="dropdown-item" data-cancelorderid="{{$order->id}}" data-toggle="modal" data-target="#cancelOrderModal" href="#">Cancelar pedido</a>
                                    </div>
                                </div>
                            </thead>
                            <tbody>
                                <tr>
                                <td>{{$order->code}}</td>
                                <td>{{ucfirst($order->created_at->diffForHumans())}}</td>
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

    <!-- Modal -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Cancelar pedido</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            {{-- <form action="{{route('order.cancel')}}" method="POST"> --}}
            {{-- @csrf --}}
            <div class="modal-body">
                <h5>¿Estás seguro de cancelar este pedido?</h5>
                <div class="container">
                    <small>
                        <label>
                            <input type="checkbox" name="send" id="cancelordercheckbox" checked>
                            Informar sobre la cancelación al cliente por WhatsApp
                        </label>
                    </small>
                </div>
                <input type="hidden" id="cancelorderid" name="cancelorderid" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" onclick="cancelOrder()">Cancelar pedido</button>
            {{-- </form> --}}
            </div>
        </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editOrderModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="editOrderModalContent">

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

$('#cancelOrderModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget)

    var cancelorderid = button.data('cancelorderid')
    var modal = $(this)

    modal.find('.modal-body #cancelorderid').val(cancelorderid)
})

function cancelOrder(){
    var cancelorderid = $('#cancelorderid').val();
    var send = $('#cancelordercheckbox').is(":checked");
    $.ajax({
        url:"{{ route('order.cancel') }}",
        type:"POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data:{cancelorderid:cancelorderid, send:send},
        success:function(data) {
            if(data.newUrl){
                var id = (new Date()).getTime();
                var myWindow = window.open(data.newUrl, id);
            }
            $.post("{{ route('order.cancel') }}", data).done(function(htmlContent) {
                myWindow.document.write(htmlContent);
                myWindow.focus();
            });
            location.reload();
        }
    })
};

function editOrder(orderid){
    $.ajax({
      url : '{{ route("order.editOrder") }}',
      type: 'POST',
      headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data:{orderid:orderid},
      success:function(data){
          $('#editOrderModalContent').html(data)
      }
    });
}

</script>
@endsection