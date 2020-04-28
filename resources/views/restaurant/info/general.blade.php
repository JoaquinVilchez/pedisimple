@extends('layouts.commerce')

@section('main')
    <div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="h2"><strong>Información general</strong></h1>
        <div class="btn-toolbar mb-2 mb-md-0 ml-5">
        <a href="{{route('restaurant.edit', $restaurant)}}" type="button" class="btn btn-primary">Editar</a>
        </div>
    </div>

    <div class="col-xl-6 mt-3">
    <table class="table">
        <tbody>
          <tr>
            <td>Nombre</td>
            <td>{{$restaurant->name}}</td>
          </tr>
          <tr>
            <td>Dirección</td>
            <td>{{$restaurant->address->getFullAddress()}}</td>
          </tr>
          <tr>
            <td>Teléfono</td>
            <td>{{$restaurant->phone}}</td>
          </tr>
          <tr>
            <td>Descripción</td>
            <td>{{$restaurant->description}}</td>
          </tr>
          <tr>
            <td>Foto</td>
            <td> <img src="{{asset('images/uploads/commerce/'.$restaurant->image)}}" class="img-thumbnail" width="150px"></td>
          </tr>
          <tr>
            <td>Comidas</td>
            <td>
              @foreach($restaurant->restaurantCategories as $restaurantCategory)
              <span class="btn btn-checkbox m-1" >{{$restaurantCategory->name}}</span>
              @endforeach
            </td>
          </tr>
          <tr>
            <td>¿Retiro o delivery?</td>
            <td>{{$restaurant->shippingMethod()}}</td>
          </tr>
          @if($restaurant->shipping_method=='delivery' || $restaurant->shipping_method=='delivery-pickup')
          <tr>
            <td>Costo de envío</td>
            <td>${{$restaurant->shipping_price}}</td>
          </tr>
          <tr>
            @if($restaurant->shipping_time != null)
            <td>Tiempo aproximado de envío</td>
            <td>{{$restaurant->shipping_time}} minutos</td>
            @endif
          </tr>
          @endif
        </tbody>
      </table>
    </div>  

@endsection

