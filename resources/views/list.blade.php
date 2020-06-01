@extends('layouts.app')

@section('content')

<section class="jumbotron rounded-0 text-center p-0 mb-0" style="background: url('https://images.pexels.com/photos/1435907/pexels-photo-1435907.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px / cover transparent;">
  <div class="element">
    <div class="container d-flex align-items-center justify-content-center" style="height:180px;">
      {{-- <div class="m-auto"> --}}
        <h1 class="text-white" style="text-shadow: 0px 5px 8px rgba(0,0,0,0.6);"><strong>{{count($restaurants)}} @if (count($restaurants)==1) Comercio disponible @else Comercios disponibles @endif</strong></h1>
      </div>
    </div>
  </div>
</section>

<div class="alert alert-warning m-0 p-1 px-2 rounded-0" role="alert" style="text-align:center" style="text-decoration: none">
  <a target=”_blank” href="https://www.argentina.gob.ar/salud/coronavirus-COVID-19">
    <strong><i class="fas fa-virus"></i> COVID-19</strong> | Conocé información y recomendaciones del Ministerio de Salud.
  </a>
</div>
  <!-- Page Content -->
<div class="container mt-4">
    {{-- mobile --}}
    <div class="col-12 d-block d-sm-none">
      <div class="d-flex justify-content-center">
        <div class="mb-4">
          <nav class="navbar navbar-dark">
            <button class="navbar-toggler" style="color: brown" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
              <span style="color: brown"><i class="fas fa-sliders-h"></i></span>
              Filtros
            </button>
          </nav>
          <div class="pos-f-t justify-content-center ">
            <div class="collapse" id="navbarToggleExternalContent">
              <div class="col-12">
                @if (count($filters)>0)
                  <small style="text-align: center"> <i class="fas fa-times" style="color: red"></i><a class="ml-1" style="color: red" href="{{route('list.index')}}">Quitar filtros</a></small> 
                @endif
                @foreach ($categories as $category)
                <div class="d-flex justify-content-between">
                  <a href="?filter={{$category->name}}" class="my-1 d-block">{{$category->name}}</a><span class="text-muted float-right d-flex align-items-center"><small>{{count($category->activeRestaurants())}}</small></span>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- mobile --}}

    <div class="row justify-content-center">
        <div class="col-lg-2">
          <div class="d-none d-lg-block d-xl-block">
            <div class="mb-3">
              <p class="mb-0"><strong>Filtros</strong></p>
              @if (count($filters)>0)
                <small> <i class="fas fa-times" style="color: red"></i><a class="ml-1" style="color: red" href="{{route('list.index')}}">Quitar filtro</a></small> 
              @endif
            </div>
            @foreach ($categories as $category)
              <div class="d-flex justify-content-between">
                <a href="?filter={{$category->name}}" class="my-1 d-block">{{$category->name}}</a><span class="text-muted float-right d-flex align-items-center"><small>{{count($category->activeRestaurants())}}</small></span>
              </div>
            @endforeach
          </div>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-8">
          @include('messages')
          
          @if (count($filters)>0)
          <div class="alert alert-danger m-0 p-1 px-2 rounded-0 mb-2" role="alert" style="text-align:center" style="text-decoration: none">
              <div>
                <div class="mx-auto">@foreach ($filters as $item) {{$item}} @endforeach</div>
                <div class="mx-auto"><a class="ml-1" href="{{route('list.index')}}"><i class="fas fa-times"></i> Quitar filtro</a></div>
              </div>
          </div>
          @endif
          @if(Auth::check() and Auth::user()->type == 'administrator')
            @foreach($pending_restaurants as $pending_restaurant)
              <div class="card pt-2 mb-3" style="border: 1px solid rgb(226, 0, 0)">
                <div class="row px-2">
                  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4 m-auto px-6" style="text-align: center">
                    <img width="110vh" style="border: 1px solid rgb(233, 233, 233)" class="rounded fluid img-responsive" src="{{asset('images/uploads/commerce/'.$pending_restaurant->image)}}" alt="">
                  </div>
                  <div class="col-xl-7 col-lg-7 col-md-7 col-sm-9 col-8 pl-2 px-4 my-auto">
                        <h5 style="font-size: 2.5vh"><a href="{{route('restaurant.show', $pending_restaurant->slug)}}">{{$pending_restaurant->name}}</a></h5>
                        <div class="ml-2">
                          <p class="my-1" style="font-size: 2vh"><i class="fas fa-map-marker-alt"></i> {{$pending_restaurant->address->getFullAddress()}}</p>
                          <p class="my-1 mr-1 d-inline" style="font-size: 2vh"><i class="fas fa-phone"></i> {{$pending_restaurant->characteristic.'-'.$pending_restaurant->phone}}</p>
                          @if ($pending_restaurant->second_phone)
                            <span> | </span><p class="mb-0 ml-1 d-inline" style="font-size: 2vh"> {{$pending_restaurant->second_characteristic.'-'.$pending_restaurant->second_phone}}</p>
                          @endif
                        </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-3 d-flex justify-content-center align-items-center">
                    <div class="row my-2">
                      <a href="{{route('restaurant.show', $pending_restaurant->slug)}}" class="btn btn-primary btn-sm float-right">Ver Productos</a>
                    </div>

                  </div>   
                </div>
                <div style="background-color: rgb(226, 0, 0); height: 15px" class="p-0 mt-2 rounded-bottom">
                  <div style="color:white; font-size:10px" class="ml-2 d-flex justify-content-between">
                    <p class="m-0d-inline">Pendiente</p>
                    <a href="#" class="active_button" data-restaurantid="{{$pending_restaurant->id}}" data-toggle="modal" data-target="#activeRestaurantModal">Activar</a>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
          @foreach($restaurants as $restaurant)
            @if(count($restaurant->products)!=0 && count($restaurant->categories))
              <div class="card p-2 mb-3">
                <div class="row">
                  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4 m-auto px-6" style="text-align: center">
                    <img width="110vh" style="border: 1px solid rgb(233, 233, 233)" class="rounded fluid img-responsive" src="{{asset('images/uploads/commerce/'.$restaurant->image)}}" alt="">
                  </div>
                  <div class="col-xl-7 col-lg-7 col-md-7 col-sm-9 col-8 pl-2 px-4 my-auto">
                        <div class="d-flex">
                          <div class="d-inline">
                            <h5 style="font-size: 2.5vh"><a href="{{route('restaurant.show', $restaurant->slug)}}">{{$restaurant->name}}</a></h5>
                          </div>
                          @if (restaurantIsOpen($restaurant))
                            <div class="d-inline ml-2">
                              <span class="badge badge-success">Abierto</span>
                            </div>
                          @else
                            <div class="d-inline ml-2">
                              <span class="badge badge-danger"><small>Cerrado</small></span>
                            </div>                    
                          @endif
                        </div>
                        <div class="ml-2">
                          <p class="my-1" style="font-size: 2vh"><i class="fas fa-map-marker-alt"></i> {{$restaurant->address->getFullAddress()}}</p>
                          <p class="my-1 ml-1 d-inline" style="font-size: 2vh"><i class="fas fa-phone"></i> {{$restaurant->characteristic.'-'.$restaurant->phone}}</p>
                          @if ($restaurant->second_phone)
                            <span> | </span><p class="mb-0 ml-1 d-inline" style="font-size: 2vh"> {{$restaurant->second_characteristic.'-'.$restaurant->second_phone}}</p>
                          @endif
                        </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-3 d-flex justify-content-center align-items-center">
                    <div class="row my-2">
                      <a href="{{route('restaurant.show', $restaurant->slug)}}" class="btn btn-primary btn-sm float-right">Ver Productos</a>
                    </div>

                  </div>   
                </div>
              </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
<section class="text-center">
  <hr>
  <div class="container col-xl-8 my-3">
  <img src="{{asset('images/design/merchant.svg')}}" width="60px" class="my-2">
    <h4 class="txt-bold">¿Comerciante?</h4>
    <p>Sumate a Pedí Simple y obtené beneficios</p>
    <a class="btn btn-sm btn-primary" href="{{route('register.request')}}">Más información</a>
  </div>
</section>


<!-- Modal -->
<div class="modal fade" id="activeRestaurantModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Activar comercio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('restaurant.admin.updateStatus')}}" method="post">
        @csrf
        <div class="modal-body">
          <h5>¿Estás seguro de activar este comercio?</h5>  
          <input type="hidden" id="restaurantid" name="restaurant_id" value="">
          <input type="hidden" name="state" value="active">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Activar</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('js-scripts')
<script>

  $('#activeRestaurantModal').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget)

  var restaurantid = button.data('restaurantid')
  var modal = $(this)

  modal.find('.modal-body #restaurantid').val(restaurantid)
  })

</script>
@endsection