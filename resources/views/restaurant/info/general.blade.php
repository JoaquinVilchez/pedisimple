@extends('layouts.commerce')

@section('main')
    <div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="h2"><strong>Información</strong></h1>
    </div>

    <div class="row">
      <div class="col-12 col-xl-6 mt-3">
        <div class="border rounded p-2 mb-2">
          <div class="d-flex justify-content-between pb-2">
            <h4 class="ml-1"><strong>General</strong></h4>
            <div class="btn-toolbar">
              <a href="{{route('restaurant.edit', $restaurant)}}" class="btn btn-sm btn-primary">Editar</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table">
                <tbod>
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
                    <td>{{$restaurant->characteristic.' - '.$restaurant->phone}}</td>
                  </tr>
                  <tr>
                    <td>Segundo teléfono</td>
                    @if ($restaurant->second_phone == null)
                      <td>No tengo</td>
                    @else
                    <td>{{$restaurant->second_characteristic.' - '.$restaurant->second_phone}}</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Descripción</td>
                    @if ($restaurant->second_phone == null)
                      <td> - </td>
                    @else
                      <td>{{$restaurant->description}}</td>
                    @endif
                  </tr>
                  <tr>
                    <td>Foto</td>
                    <td> <img data-original="{{asset('storage/uploads/commerce/'.$restaurant->image)}}" class="img-thumbnail" width="30%"></td>
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
                    @if ($restaurant->shipping_price != 0)
                      <td>${{formatPrice($restaurant->shipping_price)}}</td>
                    @else
                      <td>Sin cargo</td>
                    @endif
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
          </div>
      </div> 
      <div class="col-12 col-xl-6 mt-3">
        <div class="border rounded p-2 mb-2">
            <div class="d-flex justify-content-between pb-2 border-bottom">
              <h4 class="ml-1"><strong>Horarios</strong></h4>
                <a href="{{route('restaurant.times')}}" class="btn btn-sm btn-primary">@if($restaurant->getSchedule()==null) Establecer Horarios @else Editar @endif</a>
            </div>
            @if($restaurant->getSchedule()==null)
            <div class="container">
              <div style="text-align:center">
                <img src="{{asset('storage/design/calendar.svg')}}" class="img-step m-3">
                <h6>Establece tus horarios para poder activar el servicio.</h6>
              </div>
            </div>
            @else
              <div class=" table-responsive">
                  <table class="table table-hover table-sm" style="font-size: 15px">
                      <tbody>
                          @foreach($restaurant->getSchedule() as $day)
                          @if(is_array($day))
                              <tr>
                                  <td>{{getDayName($day)}}</td>
                                  @if($day['state']=='open')
                                    @if($day['start_hour_1'] == null or $day['end_hour_1'] == null)
                                        <td>Cerrado</td>
                                        <td></td>
                                        <td>Cerrado</td>
                                    @else
                                        <td>{{substr($day['start_hour_1'], 0, -3)}}hs</td>
                                            <td>a</td>
                                        <td>{{substr($day['end_hour_1'], 0, -3)}}hs</td>        
                                    @endif
                                  
                                    @if($day['start_hour_2'] == null or $day['end_hour_2'] == null)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @else
                                        <td>{{substr($day['start_hour_2'], 0, -3)}}hs</td>
                                            <td>a</td>
                                        <td>{{substr($day['end_hour_2'], 0, -3)}}hs</td>
                                    @endif
                                  @else
                                      <td><span class="badge badge-danger">Cerrado</span></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                  @endif
                              </tr>
                          @else
                              <tr>
                                  <td>{{getDayName($day)}}</td>
                                  <td><span class="badge badge-danger">Cerrado</span></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                          @endif
                          @endforeach
                      </tbody>
                  </table>
              </div>
            @endif
        </div>
      </div>
    </div>

@endsection

