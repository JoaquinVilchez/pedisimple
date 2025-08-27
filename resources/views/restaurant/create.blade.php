@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('restaurant.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div style="text-align:center" class="m-auto">
            <i class="fas fa-store fa-4x text-primary my-3"></i>
            <h5 class="txt-bold">Registrar tu comercio</h5>
            <p>Completa los datos de tu comercio por única vez.</p>
        </div>

    <div class="row mt-2 justify-content-center">
        <div class="col-lg-8 col-12 mt-2">
                <div class="mb-4" style="text-align:center">
                    <small style="color:rgb(241, 0, 0)">Los campos que tienen * son obligatorios</small>
                </div>
                <div class="form-group">
                <label>Nombre del comercio <small style="color:rgb(241, 0, 0)">*</small></label>
                    <input type="text" class="form-control" name="name" value="{{old('name')}}" autocomplete="flase">
                    {!!$errors->first('name', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
                <hr class="my-2">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-8">
                            <label>Dirección <small style="color:rgb(241, 0, 0)">*</small></label>
                            <input type="text" class="form-control" name="street" value="{{old('street')}}" autocomplete="flase">

                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4">
                            <label>Número<small style="color:rgb(241, 0, 0)">*</small></label>
                            <input type="number" min="0" class="form-control" name="number" value="{{old('number')}}" autocomplete="flase">
                            {{-- {!!$errors->first('number', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!} --}}
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <label>Ciudad <small style="color:rgb(241, 0, 0)">*</small></label>
                            <select class="form-control" name="city_id">
                                @foreach ($cities as $city)
                                <option value="{{$city->id}}" {{old('city_id') == $city->id ? 'selected' : ''}}>{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {!!$errors->first('street', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
                <hr class="my-2">
                <div class="form-row">
                    <div class="col-xl-6 col-12">
                            <label>Teléfono <small style="color:rgb(241, 0, 0)">*</small></label>
                            <div class="form-row">
                                <div class="col-4">
                                <input type="text" name="characteristic" value="{{old('characteristic')}}" class="form-control" maxlength="4" onkeypress="return onlyNumberKey(event)" autocomplete="flase">
                                <small class="form-text text-muted">Ej: 3462</small>
                                </div>
                                <div class="col-8">
                                <input type="text" name="phone" value="{{old('phone')}}" class="form-control" maxlength="6" onkeypress="return onlyNumberKey(event)" autocomplete="flase">
                                <small class="form-text text-muted">Ej: 654321</small>
                                </div>
                            </div>
                            {!!$errors->first('characteristic', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                            <br>
                            {!!$errors->first('phone', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                    <div class="col-xl-6 col-12">
                        <label>Segundo teléfono <small>(opcional)</small></label>
                        <div class="form-row">
                            <div class="col-4">
                            <input type="text" name="second_characteristic" value="{{old('second_characteristic')}}" class="form-control" maxlength="4" onkeypress="return onlyNumberKey(event)" autocomplete="flase">
                            <small class="form-text text-muted">Ej: 3462</small>
                            </div>
                            <div class="col-8">
                            <input type="text" name="second_phone" value="{{old('second_phone')}}" class="form-control" maxlength="6" onkeypress="return onlyNumberKey(event)" autocomplete="flase">
                            <small class="form-text text-muted">Ej: 654321</small>
                            </div>
                        </div>
                        {!!$errors->first('second_characteristic', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        <br>
                        {!!$errors->first('second_phone', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                </div>
                <hr class="mb-2">
                <div class="form-group">
                    <label>Descripción <small>(opcional)</small></label>
                    <textarea class="form-control" rows="3" name="description" value="{{old('description')}}" autocomplete="flase">{{old('description')}}</textarea>
                </div>
                <hr class="my-2">
                <div class="form-group">
                    <label>Retiro o delivery <small style="color:rgb(241, 0, 0)">*</small></label>
                    <select class="form-control" name="shipping_method" id="shipping_method" onchange="showDeliveryInputs()" autocomplete="flase">
                        <option value="delivery-pickup" {{old('shipping_method') == 'delivery-pickup' ? 'selected' : ''}}>Delivery y Retiro en local</option>
                        <option value="delivery" {{old('shipping_method') == 'delivery' ? 'selected' : ''}}>Delivery</option>
                        <option value="pickup" {{old('shipping_method') == 'pickup' ? 'selected' : ''}}>Retiro en local</option>
                    </select>
                </div>
                <div id="delivery_options">
                    <div class="form-group">
                        <div class="row">

                            <div class="col-12 col-md-6">
                                <label>Costo de envío <small style="color:rgb(241, 0, 0)">*</small></label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    </div>
                                    <input min="0" type="number" class="form-control" name="shipping_price" value="{{old('shipping_price')}}" autocomplete="flase">
                                </div>
                                <small class="form-text text-muted">En caso que sea sin costo, colocar $0</small>
                            </div>

                            <div class="col-12 col-md-6">
                                <label>Tiempo aproximado de envío</label>
                                <div class="input-group mb-3">
                                    <input min="0" type="number" class="form-control" name="shipping_time" value="{{old('shipping_time')}}" autocomplete="flase">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2" >min.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!!$errors->first('shipping_price', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                </div>

                <hr class="my-2">

                <div class="col-12 col-md-8">
                    <div class="row mt-2">
                        <div class="form-group" id="foto">
                                <label>Foto</label><br>
                                <div id="image_container" hidden>
                                    <img id="view_image" data-original="" class="img-thumbnail" width="150px">
                                    <div id="delete_image"><a href="#foto" onclick="removeImage();">Eliminar</a></div>
                                </div>

                                <label for="exampleFormControlFile1">Buscar imágen</label>
                                <input type="file" id="upload_image"  onchange="readURL(this);" name="image" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                            <small>En caso de no seleccionar una foto, se le asignará una por defecto.</small>
                    </div>
                </div>

                <hr class="my-2">

                <div class="form-group">
                    <label>Categorías <small style="color:rgb(241, 0, 0)">*</small></label>
                    <br>
                    <small>Selecciona las categorías que trabajas en tu comercio.</small>
                    <div class="form-group pt-2">
                    @foreach($categories as $category)
                        <div class="chiller_cb d-inline">
                            <label>
                                <span class="btn btn-checkbox">
                                    <input type="checkbox" name="food_categories[]" value="{{$category->id}}" id="{{$category->id}}" {{ (is_array(old('food_categories')) and in_array($category->id, old('food_categories'))) ? ' checked' : '' }}>
                                    {{$category->name}}
                                </span>
                            </label>

                        </div>
                    @endforeach
                    <br>{!!$errors->first('food_categories', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
            </div>

            <hr>
            <div class="my-2">
                <label>
                    <input type="checkbox" name="termsandconditions">
                        <small>Al guardar los cambios, usted acepta los <a class="docs-link" target="_autoblank" href="{{route('help.termsandconditions')}}">Términos y condiciones</a> de nuestra plataforma.</small>
                </label>
                <br>
                {!!$errors->first('termsandconditions', '<small style="color:rgb(241, 0, 0)"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>

            <div class="form-group">
                <button class="spinnerSubmitButton btn btn-primary btn-block" id="btn_submit" type="submit">
                    <i class="loadingIcon fas fa-spinner fa-spin d-none"></i>
                    <span class="btn-txt">Guardar datos</span>
                </button>
            </div>
        </div>
        </form>
</div>
@endsection


@section('js-scripts')
<script>
    function onlyNumberKey(evt) {
        // Only ASCII charactar in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

    showDeliveryInputs();

    function showDeliveryInputs(){
        var shipping_method = document.getElementById('shipping_method').value;
        var delivery_inputs = document.getElementById('delivery_options');
        if(shipping_method=='pickup'){
            delivery_inputs.setAttribute('hidden', '');
        }else{
            delivery_inputs.removeAttribute('hidden');
        }
    }

    function readURL(input) {
        document.getElementById('image_container').removeAttribute('hidden');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#view_image')
                    .attr('src', e.target.result)

                document.getElementById('delete_image').removeAttribute('hidden')
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage(){
        document.getElementById('image_container').setAttribute('hidden', '');
        document.getElementById('delete_image').setAttribute('hidden', '');
        document.getElementById("upload_image").value = "";
        document.getElementById("img_action").value = "delete";
    }

    function show(){
        document.getElementById('alert_info').removeAttribute('hidden')
    }
</script>
@endsection