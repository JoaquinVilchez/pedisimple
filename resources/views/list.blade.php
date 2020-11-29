@extends('layouts.app')

@section('content')

<section class="jumbotron hero">
  <div class="gradient">
        <div class="container d-flex align-items-center">
            <div class="row d-flex justify-content-center p-4 mt-4">
              <h1 class="h1" style="text-align: center; font-weight: 800; color: white; text-shadow: 0px 5px 8px rgba(0,0,0,0.6);">Pedír lo que buscás, ahora es más simple</h1>
              <p class="p" style="color: white">Consultá los productos de los comercios de Venado Tuerto y hace tu pedido 100% online</p>
            </div>
        </div>

        <div class="container hero-steps">
          <div class="row d-flex justify-content-center" style="font-size:.9em">
            <span>
              1<br>
              Elegí un comercio
            </span>

            <span>
              2<br>
              Armá tu pedido
            </span>

            <span>
              3<br>
              Recibí tu pedido
            </span>
          </div>
        </div>
      </div>
  </section>
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
          <div class="d-flex justify-content-center ">
            <div class="collapse" id="navbarToggleExternalContent">
              <div class="col-12">
                @if (count($filters)>0)
                  <small style="text-align: center"> <i class="fas fa-times" style="color: red"></i><a class="ml-1" style="color: red" href="{{route('home.index')}}">Quitar filtros</a></small> 
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
        <div class="col-lg-3 mb-3">
          <div class="d-none d-lg-block d-xl-block border py-2 px-4 rounded">
            <div class="mb-3">
              <p class="mb-0"><strong>Filtrar por categoría</strong></p>
              @if (count($filters)>0)
                <small> <i class="fas fa-times" style="color: red"></i><a class="ml-1" style="color: red" href="{{route('home.index')}}">Quitar filtro</a></small> 
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
                <div class="mx-auto"><a class="ml-1" href="{{route('home.index')}}"><i class="fas fa-times"></i> Quitar filtro</a></div>
              </div>
          </div>
          @endif


          @if(Auth::check() and Auth::user()->type == 'administrator')
          <div class="accordion" id="pendingShops">
            <div class="card border-0">
              <div class="card-header p-0 mb-2 border-0" id="headingOne">
                <h2 class="mb-0">
                  <button class="btn pendingShops_buttonAccordion btn-block text-left" style="color:rgb(226, 0, 0); text-align:center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Comercios pendientes <small>({{count($pending_restaurants)}})</small>
                  </button>
                </h2>
              </div>
          
              <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#pendingShops">
                @foreach($pending_restaurants as $pending_restaurant)
                  <div class="card pt-2 mb-3" style="border: 1px solid rgb(255, 100, 100); min-height:50px">
                    <div class="row px-2">
                      <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4 m-auto px-6" style="text-align: center">
                        <img width="110vh" style="border: 1px solid rgb(233, 233, 233)" class="rounded fluid img-responsive" data-original="{{asset('storage/uploads/commerce/'.$pending_restaurant->image)}}" alt="">
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
                      <div class="col-xl-3 d-flex justify-content-center align-items-center">
                          <a href="{{route('restaurant.show', $pending_restaurant->slug)}}" class="btn btn-primary btn-block btn-sm float-right mt-2">Ver Productos</a>
                      </div>
                    </div>
                    <div style="background-color: rgb(255, 100, 100); height: 15px" class="p-0 mt-2 rounded-bottom">
                      <div style="color:white; font-size:10px" class="ml-2 d-flex justify-content-between">
                        <p class="m-0d-inline">Pendiente</p>
                        <a href="#" class="active_button" data-restaurantid="{{$pending_restaurant->id}}" data-toggle="modal" data-target="#activeRestaurantModal">Activar</a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          <hr class="mt-0">
          @endif


          @foreach($restaurants as $restaurant)
            @if(count($restaurant->products)!=0 && count($restaurant->categories))
              <div class="card p-2 mb-3">
                <div class="row">
                  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4 m-auto px-6" style="text-align: center">
                    <img width="110vh" style="border: 1px solid rgb(233, 233, 233)" class="rounded fluid img-responsive" data-original="{{asset('storage/uploads/commerce/'.$restaurant->image)}}" alt="">
                  </div>
                  <div class="col-xl-7 col-lg-7 col-md-7 col-sm-9 col-8 pl-2 px-4 my-auto">
                        <h5 class="mb-1" style="font-size: 2.5vh"><a @if($restaurant->getOpeningHoursData()->isOpen()) href="{{route('restaurant.show', $restaurant->slug)}}" @else href="#" data-restaurantslug="{{$restaurant->slug}}" data-toggle="modal" data-target="#closedRestaurantModal" @endif>{{$restaurant->name}}</a></h5>
                        <div class="ml-1" style="font-size: .9em">
                          <p class="my-0"><i class="fas fa-map-marker-alt"></i> {{$restaurant->address->getFullAddress()}}</p>
                          <p class="my-0 d-inline"><i class="fas fa-phone"></i> {{$restaurant->characteristic.'-'.$restaurant->phone}}</p>
                          @if ($restaurant->second_phone)
                            <span> | </span><p class="mb-0 ml-1 d-inline"> {{$restaurant->second_characteristic.'-'.$restaurant->second_phone}}</p>
                          @endif
                        </div>
                        @if($restaurant->getOpeningHoursData()->isOpen())
                            <small style="color: #369a00"><i class="far fa-clock"></i> Abierto</small>
                        @else
                            <small style="color: #bf0000"><i class="far fa-clock"></i> Cerrado en este momento</small>
                        @endif
                  </div>
                  <div class="col-xl-3 d-flex justify-content-center align-items-center">
                    {{-- <div class="row my-2"> --}}
                      @if($restaurant->getOpeningHoursData()->isOpen())
                        <a href="{{route('restaurant.show', $restaurant->slug)}}" class="btn btn-primary btn-block btn-sm float-right mt-2">Ver Productos</a>
                      @else
                        <a href="#" class="btn btn-primary btn-block btn-sm float-right mt-2" data-restaurantslug="{{$restaurant->slug}}" data-toggle="modal" data-target="#closedRestaurantModal">Ver Productos</a>
                      @endif
                    {{-- </div> --}}

                  </div>
                </div>
              </div>
            @endif
            @endforeach

        </div>
    </div>
</div>
<section class="text-center merchant-joininfo">
  <div class="container col-12 py-4">
    <h3 class="txt-bold merchant-joininfo_title">¿Comerciante?</h3>
    <h4 class="txt-bold merchant-joininfo_description">¡Únase hoy para aumentar sus ventas en línea!</h4>
    <a class="btn btn-sm btn-link merchant-joininfo_link" href="{{route('register.request')}}">Más información</a>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="closedRestaurantModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="  exampleModalCenterTitle">Comercio cerrado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body text-center">
          <img src="{{asset('storage/design/close.svg')}}" class="img-step mb-4">
          <h5>En este momento el comercio se encuentra cerrado</h5>  
          <p>¿Queres ingresar al perfil de todas formas?</p>
          <input type="hidden" id="restaurantid" name="restaurant_id" value="">
          <input type="hidden" name="state" value="active">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onclick="continueToRestaurant()">Ir al comercio</button>
        </div>
    </div>
  </div>
</div>

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

  $('#activeRestaurcommerantModal').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget)

  var restaurantid = button.data('restaurantid')
  var modal = $(this)

  modal.find('.modal-body #restaurantid').val(restaurantid)
  })

  var restaurantSlug = null

  $('#closedRestaurantModal').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget)

  restaurantSlug = button.data('restaurantslug')
  var modal = $(this) 
  })

function continueToRestaurant(){
  window.location = "/"+restaurantSlug
}

</script>
@endsection