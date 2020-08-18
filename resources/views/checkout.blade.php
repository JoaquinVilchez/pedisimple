@extends('layouts.app')

@section('content')
<section class="jumbotron rounded-0 text-center p-0 mb-0" style="background: url('https://images.pexels.com/photos/1435907/pexels-photo-1435907.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px / cover transparent;">
    <div class="element">
      <div class="container d-flex align-items-center justify-content-center" style="height:150px;">
          <h1 class="text-white" style="text-shadow: 0px 5px 8px rgba(0,0,0,0.6);"><strong>Checkout</strong></h1>
        </div>
      </div>
    </div>
</section>

<div id="step-1">
    <div class="d-flex justify-content-center">
        <div class="col-10">
            <div class="d-flex justify-content-center">
                <div class="row">
                    <h6 style="text-align: center" class="text-muted my-4">¡Ya casi!<br>
                    Completa tus datos para poder finalizar el pedido
                    <hr>
                    </h6>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="col-8">
                    <div class="row">
                        <div class="col-6 border-right">
                            <h6 class="txt-bold">Nuevos clientes</h6>
                            <div>
                                <small><p class="my-2">Obtené tu cuenta de manera gratuita para poder obtener más beneficios.</p></small>
                                <a href="#" class="btn btn-primary btn-sm my-0">Registrarme</a>
                                <hr>
                            </div>
                            <div>
                                <small><p class="my-2">Completá tu pedido como invitado.</p></small>
                                <a href="#" id="guest_button" class="btn btn-primary btn-sm my-0">Continuar como invitado</a>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <h6 class="txt-bold">Ya tengo una cuenta</h6>
                            <div>
                                <form>
                                    <div class="form-group">
                                    <small><label for="inputEmail" class="mb-0">Correo electrónico</label></small>
                                    <input type="email" class="form-control form-control-sm my-0" id="inputEmail" aria-describedby="emailHelp">
                                    <small><label for="inputPassword" class="mb-0">Contraseña</label></small>
                                    <input type="password" class="form-control form-control-sm my-0" id="inputPassword">
                                    <small class="float-right my-2"><a href="#">¿Olvidaste la contraseña?</a></small>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block btn-sm my-0">Iniciar sesión</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="step-2">
    <div class="container my-4">
        <div class="row">
            {{-- CART --}}
            <div class="col-md-4 order-md-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="align-items-center">
                        <h5 class="d-inline">Tu pedido</h5>
                        <small><a style="cursor: pointer" class="d-inline" onclick="confirmAlert()" id="btnConfirmEmptyCart"><span><i class="fas fa-trash-alt"></i></span></a></small>
                    </div>
                    <div>
                        <span class="badge badge-secondary badge-pill d-inline">{{Cart::getTotalQuantity()}}</span>
                    </div>
                </div>
                <div class="alert alert-primary mt-2" style="font-size:15px" role="alert" id="confirmEmptyCart" hidden>
                    ¿Estás seguro de vaciar el carrito? <a href="{{route('cart.empty')}}" class="alert-link">Si</a> | <a onclick="confirmAlert()" class="alert-link" style="cursor: pointer">No</a>
                </div>
                @if(!Cart::isEmpty())
                    <div class="restaurant-info d-flex align-items-center my-3">
                        <div class="d-inline">
                            <img width="50px" class="border rounded" data-original="{{asset('images/uploads/commerce/'.$restaurant->image)}}" alt="">
                        </div>
                        <div class="d-inline ml-3">
                            <h6 class="txt-bold m-0">{{$restaurant->name}}</h6>
                            <small><p class="m-0"><a target="_blank" href="https://wa.me/549{{str_replace('-','',$restaurant->getPhone())}}"><i class="fab fa-whatsapp"></i> {{$restaurant->getPhone()}}</p></a></small>
                        </div>  
                    </div>
                    @include('carrito')
                    <div>
                        <a href="{{route('restaurant.show', $restaurant->slug)}}" class="btn btn-link"><i class="fas fa-angle-left"></i> Seguir comprando</a>
                    </div>
                    <hr class="d-block d-md-none">
                @else
                    <div class="list-group mb-3" style="text-align: center">
                        <div style="text-align: center" class="my-4">
                            <img data-original="{{asset('images/design/empty_cart.png')}}" alt="" width="100px" style="opacity: 0.7">
                            <small class="d-block mt-2  ">No tienes productos en tu pedido</small>
                        </div>
                        <a href="{{route('list.index')}}" class="btn btn-primary">Ver comercios</a>
                    </div>
                @endif
            </div>
            {{-- CART --}}

            <div class="col-md-8 order-md-1">
                    @include('messages')                    
                    @if(!Auth::check())
                        <form class="needs-validation" action="{{route('checkout.store')}}" method="POST" novalidate autocomplete="off">
                            @csrf
                            @if(isset($restaurant))
                                <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}"> 
                            @endif
                            <input type="text" name="auth_user" value="false" class="form-control" hidden>
                            <div class="row">
                                <div class="col-md-12">                                                            
                                    <div class="mb-2">
                                        <h5 class="d-inline">Continuar como invitado</h5> 
                                        <small class="d-inline ml-2" style="font-size: 12px">¿Tienes una cuenta? <a href="#">Inicia sesión</a></small>
                                    </div>
                                        <div class="form-group mb-1">
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <label>Nombre</label>
                                                    <input type="text" name="client_first_name" value="{{old('client_first_name')}}" class="form-control" autocomplete="off">
                                                    {!!$errors->first('client_first_name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <label>Apellido</label>
                                                    <input type="text" name="client_last_name" value="{{old('client_last_name')}}" class="form-control" autocomplete="off">
                                                    {!!$errors->first('client_last_name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        @if(\Cart::getCondition('Delivery'))
                                            <div class="form-group mb-1">
                                                <div class="row">
                                                    <div class="col-lg-6 col-8">
                                                        <label>Calle</label>
                                                        <input type="text" name="client_street" value="{{old('client_street')}}" class="form-control" autocomplete="off">
                                                        {!!$errors->first('client_street', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                    </div>
                                                    <div class="col-lg-2 col-4">
                                                        <label>Número</label>
                                                        <input type="text" onkeypress="return onlyNumberKey(event)" name="client_number" value="{{old('client_number')}}" class="form-control" autocomplete="off">
                                                        {!!$errors->first('client_number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                    </div>
                                                    <div class="col-lg-2 col-6">
                                                        <label>Piso</label>
                                                        <input type="text" onkeypress="return onlyNumberKey(event)" name="client_floor" class="form-control" value="{{old('client_floor')}}" placeholder="Opcional" autocomplete="off">
                                                        {!!$errors->first('client_floor', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                    </div>
                                                    <div class="col-lg-2 col-6">
                                                        <label>Depto</label>
                                                        <input type="text" name="client_department" class="form-control" value="{{old('client_department')}}" placeholder="Opcional" autocomplete="off">
                                                        {!!$errors->first('client_department', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="form-group mb-2">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label>Prefijo</label>
                                                    <div class="input-group">                                     
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text">0</span>
                                                        </div>
                                                        <input type="text" name="client_characteristic" value="{{old('client_characteristic')}}" class="form-control" maxlength="4" onkeypress="return onlyNumberKey(event)" autocomplete="off">
                                                    </div>
                                                    {!!$errors->first('client_characteristic', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                </div>
                                                <div class="col-8">
                                                    <label>Teléfono</label>
                                                    <div class="input-group">                                     
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text">15</span>
                                                        </div>
                                                        <input type="text" name="client_phone" value="{{old('client_phone')}}" class="form-control" maxlength="6" onkeypress="return onlyNumberKey(event)" autocomplete="off">
                                                    </div>
                                                    {!!$errors->first('client_phone', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="row">
                                                <div class="col">
                                                    <label>Notas adicionales <small>(Opcional)</small> </label>
                                                    <textarea class="form-control" rows="3" name="client_aditional_notes" value="{{old('client_aditional_notes')}}" placeholder="Ejemplo: '¡La pizza sin aceitunas, por favor!'" autocomplete="off">{{old('client_aditional_notes')}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-warning" role="alert" style="font-size: 14px">
                                            <strong>¡Importante!</strong>
                                            <p class="mb-0">Esta acción no confirma el pedido, sino que envía el detalle del pedido y tus datos personales al comercio para coordinar el pedido y la entrega a través de WhatsApp o teléfono.</p>
                                        </div>
                                        <button class="subscribe btn btn-primary btn-block" type="submit" @if(Cart::isEmpty()) disabled @endif> Finalizar pedido </button>
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
                                                    <a onclick="address()" class="btn btn-outline-primary">Nueva dirección</a>
                                                </div>
                                                @else
                                                    <div class="col-4">
                                                        <label></label>
                                                        <a onclick="address()" class="btn btn-outline-primary">Nueva dirección</a>
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
                                    <div class="alert alert-warning py-2" role="alert" style="font-size: .8em">
                                        <strong>¡Importante!</strong>
                                        <p class="mb-0">Esta acción no confirma el pedido, sino que envía el detalle del pedido y tus datos personales al comercio para coordinar el pedido y la entrega a través de WhatsApp o teléfono.</p>
                                    </div>
                                    <button class="subscribe btn btn-primary btn-block" type="submit" @if(Cart::isEmpty())disabled @endif> Enviar detalle de pedido </button>
                                </div>
                        </form>
                    @endif
                </div>
            </div>
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

@endsection

@section('js-scripts')
<script>    
    $(document).ready(function(){
        var AuthUser = "{{{ (Auth::user()) ? true : false }}}";
        if(AuthUser==1){
            $('#step-1').hide();
            $('#step-2').show();
        }else{
            $('#step-1').show();
            $('#step-2').hide();
        }
    
        $('#guest_button').on('click', function(){
            $('#step-1').hide();
            $('#step-2').fadeIn(500);
        })
    });

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

    function address(){
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