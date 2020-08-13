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
    <div class="col-xl-6">
            <div class="form-group">
              <label>Nombre</label>
                <input type="text" class="form-control" name="name" value="{{old('name', $restaurant->name)}}">
                {!!$errors->first('name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>
            <hr class="my-2">
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label>Dirección</label>
                        <input type="text" class="form-control" name="street" value="{{old('street', $address->street)}}">
                        {!!$errors->first('street', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                    <div class="col-2">
                        <label>Número</label>
                        <input type="text" class="form-control" name="number" value="{{old('number', $address->number)}}">
                        {!!$errors->first('number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                    <div class="col-4">
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
            <hr class="my-2">
            <div class="form-group col-6 pl-0">
                <label>Retiro o delivery</label>
                <select class="form-control" name="shipping_method" id="shipping_method" onchange="showDeliveryInputs()">                    
                    <option value="delivery" @if($restaurant->shipping_method === 'delivery') selected @endif>Delivery</option>
                    <option value="pickup" @if($restaurant->shipping_method === 'pickup') selected @endif>Retiro en local</option>
                    <option value="delivery-pickup" @if($restaurant->shipping_method === 'delivery-pickup') selected @endif>Delivery y Retiro en local</option>
                </select>

                <div class="row mt-2 ml-1" id="delivery_options">
                    <label>Costo de envío</label>
                    <div class="input-group mb-3 col-8">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">$</span>
                        </div>
                        <input min="0" type="number" class="form-control" name="shipping_price" value="{{old('shipping_price', $restaurant->shipping_price)}}">
                        {!!$errors->first('shipping_price', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                      </div>

                    <label>Tiempo aproximado de envío</label>
                    <div class="input-group mb-3 col-8">
                    <input min="0" step="5" type="number" class="form-control" name="shipping_time" value="{{old('shipping_time', $restaurant->shipping_time)}}">
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
                    <div class="col-xl-4">
                        <div class="form-group">
                            <div id="image_container"><img id="view_image" data-original="{{asset('images/uploads/commerce/'.$restaurant->image)}}" class="img-thumbnail" width="150px"></div>
                            <div id="delete_image"><a href="#image_container" onclick="removeImage();">Eliminar</a></div>
                        </div>
                    </div>
                    <div class="col-xl-6 d-flex align-items-center">
                        <div class="form-group">
                            <label id="upload_image" for="exampleFormControlFile1">Buscar imágen</label>
                            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" onchange="readURL(this);">
                            <input type="hidden" id="img_action" name="action" value="">
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-xl-6">
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
    </form>
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
            document.getElementById("view_image").src = "{{ asset('images/uploads/commerce/commerce.png') }}";

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

