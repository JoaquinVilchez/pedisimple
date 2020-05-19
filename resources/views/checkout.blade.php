@extends('layouts.app')

@section('content')
<section class="jumbotron" style="background: url('https://images.pexels.com/photos/2733918/pexels-photo-2733918.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px 40% / cover transparent;">
    <div class="container text-white text-center">
       <h1>Checkout</h1>
    </div>
</section>

<div class="container">
    <div class="row mb-5">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Tu pedido</span>
                {{-- <span class="badge badge-secondary badge-pill">{{Cart::session(Auth::user()->id)->getTotalQuantity()}}</span> --}}
            </h4>
            @if(!Cart::isEmpty())
                    <h6>Comercio: {{$restaurant->name}}</h6>
                @include('carrito')
                <div>
                    <div class="alert alert-primary" style="font-size:15px" role="alert" id="confirmEmptyCart" hidden>
                        ¿Estás seguro de vaciar el carrito? <a href="{{route('cart.empty')}}" class="alert-link">Si</a> | <a onclick="confirmAlert()" class="alert-link" href="#">No</a>
                    </div>
                    <button onclick="confirmAlert()" class="btn btn-secondary float-right btn-block" id="btnConfirmEmptyCart">Vaciar carrito</button>
                    <a class="btn btn-primary float-right btn-block mb-1" href="{{route('restaurant.show', $restaurant->slug)}}">Seguir comprando</a>
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
        <div class="col-md-8 order-md-1">
        <form class="needs-validation" action="{{route('checkout.store')}}" method="POST" novalidate>
            @csrf
            @if(isset($restaurant))
                <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}"> 
            @endif
                <h4 class="mb-3">Datos personales</h4>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group mb-1">
                            <div class="row">
                                <div class="col">
                                    <label>Nombre</label>
                                    <input type="text" name="client_first_name" class="form-control">
                                </div>
                                <div class="col">
                                    <label>Apellido</label>
                                    <input type="text" name="client_last_name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-1">
                            <div class="row">
                                <div class="col-6">
                                    <label>Dirección</label>
                                    <input type="text" name="client_address" class="form-control">
                                </div>
                                <div class="col-2">
                                    <label>Número</label>
                                    <input type="text" name="client_number" class="form-control">
                                </div>
                                <div class="col-2">
                                    <label>Piso</label>
                                    <input type="text" name="client_floor" class="form-control" placeholder="Opcional">
                                </div>
                                <div class="col-2">
                                    <label>Depto</label>
                                    <input type="text" name="client_department" class="form-control" placeholder="Opcional">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="row">
                                <div class="col-4">
                                    <label>Prefijo</label>
                                    <input type="text" name="client_characteristic" class="form-control">
                                </div>
                                <div class="col-8">
                                    <label>Teléfono</label>
                                    <input type="text" name="client_phone" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col">
                                    <label>Notas adicionales <small>(Opcional)</small> </label>
                                    <textarea class="form-control" rows="3" name="client_aditional_notes" placeholder="Ejemplo: '¡La pizza sin aceitunas, por favor!'"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-warning" role="alert">
                            <strong>¡Importante!</strong>
                            <p>Esta acción no confirma el pedido, sino que envía el detalle del pedido y tus datos personales al comercio para coordinar el pedido y la entrega a través de WhatsApp o teléfono.</p>
                        </div>
                        <button class="subscribe btn btn-primary btn-block" type="submit" @if(Cart::isEmpty())disabled @endif> Enviar detalle de pedido </button>
                        
                    </div>
                </div>
            </form>
            </div>
            {{-- <div class="mb-4">
                <h4 class="mb-3">Selecciona un metodo de pago</h4>
                <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#nav-tab-delivery">
                        <i class="fas fa-motorcycle"></i> Pago al delivery</a></li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#nav-tab-card">
                        <i class="fa fa-credit-card"></i> Pago online</a></li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="nav-tab-delivery">
                        <div class="form-group">
                            <label for="cardNumber">Ingresa el con cuanto vas a pagar:</label>
                            <div class="input-group col-lg-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupPrepend2">$</span>
                                </div>
                                <input type="text" class="form-control" id="validationDefaultUsername"  aria-describedby="inputGroupPrepend2" required>
                              </div>
                            <small class="ml-3">Opcional</small>                            
                        </div>
                    </div> <!-- tab-pane.// -->

                        <div class="tab-pane fade" id="nav-tab-card">
                            <p class="alert alert-success">Some text success or error</p>
                                <div class="form-group">
                                    <label for="username">Full name (on the card)</label>
                                    <input type="text" class="form-control" name="username" placeholder="" required="">
                                </div> <!-- form-group.// -->
                            
                                <div class="form-group">
                                    <label for="cardNumber">Card number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cardNumber" placeholder="">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-muted">
                                                <i class="fab fa-cc-visa"></i>   <i class="fab fa-cc-amex"></i>   
                                                <i class="fab fa-cc-mastercard"></i> 
                                            </span>
                                        </div>
                                    </div>
                                </div> <!-- form-group.// -->
                            
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label><span class="hidden-xs">Expiration</span> </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="MM" name="">
                                                <input type="number" class="form-control" placeholder="YY" name="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                            <input type="number" class="form-control" required="">
                                        </div> <!-- form-group.// -->
                                    </div>
                                </div> <!-- row.// -->
                        </div> <!-- tab-pane.// -->
                </div> <!-- tab-content .// -->
            </div> --}}
        </div>
    </div>
</div>
@endsection

@section('js-scripts')
<script>
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