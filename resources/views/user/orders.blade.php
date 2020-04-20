@extends('layouts.user')

@section('info-content')

    <h5>Mis pedidos @if(count($orders)>0)<small>({{count($orders)}})</small>@endif</h5>
    @if(count($orders)>0)
        <table class="table table-hover">
            <thead>
                <th>Comercio</th>
                <th>Fecha de pedido</th>
                <th>Estado</th>
                <th>Importe</th>
                <th>Detalle</th>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{getRestaurantData($order->restaurant_id)->name}}</td>
                    <td><small>{{$order->ordered}}</small></td>
                    <td><span class="{{$order->stateStyle()}}">{{$order->state}}</span></td>
                    <td>$ {{$order->total}}</td>
                    <td><a href="{{route('order.show', $order->id)}}">Ver pedido <i class="fas fa-info-circle"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="ml-2">No tienes pedidos todavía</p>
    @endif
    <a href="{{route('list.index')}}">+ Hacer un pedido</a>

@endsection
