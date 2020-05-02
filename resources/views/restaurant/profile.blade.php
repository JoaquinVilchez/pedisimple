@extends('layouts.app')

@section('css-scripts')
    <style>
        .map-container{
        overflow:hidden;
        padding-bottom:56.25%;
        position:relative;
        height:0;
        }
        .map-container iframe{
        left:0;
        top:0;
        height:100%;
        width:100%;
        position:absolute;
        }
        
        .img-card {
            object-fit: cover;
            width: 80px;
            height: 80px;
        }

        .img-modal img{
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
    <section class="jumbotron px-0 pb-0 mb-0" style="background: url('https://images.pexels.com/photos/326279/pexels-photo-326279.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px 10% / cover transparent;">
        <div class="element">
        <div class="container text-white d-flex align-items-end col-lg-8 ">
            <div class="row d-flex align-items-end">
                <figure>
                    <img class="border m-1" width="110px" src="{{asset('images/uploads/commerce/'.$restaurant->image)}}" alt="">
                </figure>
                <section class="ml-3 mb-3">
                    <div class="title"><h3><strong>{{$restaurant->name}}</strong></h3></div>
                    <div class="info mb-0 ml-3"><p class="mb-0"><i class="fas fa-phone"></i> {{$restaurant->phone}}</p></div>
                    <div class="info mb-0 ml-3"><p class="mb-0"><i class="fas fa-map-marker-alt"></i> {{$restaurant->address->getFullAddress()}}</p></div>
                    
                    <div class="container d-flex">
                        <div class="profile_info d-inline mt-3 mx-2">
                            <span class="d-block profile_info_price">{{$restaurant->shipping_method}}</span>
                            <small class="d-block">Método de envío</small>
                        </div>
                        <div class="profile_info d-inline mt-3 mx-2">
                            <span class="d-block profile_info_price">${{$restaurant->shipping_price}}</span>
                            <small class="d-block">Costo de envío</small>
                        </div>
                        {{-- @if($restaurant->shipping_time) --}}
                        <div class="profile_info d-inline mt-3 mx-2">
                            <span class="d-block profile_info_price my-0">{{$restaurant->shipping_time}} min</span>
                            <small class="d-block my-0">Tiempo de envío</small>
                        </div>
                        {{-- @endif --}}
                    </div>
                </section>
            </div>  
        </div>
        </div>
    </section>
    <div class="sticky-top mb-4">
        <div class="alert alert-primary m-0 p-1 px-2" role="alert" style="text-align:center">
            <strong>Recuerda: La plataforma aún no está en línea para el público.</strong><br>
            Esto es una vista previa de como se vería tu comercio.
        </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        
        <div class="row">
            <div class="col-lg-8">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Productos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Informacion</a>
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
                    
                    <div class="alert alert-primary" role="alert" id="confirmEmptyCart" hidden>
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
                    <div class="list-group mb-3">
                        <h6>No tienes productos en tu pedido</h6>
                        <a href="#" class="btn btn-primary disabled">Ver comercios</a>
                        {{-- <a href="{{route('list.index')}}" class="btn btn-primary disabled">Ver comercios</a> --}}
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
                            <div class="card p-2 m-1">
                                <div class="row">
                                    <div class="col-4 pr-0">
                                    <img class="d-block border m-1 img-card" src="{{asset('images/uploads/products/'.$product->image)}}" alt="">
                                    </div>
                                    <div class="col-8 pl-0">
                                    <div class="card-block mt-2">
                                        <!--           <h4 class="card-title">Small card</h4> -->
                                        <h6><strong>{{$product->name}}</strong></h6>
                                        <span>${{$product->price}}</span>
                                        <span class="float-right mr-2" style="font-size:20px">
                                            <a style="color:#ffa64d" href="#" 
                                            data-productid="{{$product->id}}" 
                                            data-productname="{{$product->name}}" 
                                            data-productprice="{{$product->price}}" 
                                            data-productimage={{asset('images/uploads/products/'.$product->image)}}" 
                                            
                                            data-toggle="modal" data-target="#addItemModal">
                                            <i class="fas fa-plus-circle"></i></a>
                                        </span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach                   
                    </div>
                </div>
                @endif
                @endforeach
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card" >
                        <div class="card-body">
                          <h5 class="card-title">Información del comercio</h5>
                          
                        <h6 class="card-subtitle mb-2 text-muted mt-3">Dirección</h6>
                            <p><i class="fas fa-map-marker-alt"></i> {{$restaurant->address->getFullAddress()}}</p>

                        <h6 class="card-subtitle mb-2 text-muted mt-3">Teléfono</h6>
                            <p><i class="fas fa-phone"></i> {{$restaurant->phone}}</p>

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
                    <!--Google map-->
                    <div id="map-container-google-1" class="z-depth-1-half map-container my-5" width="100%">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3317.550740722295!2d-61.97026504901005!3d-33.74643152005511!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzPCsDQ0JzQ3LjIiUyA2McKwNTgnMDUuMSJX!5e0!3m2!1ses!2sar!4v1586535324154!5m2!1ses!2sar" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>                    
                    <!--Google Maps-->
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
            <h5 class="modal-title" id="restaurantName"></h5><br>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <h5><i class="fas fa-map-marker-alt"></i> Dirección</h5>
                <h6 class="modal-title" id="restaurantAddress"></h6>
                <hr>
                <h5><i class="fas fa-phone"></i> Teléfono</h5>
                <h6 class="modal-title" id="restaurantPhone"></h6>                  
            </div>
            <div class="modal-footer justify-content-center">
            <a class="btn btn-primary btn-lg btn-block" href="{{route('cart.empty')}}">Finalizar pedido</a>
                    <span class="badge badge-warning">Próximamente se podrá pedir online</span>       
            </div>
        </div>
        </div>
    </div>
@endsection

@section('js-scripts')
    <script>
        
        $('#addItemModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)


        var productid = button.data('productid')
        var productname = button.data('productname')
        var productprice = button.data('productprice')
        var productimage = button.data('productimage')
        var productdescription = button.data('productdescription')

        var modal = $(this)

        //data
        modal.find('.modal-body #productid').val(productid)
        modal.find('.modal-body #productname').val(productname)
        modal.find('.modal-body #productprice').val(productprice)

        //modal
        if (productimage!='/storage/no_image.png') {
            document.getElementById("modalImage").innerHTML='<img width="50%" src="'+productimage+'">'
        }else{
            document.getElementById("modalImage").innerHTML=''
        }
        document.getElementById("modalTitle").innerHTML=productname
        if(!productdescription==null){
            document.getElementById("modalDescription").innerHTML=productdescription
        }
        document.getElementById("modalPrice").innerHTML="Precio: (<strong>$"+productprice+"</strong>)"

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
        document.getElementById("restaurantName").innerHTML=restaurantname
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