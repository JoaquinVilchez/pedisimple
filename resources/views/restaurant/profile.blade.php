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
                            <h3 class="txt-bold">{{$restaurant->name}}</h3>
                            <div>
                                <p class="mb-0"><i class="fas fa-phone"></i> {{$restaurant->phone}}</p>
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
                                    <span class="d-block">${{$restaurant->shipping_price}}</span>
                                    <small class="d-block txt-muted">Costo de envío</small>
                                </div>
                                @if($restaurant->shipping_time)
                                    <div class="vl"></div>
                                    <div class="d-inline">
                                        <span class="d-block">{{$restaurant->shipping_time}} min</span>
                                        <small class="d-block txt-muted">Tiempo de envío</small>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
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
                        <a href="#" class="btn btn-primary" data-name="{{$restaurant->name}}" 
                            data-image="{{$restaurant->image}}" 
                            data-address="{{$restaurant->address->getFullAddress()}}" 
                            data-phone="{{$restaurant->phone}}" 
                            
                            data-toggle="modal" data-target="#restaurantInfo">Continuar</a>
                        {{-- <a href="{{route('checkout.index')}}" class="btn btn-danger">Continuar</a> --}}
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
                @foreach($categories as $category)
                @if(count($category->getProducts())>0)
                <div class="categoria mb-4">
                    <h3>{{$category->name}}</h3>
                    <p>{{$category->description}}</p>   
                    <div class="row">
                        @foreach($category->getProducts() as $product)
                        <div class="col-lg-6 px-1">
                            @if ($product->image == 'no_image.png')
                                <div class="card p-2 m-1" style="min-height:95%">
                                    <div class="row">
                                        <div class="col-10 pr-0 pl-4">
                                            <h6 class="mb-0"><strong>{{$product->name}}</strong></h6>
                                            @if($product->details)
                                            <div class="ml-2 mt-1">
                                                <small>{{$product->details}}</small><br>
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
                                            <h6 class="mb-0"><strong>{{$product->name}}</strong></h6>
                                                @if($product->details)
                                                <div class="mt-1">
                                                    <small>{{$product->details}}</small><br>
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
                                    <p>{{$restaurant->description}}</p>
                                </div>
                            </div>
                            <hr>
                            @endif
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="card-subtitle mb-2 text-muted mt-3">Dirección</h6>
                                    <p><i class="fas fa-map-marker-alt"></i> {{$restaurant->address->getFullAddress()}}</p>
                                </div>
                                <div class="col-6">
                                    <h6 class="card-subtitle mb-2 text-muted mt-3">Teléfono</h6>
                                    <p><i class="fas fa-phone"></i> {{$restaurant->phone}}</p>
                                </div>
                            </div>
                                <!--Google map-->
                                <h6 class="card-subtitle mb-2 text-muted mt-3">Mapa</h6>
                                <div id="map-container-google-1" class="z-depth-1-half map-container" width="100%">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3317.550740722295!2d-61.97026504901005!3d-33.74643152005511!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzPCsDQ0JzQ3LjIiUyA2McKwNTgnMDUuMSJX!5e0!3m2!1ses!2sar!4v1586535324154!5m2!1ses!2sar" frameborder="0" style="border:0" allowfullscreen></iframe>
                                </div>                    
                                <!--Google Maps-->
                            {{-- <h6 class="card-subtitle mb-2 text-muted mt-3">Horarios de apertura</h6>
                            <table class="table table-striped table-responsive">
                                @foreach ($opening_times as $day)
                                <tr>
                                    <td>{{$day->getDayName()}}</td>
                                    <td>{{substr($day->start_hour_1, 3)}} hs</td>
                                    <td>{{substr($day->end_hour_1, 3)}} hs</td>
                                    <td>{{substr($day->start_hour_2, 3)}} hs</td>
                                    <td>{{substr($day->end_hour_2, 3)}} hs</td>
                                </tr>
                                @endforeach
                            </table> --}}
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
@endsection

@section('js-scripts')
    <script>
        
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