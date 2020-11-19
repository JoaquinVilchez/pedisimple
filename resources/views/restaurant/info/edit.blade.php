@extends('layouts.commerce')

@section('main')
<form action="{{route('restaurant.update', $restaurant->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="h2"><strong>Información general</strong></h1>
        <div class="btn-toolbar mb-2 mb-md-0 ml-5">
        <a href="{{route('restaurant.info')}}" class="btn btn-secondary mx-2">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>

<div class="row mt-2">
    <div class="col-12 col-xl-6">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="name" value="{{old('name', $restaurant->name)}}">
                        {!!$errors->first('name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                </div>

                <div class="col-12">
                    <label for="slug">Slug <small><i class="fas fa-question-circle" data-toggle="tooltip" data-placement="right" title="Es el texto identificativo de tu comercio que aparece después del nombre de dominio de la página"></i></small></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">{{env('APP_URL')}}/</span>
                        </div>
                        <input type="text" class="form-control" id="slug" aria-describedby="basic-addon3" name="slug" value="{{old('slug', $restaurant->slug)}}">
                    </div>
                    {!!$errors->first('slug', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
            </div>

            <hr class="my-4">
            <div class="form-group">
                <div class="row">
                    <div class="col-8 col-md-6">
                        <label>Dirección</label>
                        <input type="text" class="form-control" name="street" value="{{old('street', $address->street)}}">
                        {!!$errors->first('street', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                    <div class="col-4 col-md-2">
                        <label>Número</label>
                        <input type="text" class="form-control" name="number" value="{{old('number', $address->number)}}">
                        {!!$errors->first('number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                    <div class="col-12 col-md-4">
                        <label>Ciudad</label>
                        <select class="form-control" name="city_id">
                            @foreach($cities as $city)
                            <option @if($address->city_id === $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <hr class="my-2">
            <div class="form-row">
                <div class="form-group col-12 col-lg-6">
                        <label>Teléfono</label>
                        <div class="form-row">
                            <div class="col-4">
                            <input type="text" name="characteristic" value="{{old('characteristic', $restaurant->characteristic)}}" class="form-control" maxlength="4" onkeypress="return onlyNumberKey(event)">
                            <small class="form-text text-muted">Ej: 3462</small>
                            </div>
                            <div class="col-8">
                            <input type="text" name="phone" value="{{old('phone', $restaurant->phone)}}" class="form-control" maxlength="6" onkeypress="return onlyNumberKey(event)">
                            <small class="form-text text-muted">Ej: 654321</small>
                            </div>
                        </div>
                        {!!$errors->first('characteristic', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        <br>
                        {!!$errors->first('phone', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label>Segundo teléfono</label>
                    <div class="form-row">
                        <div class="col-4">
                        <input type="text" name="second_characteristic" value="{{old('second_characteristic', $restaurant->second_characteristic)}}" class="form-control" maxlength="4" onkeypress="return onlyNumberKey(event)">
                        <small class="form-text text-muted">Ej: 3462</small>
                        </div>
                        <div class="col-8">
                        <input type="text" name="second_phone" value="{{old('second_phone', $restaurant->second_phone)}}" class="form-control" maxlength="6" onkeypress="return onlyNumberKey(event)">
                        <small class="form-text text-muted">Ej: 654321</small>
                        </div>
                    </div>
                    {!!$errors->first('second_characteristic', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    <br>
                    {!!$errors->first('second_phone', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
            </div>
            <hr class="my-2">
            <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" rows="3" name="description" value="{{old('description', $restaurant->description)}}">{{old('description', $restaurant->description)}}</textarea>
            </div>
            {{-- OK --}}
            <hr class="my-2">
            <div class="form-group col-12 col-md-6 pl-0">
                <label>Retiro o delivery</label>
                <select class="form-control" name="shipping_method" id="shipping_method" onchange="showDeliveryInputs()">
                    <option value="delivery" @if($restaurant->shipping_method === 'delivery') selected @endif>Delivery</option>
                    <option value="pickup" @if($restaurant->shipping_method === 'pickup') selected @endif>Retiro en local</option>
                    <option value="delivery-pickup" @if($restaurant->shipping_method === 'delivery-pickup') selected @endif>Delivery y Retiro en local</option>
                </select>
            </div>

            <div class="row mt-2 ml-1" id="delivery_options">
                <div class="form-group pl-0">
                    <label>Costo de envío</label>
                    <div class="input-group mb-0 col-12 pl-0">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">$</span>
                        </div>
                        <input min="0" type="number" class="form-control" name="shipping_price" value="{{old('shipping_price', formatPrice($restaurant->shipping_price))}}">
                        {!!$errors->first('shipping_price', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                    <small class="form-text text-muted ml-3">En caso que sea sin costo, ingresar $0</small>
                </div>

                <div class="form-group">
                    <label>Tiempo aproximado de envío</label>
                    <div class="input-group mb-3 col-12">
                    <input min="0" step="5" type="number" class="form-control" name="shipping_time" value="{{old('shipping_time', formatPrice($restaurant->shipping_time))}}">
                        <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">min.</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-2">

            <div class="form-group">
                <label>Foto</label>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <div id="image_container"><img id="view_image" data-original="{{asset('storage/uploads/commerce/'.$restaurant->image)}}" class="img-thumbnail" width="150px"></div>
                            <div id="delete_image"><a href="#image_container" onclick="removeImage();">Eliminar</a></div>
                            <input type="hidden" name="delete_image" value="no" id="delete-image">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center">
                        <div class="form-group">
                            <label id="upload_image" for="exampleFormControlFile1">Buscar imágen</label>
                            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" onchange="readURL(this);">
                            <input type="hidden" id="img_action" name="action" value="">
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="form-group">
            <label>Comidas</label>
            <div class="form-group">
            {!!$errors->first('food_categories', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            @foreach($foodCategories as $category)
                <div class="chiller_cb">
                    <label>
                    <input type="checkbox" name="food_categories[]" value="{{$category->id}}" id="{{$category->id}}" 
                    @foreach($restaurantFoodCategories as $restaurantFoodCategory)
                    @if($restaurantFoodCategory->id===$category->id) checked @endif
                    @endforeach
                    >
                    {{$category->name}}</label>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
{{-- btn-mobile --}}
<div class="d-block d-sm-none">
    <div class="row my-3">
        <div class="col-xl-12">
        <a href="{{route('restaurant.info')}}" class="btn btn-secondary btn-block">Cancelar</a>
        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
        </div>
    </div>
</div>
{{-- btn-mobile --}}
</form>
<hr>

<div class="alert alert-secondary mb-2" style="font-size: .8em; text-align:center" role="alert">
<i class="fas fa-question-circle"></i> ¿Tenés dudas? <a target="_autoblank" href="{{route('help.documentation')}}#docs-datos-comercio" class="txt-semi-bold">Consultar documentación</a>.
</div>
@endsection

@section('js-scripts')
    <script>

        function readURL(input) {
            document.getElementById('image_container').removeAttribute('hidden');
            document.getElementById("img_action").value = "";
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
            document.getElementById('delete_image').setAttribute('hidden', '');
            document.getElementById("upload_image").value = "";
            document.getElementById("img_action").value = "delete";
            document.getElementById("view_image").src = "{{ asset('storage/uploads/commerce/commerce.png') }}";
            $('#delete-image').val('yes');

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
    </script>
@endsection

