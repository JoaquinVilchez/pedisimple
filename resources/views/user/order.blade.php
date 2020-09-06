@extends('layouts.user')

@section('info-content')

    <div class="container">
        <h4> <a href="#"><i class="fas fa-arrow-left"></i></a> Pedido: {{$order->code}}</h4>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-sm table-responsive w-100 d-block d-md-table">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($order->lineItems as $item)
                        <tr>
                            <td>
                                {{$item->product->name}}
                                <span>
                                @if ($item->variants!=null)
                                    <i class="fas fa-plus-circle" data-toggle="tooltip" data-placement="top" title="{{implode(', ', $item->showVariants())}}"></i>
                                @endif
                                @if ($item->aditional_notes!=null)
                                    <i class="fas fa-sticky-note" data-toggle="tooltip" data-placement="top" title="Nota: {{$item->aditional_notes}}"></i>
                                @endif
                                </span>
                            </td>
                            <td style="text-align: center">{{$item->quantity}}</td>
                            <td>${{formatPrice($item->product->price)}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>   

@endsection
