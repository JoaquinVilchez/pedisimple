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
                  <a href="?filter={{$category->name}}" class="my-1 d-block">{{$category->name}}</a><span class="text-muted float-right d-flex align-items-center"><small>{{count($category->restaurants)}}</small></span>
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
          @if (count($filters)>0)
          <div class="alert alert-danger m-0 p-1 px-2 rounded-0 mb-2" role="alert" style="text-align:center" style="text-decoration: none">
              <div>
                <div class="mx-auto">@foreach ($filters as $item) {{$item}} @endforeach</div>
                <div class="mx-auto"><a class="ml-1" href="{{route('list.index')}}"><i class="fas fa-times"></i> Quitar filtro</a></div>
              </div>
          </div>
          @endif
          @foreach($restaurants as $restaurant)
            @if(count($restaurant->products)!=0 && count($restaurant->categories))
              <div class="card p-2 mb-3">
                <div class="row">
                  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4 m-auto px-6" style="text-align: center">
                    <img width="110vh" style="border: 1px solid rgb(233, 233, 233)" class="rounded fluid img-responsive" src="{{asset('images/uploads/commerce/'.$restaurant->image)}}" alt="">
                  </div>
                  <div class="col-xl-7 col-lg-7 col-md-7 col-sm-9 col-8 pl-2 px-4 my-auto">
                        <h5 style="font-size: 2.5vh"><a href="{{route('restaurant.show', $restaurant->slug)}}">{{$restaurant->name}}</a></h5>
                        <div class="ml-2">
                          <p class="my-1" style="font-size: 2vh"><i class="fas fa-map-marker-alt"></i> {{$restaurant->address->getFullAddress()}}</p>
                          <p class="my-1" style="font-size: 2vh"><i class="fas fa-phone"></i> {{$restaurant->phone}}</p>
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

@endsection

@section('js-scripts')
    <script>
      $('.popover-dismiss').popover({
        trigger: 'focus'
      })
    </script>
@endsection