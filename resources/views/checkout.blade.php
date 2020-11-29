@extends('layouts.app')

@section('content')
<section class="jumbotron rounded-0 text-center p-0 mb-0" style="background: url('https://images.pexels.com/photos/1435907/pexels-photo-1435907.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px / cover transparent;">
    <div class="gradient">
      <div class="container d-flex align-items-center justify-content-center" style="height:150px;">
          <h1 class="text-white" style="text-shadow: 0px 5px 8px rgba(0,0,0,0.6);"><strong>Checkout</strong></h1>
        </div>
      </div>
    </div>
</section>

<div id="step-1">
    <div class="d-flex justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-center">
                <div class="row">
                    <h6 style="text-align: center" class="text-muted my-4">¡Ya casi!<br>
                    Completa tus datos para poder finalizar el pedido
                    <hr>
                    </h6>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <h6 class="txt-bold">Nuevos clientes</h6>
                            <div>
                                <small><p class="my-2">Obtené tu cuenta de manera gratuita para poder obtener más beneficios.</p></small>
                                <a href="{{ route('register') }}" class="btn btn-primary btn-sm my-0 btn-xs-block">Registrarme</a>
                                <hr>
                            </div>
                            <div class="mb-3">
                                <small><p class="my-2">Completá tu pedido como invitado.</p></small>
                                <a href="#" id="guest_button" class="btn btn-primary btn-sm my-0 btn-xs-block">Continuar como invitado</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="txt-bold">Ya tengo una cuenta</h6>
                            <div>
                                <form id="checkout-login-form">
                                    <div class="form-group">
                                    <small><label for="inputEmail" class="mb-0">Correo electrónico</label></small>
                                    <input type="email" class="form-control form-control-sm my-0" id="inputEmail" aria-describedby="emailHelp">
                                    <small><label for="inputPassword" class="mb-0">Contraseña</label></small>
                                    <input type="password" class="form-control form-control-sm my-0" id="inputPassword">
                                    <small class="float-right my-2"><a href="{{ route('password.request') }}">¿Olvidaste la contraseña?</a></small>
                                    </div>
                                    <button class="spinnerClickButton btn btn-primary btn-block btn-sm my-0" id="btn-submit-form" type="button">
                                        <i class="loadingIcon fas fa-spinner fa-spin d-none"></i> 
                                        <span class="btn-txt">Iniciar sesión</span>
                                    </button>
                                </form>
                            </div>
                            <div id="data" class="my-3"></div>
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

            <div class="col-md-4 order-md-2">
                    @include('carrito')
            </div>

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
                                        <small class="d-inline ml-2" style="font-size: 12px">¿Tienes una cuenta? <a href="#" id="has_account">Inicia sesión</a></small>
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
                                        <div id="guest_address">
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
                                        </div>

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
                                        <button class="spinnerSubmitButton btn btn-primary btn-block" id="checkout-finish-order" type="submit" @if(Cart::isEmpty()) disabled @endif>
                                            <i class="loadingIcon fas fa-spinner fa-spin d-none"></i>
                                            <span class="btn-txt">Finalizar pedido</span>
                                        </button>
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
                                        <div class="form-group col-12 col-md-4 mb-3">
                                            <label><strong>Nombre del solicitante:</strong></label>
                                            <p>{{Auth::user()->fullName()}}</p>
                                        </div>
                                        <div class="form-group col-12 col-md-4 mb-3">
                                            <label><strong>Teléfono:</strong></label>
                                            <p>{{Auth::user()->getPhone()}}</p>
                                        </div>
                                        <div class="form-group col-12 col-md-4 mb-3">
                                            <label><strong>Tipo de entrega:</strong></label>
                                            @if(\Cart::getCondition('Delivery'))
                                                <p class="shipping_method_text">Delivery</p>
                                            @else
                                                <p class="shipping_method_text">Retiro en local</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- @if(\Cart::getCondition('Delivery')) --}}
                                        <div id="checkout-delivery-info" @if(\Cart::getCondition('Delivery')) class="checkout-delivery" @else class="checkout-pickup" @endif>
                                            <input type="hidden" id="address_type" value="data-address" name="address_type">
                                            <label><strong>Dirección de entrega:</strong></label>
                                            <div id="address">
                                                <div class="row align-items-end">
                                                    @if(count(Auth::user()->addresses)!=0)
                                                    <div class="col-6">
                                                        <select class="form-control" id="exampleFormControlSelect1" name="address">
                                                        @foreach (Auth::user()->addresses as $address)
                                                            <option value="{{$address->id}}">{{$address->getFullAddress()}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <a onclick="newAddress();" class="btn btn-block btn-outline-primary">Nueva dirección</a>
                                                    </div>
                                                    @else
                                                        <div class="col-6">
                                                            <a onclick="newAddress();" class="btn btn-block btn-outline-primary">Nueva dirección</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="new-address">
                                                <div class="row align-items-end">
                                                    <div class="col-xl-6 col-sm-12">
                                                        <label>Calle</label>
                                                        <input type="text" name="client_street" value="{{old('client_street')}}" class="form-control" autocomplete="off">
                                                        {!!$errors->first('client_street', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                    </div>
                                                    <div class="col-xl-2 col-sm-4">
                                                        <label>Número</label>
                                                    <input type="text" name="client_number" value="{{old('client_number')}}" class="form-control" autocomplete="off">
                                                    {!!$errors->first('client_number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                    </div>
                                                    <div class="col-xl-2 col-sm-4 col-6">
                                                        <label>Piso</label>
                                                        <input type="text" name="client_floor" value="{{old('client_floor')}}" class="form-control" placeholder="Opcional" autocomplete="off">
                                                        {!!$errors->first('client_floor', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                    </div>
                                                    <div class="col-xl-2 col-sm-4 col-6">
                                                        <label>Depto</label>
                                                        <input type="text" name="client_department" value="{{old('client_department')}}" class="form-control" placeholder="Opcional" autocomplete="off">
                                                        {!!$errors->first('client_department', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                                                    </div>
                                                </div>
                                                <div class="d-inline mt-2">
                                                    <a onclick="newAddress();" class="btn btn-secondary btn-sm text-white mr-2">Cancelar</a>
                                                </div>
                                                <div class="d-inline mb-0">
                                                    <label class="mt-2">
                                                    <span><input type="checkbox" name="save"> Guardar dirección para una próxima vez</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- @endif --}}
                                </div>
                                <div class="form-group col-12 mb-3">
                                    <label><strong>Notas adicionales</strong><small> (Opcional)</small></label>
                                    <textarea class="form-control" rows="3" name="client_aditional_notes" value="{{old('client_aditional_notes')}}" placeholder="Ejemplo: '¡La pizza sin aceitunas, por favor!'">{{old('client_aditional_notes')}}</textarea>
                                </div>

                                <div class="form-group col-12 mb-3">
                                    <div class="alert alert-warning py-2" role="alert" style="font-size: .8em">
                                        <strong>¡Importante!</strong>
                                        {{-- <p class="mb-0">Esta acción no confirma el pedido, sino que envía el detalle del pedido y tus datos personales al comercio para coordinar el pedido y la entrega a través de WhatsApp o teléfono.</p> --}}
                                        <p class="mb-0">Al finalizar el pedido debes esperar a que el comercio lo confirme. Luego de eso, te llegará un WhatsApp con todos los detalles del pedido y la entrega.</p>
                                    </div>
                                    <button class="spinnerSubmitButton btn btn-primary btn-block" id="checkout-finish-order" type="submit" @if(Cart::isEmpty()) disabled @endif>
                                        <i class="loadingIcon fas fa-spinner fa-spin d-none"></i>
                                        <span class="btn-txt">Finalizar pedido</span>
                                    </button>
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
        var errors = '{{$errors}}';
        var AuthUser = "{{{ (Auth::user()) ? true : false }}}";
        if(AuthUser==1 || errors.length>2){
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

        $('#has_account').on('click', function(){
            $('#step-2').fadeOut(500);
            $('#step-1').fadeIn(500);
        })

        if($('#checkout-delivery-info').hasClass('checkout-pickup')){
            $('#checkout-delivery-info').hide();
        }else{
            $('#checkout-delivery-info').show();
        }

        $('#new-address').hide();

        if($('#checkboxDelivery').prop('checked')){
            $('#guest_address').fadeIn(200);
        }else if($('#checkboxPickup').prop('checked')){
            $('#guest_address').hide();
        }
    });

    $('#btn-submit-form').click(function(){
        var email = $('#inputEmail').val();
        var password = $('#inputPassword').val();
        $.ajax({
                url: '{{route("user.checkoutlogin")}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {email:email, password:password},
                success: function(data) {
                    $('#data').html('<div class="alert alert-success px-4 py-1"><small>'+data+'</small></div>');
                    location.reload();
                },
                error: function(data) {
                    let error = data.responseJSON.errors;
                    $('#data').html('<div class="alert alert-danger px-4 py-1"><small>'+error+'</small></div>');
                    $('.loadingIcon').addClass('d-none');
                    $('.spinnerClickButton').attr('disabled', false);
                    $('.btn-txt').text("Iniciar sesión");
                }
            });

    });

    function newAddress(){
        address = $("#address");
        newaddress = $("#new-address");
        addresstype = $("#address_type");

        if($('#new-address').is(':visible')){
            newaddress.hide();
            address.show();    
            addresstype.val('data-address');            
        }else{
            newaddress.show();
            address.hide();
            addresstype.val('new-address');
        }
    }
</script>
@endsection