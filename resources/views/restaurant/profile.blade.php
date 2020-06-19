@extends('layouts.app')

@section('css-scripts')
<style>
    .vl {
      border-left: 1px solid;
      height: 30px;
      margin: 0px 20px
    }
</style>
@endsection

@section('content')
    <section class="jumbotron px-0 pb-0 mb-0 rounded-0" style="background: url('https://images.pexels.com/photos/326279/pexels-photo-326279.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px 10% / cover transparent;">
        <div class="element">
            <div class="container text-white col-lg-8 ">
                <div class="row pb-2">
                    <div class="col-xl-2 col-lg-2 col-md-2 d-none d-md-block d-lg-block d-xl-block">
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="border" width="120px" src="{{asset('images/uploads/commerce/'.$restaurant->image)}}" alt="">
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10 pl-0">
                        <div class="ml-3">
                            <div class="d-flex align-items-center">
                                <h3 class="txt-bold d-inline">{{$restaurant->name}}</h3>
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
                                    <span class="d-block">${{$restaurant->shipping_price}} <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Importante: El precio del delivery puede variar en base a la distancia."></i></span>
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
            <div class="col-lg-8">
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
        
        <div class="row justify-content-center">

            <div class="col-md-4 order-md-2 mb-4">
                @include('messages')
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Tu pedido</span>
                    <span class="badge badge-secondary badge-pill">{{Cart::getTotalQuantity()}}</span>
                </h4>

                    @if(!Cart::isEmpty())
                    @include('carrito')
                    
                    <div class="alert alert-primary" style="font-size:15px" role="alert" id="confirmEmptyCart" hidden>
                        ¿Estás seguro de vaciar el carrito? <a href="{{route('cart.empty')}}" class="alert-link">Si</a> | <a onclick="confirmAlert()" class="alert-link" href="#">No</a>
                    </div>
                    <div class="float-right">
                        <button onclick="confirmAlert()" class="btn btn-secondary" id="btnConfirmEmptyCart">Vaciar carrito</button>
                        <a href="{{route('checkout.index')}}" class="btn btn-primary">Continuar</a>
                    </div>
                    @else
                    <div class="list-group mb-3" style="text-align: center">
                        <div style="text-align: center" class="my-4">
                            <img src="{{asset('images/design/empty_cart.png')}}" alt="" width="100px" style="opacity: 0.7">
                            <small class="d-block mt-2  ">No tienes productos en tu pedido</small>
                        </div>
                        <a href="{{route('list.index')}}" class="btn btn-primary">Ver comercios</a>
                    </div>
                    @endif
            </div>

            <div class="col-lg-8 tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                
                    {{-- TEMPORALES --}}
                    @if(count($temporary_products)!=0)
                        <h3>Temporales</h3>
                        <div class="row mb-4">
                            @foreach($temporary_products as $temporary_product)
                            <div class="col-lg-6 px-1" >
                                @if ($temporary_product->image == 'no_image.png')
                                    <div class="card p-2 m-1" style="min-height:95%" onclick="alerta();">
                                        <div class="row">
                                            <div class="col-10 pr-0 pl-4">
                                                <h6 class="mb-0"><strong>{{ucfirst($temporary_product->name)}}</strong></h6>
                                                @if($temporary_product->details)
                                                <div class="ml-2 mt-1">
                                                    <small>{{ucfirst($temporary_product->details)}}</small><br>
                                                </div>
                                                @endif
                                                <div class="ml-2 mt-1">
                                                    <span>${{$temporary_product->price}}</span>
                                                </div>
                                                <small><span class="badge badge-danger" style="font-weight: 400"><i class="far fa-clock"></i> {{$temporary_product->getRemainingDays()}}</span></small>
                                            </div>  
                                            
                                            <div class="col-2 d-flex align-items-center">
                                                <span class="float-right mr-2" style="font-size:20px">
                                                    <a style="color:#ffa64d" href="#" 
                                                    data-productid="{{$temporary_product->id}}" 
                                                    data-productname="{{$temporary_product->name}}" 
                                                    data-productprice="{{$temporary_product->price}}"       
                                                    data-productimage="{{$temporary_product->image}}"  
                                                    data-productdescription="{{$temporary_product->details}}"  
                                                    data-toggle="modal" data-target="#addItemModal">
                                                    <i class="fas fa-plus-circle"></i></a>
                                                </span>
                                            </div>        
                                        </div>                                
                                    </div>
                                @else
                                    <div class="card p-2 m-1" style="min-height:95%">
                                        <div class="row">
                                            <div class="col-4 pr-0">
                                                <div class="d-flex align-items-center">
                                                    <img class="d-block border m-1 img-card" src="{{asset('images/uploads/products/'.$temporary_product->image)}}" alt="">
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
                                                        <span>${{$temporary_product->price}}</span>
                                                    </div>
                                                    <small><span class="badge badge-danger" style="font-weight: 400"><i class="far fa-clock"></i> {{$temporary_product->getRemainingDays()}}</span></small>
                                            </div>  
                                            <div class="col-2 d-flex align-items-center">
                                                <span class="float-right mr-2" style="font-size:20px">
                                                    <a style="color:#ffa64d" href="#" 
                                                    data-productid="{{$temporary_product->id}}" 
                                                    data-productname="{{$temporary_product->name}}" 
                                                    data-productprice="{{$temporary_product->price}}"  
                                                    data-productimage="{{asset('images/uploads/products/'.$temporary_product->image)}}"                                                
                                                    data-productdescription="{{$temporary_product->details}}"  
                                                    data-toggle="modal" data-target="#addItemModal">
                                                    <i class="fas fa-plus-circle"></i></a>
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
                <div class="categoria mb-4">
                    <h3>{{ucfirst($category->name)}}</h3>
                    <p>{{ucfirst($category->description)}}</p>   
                    <div class="row">
                        @foreach($category->getProducts() as $product)
                        @if ($product->temporary==false)
                            <div class="col-lg-6 px-1">
                                @if ($product->image == 'no_image.png')
                                    <div class="card p-2 m-1" style="min-height:95%">
                                        <div class="row">
                                            <div class="col-10 pr-0 pl-4">
                                                <h6 class="mb-0"><strong>{{ucfirst($product->name)}}</strong></h6>
                                                @if($product->details)
                                                <div class="ml-2 mt-1">
                                                    <small>{{ucfirst($product->details)}}</small><br>
                                                </div>
                                                @endif
                                                <div class="ml-2 mt-1">
                                                    <span>${{$product->price}}</span>
                                                </div>
                                            </div>  
                                            <div class="col-2 d-flex align-items-center">
                                                <span class="float-right mr-2" style="font-size:20px">
                                                    <a style="color:#ffa64d" href="#" 
                                                    data-productid="{{$product->id}}" 
                                                    data-productname="{{$product->name}}" 
                                                    data-productprice="{{$product->price}}"       
                                                    data-productimage="{{$product->image}}"  
                                                    data-productdescription="{{$product->details}}"  
                                                    data-toggle="modal" data-target="#addItemModal">
                                                    <i class="fas fa-plus-circle"></i></a>
                                                </span>
                                            </div>        
                                        </div>                                
                                    </div>
                                @else
                                    <div class="card p-2 m-1" style="min-height:95%">
                                        <div class="row">
                                            <div class="col-4 pr-0">
                                                <div class="d-flex align-items-center">
                                                    <img class="d-block border m-1 img-card" src="{{asset('images/uploads/products/'.$product->image)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-6 pt-1 px-0">
                                                <h6 class="mb-0"><strong>{{ucfirst($product->name)}}</strong></h6>
                                                    @if($product->details)
                                                    <div class="mt-1">
                                                        <small>{{ucfirst($product->details)}}</small><br>
                                                    </div>
                                                    @endif
                                                    <div class="mt-1">
                                                        <span>${{$product->price}}</span>
                                                    </div>
                                            </div>  
                                            <div class="col-2 d-flex align-items-center">
                                                <span class="float-right mr-2" style="font-size:20px">
                                                    <a style="color:#ffa64d" href="#" 
                                                    data-productid="{{$product->id}}" 
                                                    data-productname="{{$product->name}}" 
                                                    data-productprice="{{$product->price}}"  
                                                    data-productimage="{{asset('images/uploads/products/'.$product->image)}}"                                                
                                                    data-productdescription="{{$product->details}}"  
                                                    data-toggle="modal" data-target="#addItemModal">
                                                    <i class="fas fa-plus-circle"></i></a>
                                                </span>
                                            </div>        
                                        </div>                                
                                    </div>
                                @endif
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
                                    <table class="table table-striped responsive" style="font-size: 15px">
                                        <tbody>
                                            @foreach($restaurant->getSchedule() as $day)
                                            @if(is_array($day))
                                                <tr>
                                                    <td>{{getDayName($day)}}</td>
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
                                                        <td>Cerrado</td>
                                                        <td></td>
                                                        <td>Cerrado</td>
                                                    @else
                                                        <td>{{substr($day['start_hour_2'], 0, -3)}}hs</td>
                                                            <td>a</td>
                                                        <td>{{substr($day['end_hour_2'], 0, -3)}}hs</td>
                                                    @endif
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{getDayName($day)}}</td>
                                                    <td>Cerrado</td>
                                                    <td></td>
                                                    <td>Cerrado</td>
                                                    <td>Cerrado</td>
                                                    <td></td>
                                                    <td>Cerrado</td>
                                                </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                                <!--Google map-->
                                <h6 class="card-subtitle mb-2 text-muted mt-3">Mapa</h6>

                                {{-- {{dd($restaurant->address->street,$restaurant->address->number,$restaurant->address->city->name, $restaurant->address->city->province->name, $restaurant->address->city->province->country)}} --}}
                                
                                <div id="map-container-google-1" class="z-depth-1-half map-container" width="100%">
                                <iframe
                                width="100%"
                                frameborder="0" style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDMnvqmPUl5f1uoZHnRgLuF6GhY6F4jYao
                        &q={{$restaurant->address->street}}+{{$restaurant->address->number}},{{$restaurant->address->city->name}}+{{$restaurant->address->city->province->country}}" allowfullscreen>
                                </iframe>
                                    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3317.550740722295!2d-61.97026504901005!3d-33.74643152005511!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzPCsDQ0JzQ3LjIiUyA2McKwNTgnMDUuMSJX!5e0!3m2!1ses!2sar!4v1586535324154!5m2!1ses!2sar" frameborder="0" style="border:0" allowfullscreen></iframe> --}}
                                </div>                    
                                <!--Google Maps-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalTitle"></h5><br>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{route('cart.store')}}" method="post">
                    @csrf
                <div class="modal-body">
                    <input type="hidden" id="productid" name="id">
                    <input type="hidden" id="productname" name="name">
                    <input type="hidden" id="productprice" name="price">
                    <div id="modalImage" class="img-fluid img-modal"></div>
                    <div class="px-2">
                        <p class="text-mute" id="modalDescription"></p>
                        <div class="form-group">
                            <h5 id="modalPrice"></h5>
                        </div>
                        <div class="form-group">
                            <label>Cantidad</label>
                            <select name="quantity" id="productquantity">
                                @for ($i = 1; $i < 10; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Notas adicionales"></textarea>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-right mr-2">Agregar a mi pedido</button>
            </form>
            </div>  
        </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="restaurantInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="text-align:center">
            <div class="modal-header">
            <div class="modal-title"></div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <img src="{{asset('images/design/conversation.svg')}}" alt="" class="mb-3" style="width: 100px">
            <h4 class="txt-bold">¡Listo!</h4>           
            <p>Te dejamos los datos del comercio para que puedas comunicarte con ellos y coordinar el pedido.</p>
            <small class="text-muted">Próximamente se podrá pedir online</small>       
            <hr>
                <h5 class="txt-bold" id="restaurantName"></h5>
                <hr>
                <h5><i class="fas fa-map-marker-alt"></i> Dirección</h5>
                <h6 class="modal-title" id="restaurantAddress"></h6>
                <hr>
                <h5><i class="fas fa-phone"></i> Teléfono</h5>
                <h6 class="modal-title" id="restaurantPhone"></h6>                  
            </div>
            <div class="modal-footer justify-content-center">
            <a class="btn btn-primary btn-lg btn-block" href="{{route('cart.empty')}}">Vaciar carrito</a>
                <hr>        
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
         $('#activeRestaurantModal').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget)

            var restaurantid = button.data('restaurantid')
            var modal = $(this)

            modal.find('.modal-body #restaurantid').val(restaurantid)
        })
        
        $('#addItemModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)

        var productid = ""
        var productname = ""
        var productprice = ""
        var productdescription = ""
        var productimage = ""
        
        var productid = button.data('productid')
        var productname = button.data('productname')
        var productprice = button.data('productprice')
        var productdescription = button.data('productdescription')
        var productimage = button.data('productimage')

        var modal = $(this)

        //data
        modal.find('.modal-body #productid').val(productid)
        modal.find('.modal-body #productname').val(productname)
        modal.find('.modal-body #productprice').val(productprice)

        //modal
        if (productimage=='no_image.png') {
            document.getElementById("modalImage").innerHTML=""
        }else{
            document.getElementById("modalImage").innerHTML='<img width="50%" src="'+productimage+'">'
        }

        document.getElementById("modalPrice").innerHTML="Precio: (<strong>$"+productprice+"</strong>)"

        document.getElementById("modalTitle").innerHTML=productname
        
        if(!productdescription==""){
            document.getElementById("modalDescription").innerHTML="<p class='mb-0 mt-2 txt-bold'>Descripción del producto:</p>"+productdescription
        }else{
            document.getElementById("modalDescription").innerHTML=""
        }

        });

        // ==============================================================

        $('#restaurantInfo').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)

        var restaurantname = button.data('name')
        var restaurantimage = button.data('image')
        var restaurantaddress = button.data('address')
        var restaurantphone = button.data('phone')

        var modal = $(this)


        //modal
        document.getElementById("restaurantName").innerHTML="Datos de "+restaurantname
        document.getElementById("restaurantAddress").innerHTML=restaurantaddress
        document.getElementById("restaurantPhone").innerHTML=restaurantphone

        });

        // =================================================================

        function confirmAlert(){
            alert = document.getElementById("confirmEmptyCart");
            button = document.getElementById("btnConfirmEmptyCart");

            if ($('#confirmEmptyCart').is(':hidden')) {
                console.log("Esta oculto");
                alert.removeAttribute("hidden","");
                button.setAttribute("hidden","");
            } else {
                alert.setAttribute("hidden","");
                button.removeAttribute("hidden","");    
            }
        }

    </script>
@endsection