@extends('layouts.commerce')

@section('css-scripts')
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-4">
        <h1 class="h2"><strong>Pedidos cerrados</strong></h1>
    </div>

    @include('messages')
    @if($orders->count()>0)
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Total</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{$order->code}}</td>
                    <td>{{ucfirst($order->created_at->calendar())}}</td>
                    <td>${{$order->total}}</td>
                    <td><a class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#orderDetailsModal"
                        data-order="{{json_encode($order)}}"
                        @foreach($order->lineitems as $item)
                            data-{{$item->id}}="{{$item->product->name}}"
                        @endforeach
                    >Detalle</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align:center" class="m-auto">
            <img src="{{asset('images/design/complete.svg')}}" alt="" class="img-default my-2">
            <p>No tienes pedidos aceptados.<br>
        </div>  
    @endif

<!-- Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel">Resumen de pedido</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
                <div class="row">
                    <div class="col-2">
                        <div class="d-flex float-right">
                            <div class="align-items-center">
                                <img src="{{asset('images/uploads/user/user.png')}}" alt="" class="order-customer-image">
                            </div>
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="float-left">
                        <div class="row">
                            <div class="d-flex">
                                <div class="d-block">
                                    <h5 class="order-customer-name">Joaquin Vilchez</h5>
                                    <p class="order-customer-phone">03462-642680</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2" style="font-size: 13px">
                            <div class="d-flex">
                                <div class="d-inline">
                                    <h6 class="txt-muted order-title">Codigo de referencia</h6>
                                    <p class="order-text">ACW987</p>
                                </div>
                                <div class="d-inline ml-5">
                                    <h6 class="txt-muted order-title">Fecha</h6>
                                    <p class="order-text">17 de Mayo</p>
                                </div>
                                <div class="d-inline ml-5">
                                    <h6 class="txt-muted order-title">Metodo de envio</h6>
                                    <p class="order-text">Delivery</p>
                                </div>
                                <div class="d-inline ml-5">
                                    <h6 class="txt-muted order-title">Total</h6>
                                    <p class="order-text">$600</p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-8 border-right">
                    
                    <div class="address border-bottom" style="font-size: 14px">
                        <h6 class="txt-muted order-title">Direccion de entrega</h6>
                        <p class="order-text">Saavedra 652, Venado Tuerto</p>
                    </div>

                    <div class="order-details mt-4">
                        <h6 class="txt-muted order-title mb-2">Productos pedidos</h6>
                        <table class="table table-sm" style="font-size: 14px">
                            <tbody>
                                <tr>
                                <td>Milanesa Napolitana + Papas Fritas</td>
                                <td>x1</td>
                                <td>$250</td>
                                </tr>
                                <tr>
                                <td>Coca cola 1.5L</td>
                                <td>x1</td>
                                <td>$100</td>
                                </tr>
                                <tr>
                                <td>1/4 Helado</td>
                                <td>x1</td>
                                <td>$120</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    </div>
                    <div class="col-4 border-left">
                    <h5 class="order-title">Detalles del pedido</h5>
                    <table class="table table-borderless table-sm" style="font-size: 13px">
                        <tbody>
                            <tr>
                            <td>Aceptado el:</td>
                            <td style="text-align: right">25 Mayo - 21:45hs</td>
                            </tr>
                            <tr>
                            <td>Cerrado el:</td>
                            <td style="text-align: right">25 Mayo - 22:45hs</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <h5 class="order-title">Detalles del pago</h5>
                    <table class="table table-borderless table-sm" style="font-size: 13px">
                        <tbody>
                            <tr>
                            <td>Subtotal:</td>
                            <td style="text-align: right">$400</td>
                            </tr>
                            <tr>
                            <td>Delivery:</td>
                            <td style="text-align: right">$70</td>
                            </tr>
                            <tr>
                            <td>Total:</td>
                            <td style="text-align: right">$470</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-8">
                        <div class="aditional-information float-left" style="font-size: 14px">
                            <h6 class="order-title">Informacion adicional del cliente</h6>
                            <p class="order-text">Sin sal por favor</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="float-right d-flex" style="font-size: 20px">
                            <a href="#" class="align-items-end"><i class="fas fa-print"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

@endsection

@section('js-scripts')
<script>

$('#orderDetailsModal').on('show.bs.modal', function(event){
    var button = $(event.relatedTarget)
    
    var order = button.data('order')
    var items = button.data('items')
    var modal = $(this)

    console.log(order)
    console.log(items)
    
    modal.find('.modal-body #order').val(order)
})

</script>
@endsection