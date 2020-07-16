<div class="container">
    <div class="row">
        <div class="col-2">
            <div class="d-flex float-right">
                <div class="align-items-center">
                    <img src="{{asset('images/uploads/user/'.$user['image'])}}" alt="" class="order-customer-image">
                </div>
            </div>
        </div>
        <div class="col-10">
            <div class="float-left">
            <div class="row">
                <div class="d-flex">
                    <div class="d-block">
                        <h5 class="order-customer-name">{{$user['first_name'].' '.$user['last_name']}}</h5>
                        <p class="order-customer-phone">{{$user['characteristic'].'-'.$user['phone']}}</p>
                    </div>
                </div>
            </div>
            <div class="row mt-2" style="font-size: 13px">
                <div class="d-flex">
                    <div class="d-inline">
                        <h6 class="txt-muted order-title">Codigo de referencia</h6>
                        <p class="order-text">{{$order->code}}</p>
                    </div>
                    <div class="d-inline ml-5">
                        <h6 class="txt-muted order-title">Fecha</h6>
                        <p class="order-text">{{ucfirst(\Carbon\Carbon::parse($order->ordered)->locale('es')->calendar())}}</p>
                    </div>
                    <div class="d-inline ml-5">
                        <h6 class="txt-muted order-title">Metodo de envio</h6>
                        @if ($order->shipping_method=='delivery')
                            <p class="order-text">Delivery</p>
                        @else
                            <p class="order-text">Retiro en local</p>                         
                        @endif
                    </div>
                    <div class="d-inline ml-5">
                        <h6 class="txt-muted order-title">Total</h6>
                        <p class="order-text">${{$order->total}}</p>
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
            @if ($order->shipping_method=='delivery')
                @if ($order->address_id==null)
                    <p class="order-text">{{getGuestAddress($order)}}</p>  
                @else
                    <p class="order-text">{{$order->address->getAddress()}}</p>      
                @endif
            @else
                <p class="order-text">Retiro en local</p>                         
            @endif
        </div>

        <div class="order-details mt-4">
            <h6 class="txt-muted order-title mb-2">Productos pedidos</h6>
            <table class="table table-sm" style="font-size: 14px">
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                        <td>{{$item->product->name}}
                            @if ($item->variants!=null)
                                <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="bottom" title="{{implode(', ', $item->showVariants())}}"></i>
                            @endif
                            @if ($item->aditional_notes!=null)
                                <i class="fas fa-sticky-note" data-toggle="tooltip" data-placement="bottom" title="Nota: {{$item->aditional_notes}}"></i>
                            @endif
                        </td>
                        <td>x{{$item->quantity}}</td>
                        <td>${{$item->product->price*$item->quantity}}</td>
                        </tr>
                    @endforeach
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
                <td style="text-align: right">{{ucfirst(\Carbon\Carbon::parse($order->ordered)->locale('es')->calendar())}}</td>
                </tr>
                <tr>
                <td>Cerrado el:</td>
                <td style="text-align: right">{{ucfirst(\Carbon\Carbon::parse($order->updated_at)->locale('es')->calendar())}}</td>
                </tr>
            </tbody>
        </table>
        <hr>
        <h5 class="order-title">Detalles del pago</h5>
        <table class="table table-borderless table-sm" style="font-size: 13px">
            <tbody>
                <tr>
                <td>Subtotal:</td>
                <td style="text-align: right">${{$order->subtotal}}</td>
                </tr>
                <tr>
                <td>Delivery:</td>
                @if ($order->shipping_method=='delivery')
                    <td style="text-align: right">${{$order->delivery}}</td>
                @else
                    <td style="text-align: right">-</td>
                @endif
                </tr>
                <tr>
                <td>Total:</td>
                <td style="text-align: right">${{$order->total}}</td>
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
                <p class="order-text">{{$order->client_aditional_notes}}</p>
            </div>
        </div>
        <div class="col-4">
            <div class="float-right d-flex" style="font-size: 20px">
                <a href="#" class="align-items-end"><i class="fas fa-print"></i></a>
            </div>
        </div>
    </div>
</div>
