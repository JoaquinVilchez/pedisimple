@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <nav class="col-xl-2 bg-light sidebar">      
      <div class="sidebar-sticky">
        <div style="text-align:center">
          <img width="100px" data-original="{{asset('storage/uploads/commerce/'.Auth::user()->restaurant->image)}}" class="img-thumbnail mt-4">
          <h6>{{Auth::user()->restaurant->name}}</h6>
          @if(Auth::user()->restaurant->state=='active')
            @if(count(Auth::user()->restaurant->products)==0)
            <div class="alert alert-warning m-2" role="alert">Para que tu comercio esté visible debes: <br><a href="{{route('product.create')}}" class="alert-link">Crear un producto</a></div>
            @else
              <a class="btn btn-sm btn-primary" href="{{route('restaurant.show', Auth::user()->restaurant->slug)}}" target=”_blank” >Ver perfil</a>
            @endif
          @elseif(Auth::user()->restaurant->state=='pending')
            <div class="alert alert-warning p-0" role="alert">
                <img data-original="{{asset('storage/design/padlock.svg')}}" alt="" width="50px" class="d-block mx-auto my-2">  
                <p class="d-block m-0">Tu comercio está pendiente de aprobación</p>
                <a class="btn btn-sm btn-danger my-2" href="{{route('restaurant.show', Auth::user()->restaurant->slug)}}" target=”_blank” >Vista previa del perfil</a>
            </div>
          @elseif(Auth::user()->restaurant->state=='cancelled')
            <div class="alert alert-danger m-2" role="alert">Tu comercio fue cancelado</div>
          @elseif(Auth::user()->restaurant->state=='without-times')
          <div class="alert alert-danger m-2" role="alert">Tu comercio fue inhabilitado temporalmente. <a href="{{route('restaurant.times')}}" class="alert-link">Establece los horarios de apertura</a> y se activará automáticamente.</div>
          @endif
          <hr>
        </div>

        <nav class="nav d-none d-xl-block">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#productosCollapse" role="button" aria-expanded="false" aria-controls="productosCollapse">
                <div class="d-flex justify-content-between">
                <span>Productos</span>
                <i class="fas fa-chevron-down"></i>
                </div>
                </a>
            </li>
            <div class="collapse nav-pills" id="productosCollapse">
              <ul class="list-unstyled ml-3">
                <li class="nav-item">
                    <a class="nav-link" id="menu" href="{{route('product.index')}}">Menú</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="categorias" href="{{route('category.index')}}">Categorías</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="variantes" href="{{route('variant.index')}}">Variantes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="temporales" href="{{route('product.temporaries')}}">Temporales</a>
                </li>
              </ul>
            </div>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#pedidosCollapse" role="button" aria-expanded="false" aria-controls="pedidosCollapse">
                <div class="d-flex justify-content-between">
                <span>
                  @if((Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count())>0)
                    <span class="badge badge-pill badge-danger mr-1">{{Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()}} </span>
                  @endif
                  Pedidos
                </span>
                <i class="fas fa-chevron-down"></i>
                </div>
                </a>
            </li>
            <div class="collapse nav-pills" id="pedidosCollapse">
              <ul class="list-unstyled ml-3">
                <li class="nav-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <span><a class="nav-link" id="nuevos" href="{{route('order.new')}}">Nuevos</a></span>
                      @if((Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count())>0)
                        <span class="badge badge-pill badge-danger ml-2">{{Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()}} </span>
                      @else
                        <span class="text-muted mx-4"><small>{{Auth::user()->restaurant->newOrders()}}</small></span> 
                      @endif
                  </div>
                    
                </li>
                <li class="nav-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <span><a class="nav-link" id="aceptados" href="{{route('order.accepted')}}">Aceptados</a></span>
                    <span class="text-muted mx-4"><small>{{Auth::user()->restaurant->acceptedOrders()}}</small></span>
                  </div>
                </li>
                <li class="nav-item">
                  <div class="d-flex justify-content-between align-items-center">
                    <a class="nav-link" id="cerrados" href="{{route('order.closed')}}">Cerrados</a>
                    <span class="text-muted mx-4"><small>{{Auth::user()->restaurant->closedOrders()}}</small></span>
                  </div>
                </li>
              </ul>
            </div>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#configuracionCollapse" role="button" aria-expanded="false" aria-controls="configuracionCollapse">
                <div class="d-flex justify-content-between">
                <span>Configuración</span>
                <i class="fas fa-chevron-down"></i>
                </div>
              </a>
            </li>
            <div class="collapse nav-pills" id="configuracionCollapse">
              <ul class="list-unstyled ml-3"> 
                <li class="nav-item">
                    <a class="nav-link" id="informacion" href="{{route('restaurant.info')}}">Información</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="horarios" href="{{route('restaurant.times')}}">Horarios</a>
                </li>
              </ul>
            </div>
          </ul>
        </nav>
      </div>
      <div style="text-align: center" class="d-xl-none">
        <a class="nav-link" data-toggle="collapse" href="#mobileMenu" role="button" aria-expanded="false" aria-controls="mobileMenu">
          <i class="fas fa-bars"></i> Menu
        </a>
      </div>

      <div class="collapse d-xl-none" id="mobileMenu" style="text-align: center">
        <nav class="nav d-block d-xl-none">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#productosCollapse" role="button" aria-expanded="false" aria-controls="productosCollapse">
                <span>Productos</span>
                <i class="fas fa-chevron-down"></i>
                </a>
            </li>
            <div class="collapse nav-pills" id="productosCollapse">
              <ul class="list-unstyled ml-3">
                <li class="nav-item">
                    <a class="nav-link" id="menu" href="{{route('product.index')}}">Menú</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="categorias" href="{{route('category.index')}}">Categorías</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="variantes" href="{{route('variant.index')}}">Variantes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="temporales" href="{{route('product.temporaries')}}">Temporales</a>
                </li>
              </ul>
            </div>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#pedidosCollapse" role="button" aria-expanded="false" aria-controls="pedidosCollapse">
                <span>
                  @if((Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count())>0)
                    <span class="badge badge-pill badge-danger mr-1">{{Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()}} </span>
                  @endif
                  Pedidos
                </span>
                <i class="fas fa-chevron-down"></i>
                </a>
            </li>
            <div class="collapse nav-pills m-auto" id="pedidosCollapse">
              <ul class="list-unstyled">
                <li class="nav-item">
                  <div class="d-flex align-items-center">
                    <span><a class="nav-link" id="nuevos" href="{{route('order.new')}}">Nuevos</a></span>
                      @if((Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count())>0)
                        <span class="badge badge-pill badge-danger ml-2">{{Auth::user()->unreadNotifications()->where('type', 'App\Notifications\NewOrder')->count()}} </span>
                      @else
                        <span class="text-muted mx-4"><small>{{Auth::user()->restaurant->newOrders()}}</small></span> 
                      @endif
                  </div>
                    
                </li>
                <li class="nav-item">
                  <div class="d-flex align-items-center">
                    <span><a class="nav-link" id="aceptados" href="{{route('order.accepted')}}">Aceptados</a></span>
                    <span class="text-muted mx-4"><small>{{Auth::user()->restaurant->acceptedOrders()}}</small></span>
                  </div>
                </li>
                <li class="nav-item">
                  <div class="d-flex align-items-center">
                    <a class="nav-link" id="cerrados" href="{{route('order.closed')}}">Cerrados</a>
                    <span class="text-muted mx-4"><small>{{Auth::user()->restaurant->closedOrders()}}</small></span>
                  </div>
                </li>
              </ul>
            </div>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#configuracionCollapse" role="button" aria-expanded="false" aria-controls="configuracionCollapse">
                <span>Configuración</span>
                <i class="fas fa-chevron-down"></i>
              </a>
            </li>
            <div class="collapse nav-pills" id="configuracionCollapse">
              <ul class="list-unstyled ml-3"> 
                <li class="nav-item">
                    <a class="nav-link" id="informacion" href="{{route('restaurant.info')}}">Información</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="horarios" href="{{route('restaurant.times')}}">Horarios</a>
                </li>
              </ul>
            </div>
          </ul>
        </nav>
      </div>
    </nav>    

    @if(count(Auth::user()->unreadNotifications->where('type', 'App\Notifications\UpdatePricesReminder')))
      @if(Request::path()!='productos/actualizarprecios')
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div style="text-align: center">
                    <h5 class="modal-title txt-bold" id="exampleModalLabel">¡Actualizá tus precios!</h5>
                    <img class="my-2" src="{{asset('storage/design/price.svg')}}" alt="" width="50px">
                    <div class="container">
                      <p>Te ofrecemos actualizar tus precios de una forma muy sencilla y rápida, sólo te tomará unos minutos.</p>
                        <a href="{{route('product.editprices')}}" class="btn btn-primary">Actualizar Precios</a><br>
                      <small><a href="#" class="mt-2" data-dismiss="modal" aria-label="Close" onclick="alert('AJAX-MarkReadNotification')">No, gracias.</a></small>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    @endif

    
    <main role="main" class="col-auto ml-sm-auto col-xl-10 col-12">
      <div class="help-button-wrapper">
        <ul class="help-list">
          <li>
            <p class="text-danger">¿Necesitas ayuda?</p>
            <hr class="m-0">
          </li>
          <li><span id="start-tour"><a target=”_blank” href="https://wa.me/549{{str_replace('-', '', env('APP_NUMBER'))}}">Hablar con un asesor</a></span></li>
          <li><span id="start-tour"><a target=”_blank” href="#">Ver documentación</a></span></li>
        </ul>
        <button class="help-button">
          <span>
            <i class="fa fa-question-circle-o" aria-hidden="true"></i>
          </span>
        </button>
      </div>
      @yield('main')
    </main>
  </div>
</div>

  <script>

    $(window).on('load',function(){
        $('#exampleModal').modal('show');
    });

    var url = window.location.pathname;  
    const parts = url.split('/');
    var activeCategory = parts[1];
    var activePage = parts[2];
    
    
    document.getElementById(activeCategory+'Collapse').classList.add("show")
    document.getElementById(activePage).classList.add("active")

    $(".help-button").on("click", function() {
      $(".help-button-wrapper").toggleClass("expanded");
    });

    $(document).on("click", function(event) {
      if (!$(event.target).closest(".help-button").length) {
        $(".help-button-wrapper").removeClass("expanded");
      }
    });

  </script>
@endsection




