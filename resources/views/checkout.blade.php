@extends('layouts.app')

@section('content')
<section class="jumbotron" style="background: url('https://images.pexels.com/photos/4020143/pexels-photo-4020143.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px 65% / cover transparent;">
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
        
        @include('messages')
        
        @if(!Auth::check())
            <form class="needs-validation" action="{{route('checkout.store')}}" method="POST" novalidate>
                @csrf
                @if(isset($restaurant))
                    <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}"> 
                @endif
                <input type="text" name="auth_user" value="false" class="form-control" hidden>
                    <h4>Datos personales</h4>
                    <div class="container">
                        <a href="{{route('login')}}" style="color:blue">¿Tienes una cuenta? Ingresa</a>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 mb-3">
                            <div class="form-group mb-1">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <label>Nombre</label>
                                        <input type="text" name="client_first_name" value="{{old('client_first_name')}}" class="form-control">
                                        {!!$errors->first('client_first_name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <label>Apellido</label>
                                        <input type="text" name="client_last_name" value="{{old('client_last_name')}}" class="form-control">
                                        {!!$errors->first('client_last_name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                    </div>
                                </div>
                            </div>
                            @if(\Cart::getCondition('Delivery'))
                                <div class="form-group mb-1">
                                    <div class="row">
                                        <div class="col-lg-6 col-8">
                                            <label>Calle</label>
                                            <input type="text" name="client_street" value="{{old('client_street')}}" class="form-control">
                                            {!!$errors->first('client_street', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                        </div>
                                        <div class="col-lg-2 col-4">
                                            <label>Número</label>
                                            <input type="text" name="client_number" value="{{old('client_number')}}" class="form-control">
                                            {!!$errors->first('client_number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                        </div>
                                        <div class="col-lg-2 col-6">
                                            <label>Piso</label>
                                            <input type="text" name="client_floor" class="form-control" value="{{old('client_floor')}}" placeholder="Opcional">
                                            {!!$errors->first('client_floor', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                        </div>
                                        <div class="col-lg-2 col-6">
                                            <label>Depto</label>
                                            <input type="text" name="client_department" class="form-control" value="{{old('client_department')}}" placeholder="Opcional">
                                            {!!$errors->first('client_department', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-4">
                                        <label>Prefijo</label>
                                        <input type="text" maxlength="4" name="client_characteristic" value="{{old('client_characteristic')}}" class="form-control">
                                        {!!$errors->first('client_characteristic', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                    </div>
                                    <div class="col-8">
                                        <label>Teléfono</label>
                                        <input type="text" maxlength="6" name="client_phone" value="{{old('client_phone')}}" class="form-control">
                                        {!!$errors->first('client_phone', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label>Notas adicionales <small>(Opcional)</small> </label>
                                        <textarea class="form-control" rows="3" name="client_aditional_notes" value="{{old('client_aditional_notes')}}" placeholder="Ejemplo: '¡La pizza sin aceitunas, por favor!'">{{old('client_aditional_notes')}}</textarea>
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
            @else
            <form class="needs-validation" action="{{route('checkout.store')}}" method="POST" novalidate>
                @csrf
                @if(isset($restaurant))
                    <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}"> 
                @endif
                <input type="text" name="auth_user" value="true" class="form-control" hidden>
                    <h4 class="mb-3">Datos personales</h4>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-6 mb-3">
                                    <label><strong>Nombre del solicitante:</strong></label>
                                    <p>{{Auth::user()->fullName()}}</p>
                                </div>
                                <div class="form-group col-6 mb-3">
                                    <label><strong>Teléfono:</strong></label>
                                    <p>{{Auth::user()->getPhone()}}</p>
                                </div>
                            </div>

                            <label><strong>Tipo de entrega:</strong></label>
                            @if(\Cart::getCondition('Delivery'))
                                <p>Delivery</p>
                            @else
                                <p>Retiro en local</p>
                            @endif

                            @if(\Cart::getCondition('Delivery'))
                                <label><strong>Dirección de entrega:</strong></label>
                                <input type="hidden" id="address_type" value="data-address" name="address_type">
                                <div id="address">
                                    <div class="row align-items-end">
                                        @if(count(Auth::user()->addresses)!=0)
                                        <div class="col-8">
                                            <select class="form-control" id="exampleFormControlSelect1" name="address">
                                            @foreach (Auth::user()->addresses as $address)
                                                <option value="{{$address->id}}">{{$address->getFullAddress()}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label></label>
                                            <a onclick="Address()" class="btn btn-outline-primary">Nueva dirección</a>
                                        </div>
                                        @else
                                            <div class="col-4">
                                                <label></label>
                                                <a onclick="Address()" class="btn btn-outline-primary">Nueva dirección</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div id="new-address" hidden>
                                    <div class="row align-items-end">
                                        <div class="col-xl-6 col-sm-12">
                                            <label>Calle</label>
                                            <input type="text" name="client_street" value="{{old('client_street')}}" class="form-control">
                                            {!!$errors->first('client_street', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                        </div>
                                        <div class="col-xl-2 col-sm-4">
                                            <label>Número</label>
                                        <input type="text" name="client_number" value="{{old('client_number')}}" class="form-control">
                                        {!!$errors->first('client_number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                        </div>
                                        <div class="col-xl-2 col-sm-4 col-6">
                                            <label>Piso</label>
                                            <input type="text" name="client_floor" value="{{old('client_floor')}}" class="form-control" placeholder="Opcional">
                                            {!!$errors->first('client_floor', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                        </div>
                                        <div class="col-xl-2 col-sm-4 col-6">
                                            <label>Depto</label>
                                            <input type="text" name="client_department" value="{{old('client_department')}}" class="form-control" placeholder="Opcional">
                                            {!!$errors->first('client_department', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                        </div>
                                    </div>
                                    <div class="d-inline mt-2">
                                        <a onclick="Address()" class="btn btn-secondary btn-sm text-white mr-2">Cancelar</a>
                                    </div>
                                    <div class="d-inline mb-0">
                                        <label class="mt-2">
                                        <span><input type="checkbox" name="save"> Guardar dirección para una próxima vez</span>
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-12 mb-3">
                                <label><strong>Notas adicionales</strong><small> (Opcional)</small></label>
                        <textarea class="form-control" rows="3" name="client_aditional_notes" value="{{old('client_aditional_notes')}}" placeholder="Ejemplo: '¡La pizza sin aceitunas, por favor!'">{{old('client_aditional_notes')}}</textarea>
                        </div>

                        <div class="form-group col-12 mb-3">
                            <div class="alert alert-warning" role="alert">
                                <strong>¡Importante!</strong>
                                <p>Esta acción no confirma el pedido, sino que envía el detalle del pedido y tus datos personales al comercio para coordinar el pedido y la entrega a través de WhatsApp o teléfono.</p>
                            </div>
                            <button class="subscribe btn btn-primary btn-block" type="submit" @if(Cart::isEmpty())disabled @endif> Enviar detalle de pedido </button>
                        </div>
                </form>
            @endif
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
                alert.removeAttribute("hidden","");
                button.setAttribute("hidden","");
            } else {
                alert.setAttribute("hidden","");
                button.removeAttribute("hidden","");    
            }
        }

    function Address(){
        address = document.getElementById("address");
        newaddress = document.getElementById("new-address");
        addresstype = document.getElementById("address_type");

        if ($('#new-address').is(':hidden')) {
                newaddress.removeAttribute("hidden","");
                address.setAttribute("hidden","");
                addresstype.value='new-address';
            } else {
                newaddress.setAttribute("hidden","");
                address.removeAttribute("hidden","");    
                addresstype.value='data-address';
        }
    }
</script>
@endsection