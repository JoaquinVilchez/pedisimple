@extends('layouts.app')

@section('css-scripts')
<style>
    .vl {
      border-left: 1px solid;
      height: 30px;
      margin: 0px 20px
    }
    .back-to-top {
        cursor: pointer;
        position: fixed;
        bottom: 20px;
        right: 20px;
    }
</style>
@endsection

@section('content')
    <section class="jumbotron px-0 pb-0 mb-0 rounded-0" style="background: url({{$restaurant->showCoverPage()}}) no-repeat scroll 0px 50% / cover transparent; ">
        <div class="gradient">
            <div class="container text-white col-lg-8 ">
                <div class="row pb-2">
                    <div class="col-xl-2 col-lg-2 col-md-2 d-none d-md-block d-lg-block d-xl-block">
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="border rounded" width="120px" data-original="{{asset('storage/uploads/commerce/'.$restaurant->image)}}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10 pl-0">
                        <div class="ml-3">
                            <div class="d-flex align-items-center">
                                <h3 class="txt-bold d-inline txt-shadow">{{$restaurant->name}}</h3>
                                    @if($restaurant->isOpen())
                                        <span class="badge badge-success d-inline align-items-center ml-3"><i class="far fa-clock"></i> Abierto</span>
                                    @else
                                        <span class="badge badge-danger d-inline align-items-center ml-3"><i class="far fa-clock"></i> Cerrado</span>
                                    @endif
                            </div>
                            <div>
                                <p class="mb-0 mr-2 d-inline"><i class="fas fa-phone"></i> {{$restaurant->characteristic.'-'.$restaurant->phone}}</p>
                                @if ($restaurant->second_phone)
                                    <span> | </span><p class="mb-0 ml-2 d-inline"> {{$restaurant->second_characteristic.'-'.$restaurant->second_phone}}</p>
                                @endif
                                <p class="mb-0"><i class="fas fa-map-marker-alt"></i> {{$restaurant->address->getFullAddress()}}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center pl-4 mt-2" style="font-size: 13px">
                            <div class="d-inline">
                                <span class="d-block">{{$restaurant->shippingMethod()}}</span>
                                <small class="d-block txt-muted">Método de envío</small>
                            </div>
                            @if($restaurant->shipping_method != 'pickup')
                                <div class="vl"></div>
                                <div class="d-inline">
                                    <span class="d-block">${{formatPrice($restaurant->shipping_price)}} <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Importante: El precio del delivery puede variar en base a la distancia."></i></span>
                                    <small class="d-block txt-muted">Costo de envío</small>
                                </div>
                                @if($restaurant->shipping_time)
                                    <div class="vl"></div>
                                    <div class="d-inline">
                                        <span class="d-block">{{$restaurant->shipping_time}} min. </span>
                                        <small class="d-block txt-muted">Tiempo aprox. de envío </small>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($restaurant->state != 'active')
        <div class="alert alert-danger m-0 p-1 px-2 rounded-0" role="alert" style="text-align:center; color:white; background-color: rgb(226, 0, 0); border:none">
            <p class="d-inline">Comercio pendiente de aprobación</p>
            @if(Auth::user()->type=='administrator')
                <form class="d-inline" action="{{route('restaurant.admin.updateStatus')}}" id="stateSelect{{$restaurant->id}}" method="post">
                    @csrf
                    <input type="text" value="{{$restaurant->id}}" name="restaurant_id" hidden>
                    <a href="#" class="active_button" data-restaurantid="{{$restaurant->id}}" data-toggle="modal" data-target="#activeRestaurantModal">Activar</a>
                </form>
            @endif
        </div>
    @endif

    <!-- Page Content -->
    <div class="container mt-3">
        
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" style=".active{background-color:red}" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Información</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="row">

            <div class="col-12 col-lg-8 order-1 order-lg-0 tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="container">
                        <div class="row my-3">
                            <div class="d-flex align-items-center">
                                <h6>Ir a categoria:</h6>
                                    <div class="form-group">
                                        <select class="form-control ml-3" id="goToCategorySelect">
                                            @foreach($categories as $category)
                                                @if(count($category->products)>0)
                                                    <option value="{{normaliza($category->name)}}">
                                                        {{ucfirst($category->name)}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- TEMPORALES --}}
                    @if(count($temporary_products)!=0)
                        <h3>Temporales</h3>
                        <div class="row mb-4">
                            @foreach($temporary_products as $temporary_product)
                            <div class="col-lg-6 px-1" >
                                @if ($temporary_product->image == 'no_image.png')
                                    <div class="card p-2 m-1 product-card" onclick="showData({{$temporary_product->id}})" style="min-height:95%" onclick="alerta();">
                                        <div class="row">
                                            <div class="col-10 pr-0 pl-4">
                                                <h6 class="mb-0"><strong>{{ucfirst($temporary_product->name)}}</strong></h6>
                                                @if($temporary_product->details)
                                                <div class="ml-2 mt-1">
                                                    <small>{{ucfirst($temporary_product->details)}}</small><br>
                                                </div>
                                                @endif
                                                <div class="ml-2 mt-1">
                                                    <span>${{formatPrice($temporary_product->price)}}</span>
                                                </div>
                                                <small><span class="badge badge-danger" style="font-weight: 400"><i class="far fa-clock"></i> {{$temporary_product->getRemainingDays()}}</span></small>
                                            </div>  
                                            
                                            <div class="col-2 d-flex align-items-center">
                                                <span class="float-right mr-2" style="font-size:20px">
                                                    <a style="color:#ffc500;cursor: pointer"><i class="fas fa-plus-circle"></i></a>
                                                </span>
                                            </div>        
                                        </div>
                                    </div>
                                @else
                                    <div class="card p-2 m-1 product-card" onclick="showData({{$temporary_product->id}})" style="min-height:95%">
                                        <div class="row">
                                            <div class="col-4 pr-0">
                                                <div class="d-flex align-items-center">
                                                    <img class="d-block border m-1 img-card" data-original="{{asset('storage/uploads/products/'.$temporary_product->image)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-6 pt-1 px-0">
                                                <h6 class="mb-0"><strong>{{ucfirst($temporary_product->name)}}</strong></h6>
                                                    @if($temporary_product->details)
                                                    <div class="mt-1">
                                                        <small>{{ucfirst($temporary_product->details)}}</small><br>
                                                    </div>
                                                    @endif
                                                    <div class="mt-1">
                                                        <span>${{formatPrice($temporary_product->price)}}</span>
                                                    </div>
                                                    <small><span class="badge badge-danger" style="font-weight: 400"><i class="far fa-clock"></i> {{$temporary_product->getRemainingDays()}}</span></small>
                                            </div>  
                                            <div class="col-2 d-flex align-items-center">
                                                <span class="float-right mr-2" style="font-size:20px">
                                                    <a style="color:#ffc500;cursor: pointer"><i class="fas fa-plus-circle"></i></a>
                                                </span>
                                            </div>        
                                        </div>                                
                                    </div>
                                @endif
                            </div>
                            @endforeach                   
                        </div>
                    @endif
                    {{-- TEMPORALES --}}
                
                @foreach($categories as $category)
                @if(count($category->getProducts())>0)
                <div class="categoria mb-4" id="{{normaliza($category->name)}}">
                <h3>{{ucfirst($category->name)}}</h3>
                    <p>{{ucfirst($category->description)}}</p>   
                    <div class="row">
                        @foreach($category->getProducts() as $product)
                        @if ($product->temporary==false)
                            <div class="col-lg-6 px-1">
                                
                                    <div class="card p-2 m-1 product-card" onclick="showData({{$product->id}})" style="min-height:95%">
                                        <div class="row" style="min-height: 100%">
                                            <div class="col-4 pr-0">
                                                @if ($product->image != 'no_image.png')
                                                    <div class="d-flex align-items-center">
                                                        <img class="d-block border m-1 img-card" data-original="{{asset('storage/uploads/products/'.$product->image)}}" alt="">
                                                    </div>
                                                @endif
                                            </div>
                                            <div @if ($product->image == 'no_image.png') class="col-10 pr-0 pl-4" @else class="col-6 pt-1 px-0" @endif>
                                                <h6 class="mb-0"><strong>{{ucfirst($product->name)}}</strong></h6>
                                                    @if($product->details)
                                                    <div class="mt-1">
                                                        <small>{{ucfirst($product->details)}}</small><br>
                                                    </div>
                                                    @endif
                                                    <div class="mt-1">
                                                        <span>${{formatPrice($product->price)}}</span>
                                                    </div>
                                            </div>  
                                            <div class="col-2 d-flex align-items-center">
                                                <span class="float-right mr-2" style="font-size:20px">
                                                    <a style="color:#ffc500;cursor: pointer"><i class="fas fa-plus-circle"></i></a>
                                                </span>
                                            </div>        
                                        </div>                                
                                    </div>
                            </div>
                        @endif
                        @endforeach                   
                    </div>
                </div>
                @endif
                @endforeach
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Información del comercio</h5>
                            @if($restaurant->description)
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="card-subtitle mb-2 text-muted mt-3">Descripción</h6>
                                    <p>{{ucfirst($restaurant->description)}}</p>
                                </div>
                            </div>
                            <hr>
                            @endif
                            <div class="row">
                                <div class="col-xl-6 col-12">
                                    <h6 class="card-subtitle mb-2 text-muted mt-3">Dirección</h6>
                                    <p><i class="fas fa-map-marker-alt"></i> {{($restaurant->address->getFullAddress())}}</p>
                                </div>
                                <div class="col-xl-6 col-12">
                                    <h6 class="card-subtitle mb-2 text-muted mt-3">Teléfono</h6>
                                    <p class="d-inline mr-1"><i class="fas fa-phone"></i> {{$restaurant->characteristic.'-'.$restaurant->phone}}</p>
                                    @if ($restaurant->second_phone)
                                        <span> | </span><p class="mb-0 ml-1 d-inline"> {{$restaurant->second_characteristic.'-'.$restaurant->second_phone}}</p>
                                    @endif
                                </div>
                            </div>

                            @if($restaurant->getSchedule()!=null)
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="card-subtitle mb-2 text-muted mt-3">Horarios</h6>
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
                                </div>
                            </div>
                            @endif

                                <!--Google map-->
                                <h6 class="card-subtitle mb-2 text-muted mt-3">Mapa</h6>                                
                                <div id="map-container-google-1" class="z-depth-1-half map-container" width="100%">
                                <iframe
                                width="100%"
                                frameborder="0" style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDMnvqmPUl5f1uoZHnRgLuF6GhY6F4jYao
                        &q={{$restaurant->address->street}}+{{$restaurant->address->number}},{{$restaurant->address->city->name}}+{{$restaurant->address->city->province->country}}" allowfullscreen>
                                </iframe>
                                </div>                    
                                <!--Google Maps-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 order-0">
                @include('messages')
                @include('carrito')
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="modal-product">
            <img src="{{asset('storage/design/loading.svg')}}" alt="Espere por favor...">
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

    <!-- Modal -->
    <div class="modal fade" id="variantsItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Variantes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" id="product-modal-body">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>
    
    <a id="back-to-top" href="#" class="btn btn-primary btn-sm back-to-top d-none d-lg-block" role="button"><i class="fas fa-arrow-circle-up"></i> Ir arriba</a>
@endsection

@section('js-scripts')
    <script>
        $(document).ready(function(){       
            $('#back-to-top').hide();

            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('#back-to-top').fadeIn(100);
                }else{
                    $('#back-to-top').fadeOut(100);
                }
            });

            $('#back-to-top').click(function () {
                $('#back-to-top').tooltip('hide');
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });

            $('select#goToCategorySelect').on('change',function(){
                var valor = $(this).val();
                window.location.href = "#"+valor;
            });

            $('.product-card').click(function(){
                $('#addItemModal').modal('show');
            });
        });

        function checkOffset() {
            if($('#mobileCart').offset().top + $('#mobileCart').height() >= $('.footer').offset().top - 30)
                $('#mobileCart').css('position', 'fixed');
                $('#mobileCart').addClass('mb-5');
            if($(document).scrollTop() + window.innerHeight < $('.footer').offset().top)
                $('#mobileCart').removeClass('mb-5');
                $('#mobileCart').css('position', 'fixed'); // restore when you scroll up
        }

        function goToCart(){
            $('#mobileCart').tooltip('hide');
            $('body,html').animate({
                scrollTop: $('#cart-content').offset().top 
            }, 800);
            return false;
        }

        function showData(productid){
            $.ajax({
                url : '{{ route("product.showData") }}',
                type: 'POST',
                async : false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{productid:productid},
                success:function(data){
                    $('#modal-product').html(data)
                },
            });
        }

        
         $('#activeRestaurantModal').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget)

            var restaurantid = button.data('restaurantid')
            var modal = $(this)

            modal.find('.modal-body #restaurantid').val(restaurantid)
        })

        function addItem(id){
            var quantity = $('#product-quantity').val();
            var variants = [];
            $.each($("input[name='variants[]']:checked"), function(){
                variants.push($(this).val());
            });            
            var aditional_notes = $('#product-aditional_notes').val();

            $.ajax({
                url : '/carrito',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{
                    id:id,
                    quantity:quantity,
                    variants:variants,
                    aditional_notes:aditional_notes
                },
                success:function(data){
                    $('#cart-content').html(data);
                    cartFormat();
                    $('#finishOrder').show();
                    $('#addItemModal').modal('hide');
                    $('#trash-empty-cart').show();
                    $('#yes-confirm-empty-cart').hide();
                    $('#no-confirm-empty-cart').hide();
                },
                error:function(data){
                    console.log(data);
                    $('#addItemModal').modal('hide');
                    $.each(data.responseJSON, function(key,value) {
                        if(value.variants){
                            $('#cart-data').html('<div class="message-error alert alert-danger alert-dismissible fade show" role="alert">'+value.variants+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }else{
                            $('#cart-data').html('<div class="message-error alert alert-danger alert-dismissible fade show" role="alert">'+value+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }
                    });
                    setTimeout(function() {
                        $(".message-error").fadeOut(200);
                    }, 4000);
                }
            });
        }
        // =================================================================
    </script>
@endsection
