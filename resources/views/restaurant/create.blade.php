@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('restaurant.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="align-items-center pt-3 pb-2 border-bottom" style="text-align:center">
            <h3><i class="fas fa-cogs"></i></h3>
            <h1 class="h2"><strong>Configurar comercio</strong></h1>
        </div>

    <div class="row mt-2 justify-content-center">
        <div class="col-xl-6">
                <div class="form-group">
                <label>Nombre</label>
                    <input type="text" class="form-control" name="name" value="{{old('name')}}">
                    {!!$errors->first('name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
                <hr class="my-2">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label>Direccion</label>
                            <input type="text" class="form-control" name="street" value="{{old('street')}}">
                            {!!$errors->first('street', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        </div>
                        <div class="col-2">
                            <label>Numero</label>
                            <input type="text" class="form-control" name="number" value="{{old('number')}}">
                            {!!$errors->first('number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        </div>
                        <div class="col-4">
                            <label>Ciudad</label>
                            <select class="form-control" name="city_id">
                                @foreach ($cities as $city)
                                <option value="{{$city->id}}" {{old('city_id') == $city->id ? 'selected' : ''}}>{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr class="my-2">
                <div class="form-group col-4 pl-0">
                    <label>Telefono</label>
                    <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                    {!!$errors->first('phone', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
                <hr class="my-2">
                <div class="form-group">
                    <label>Descripcion</label>
                    <small>(Opcional)</small>
                    <textarea class="form-control" rows="3" name="description" value="{{old('description')}}">{{old('description')}}</textarea>
                </div>
                <hr class="my-2">
                <div class="form-group col-6 pl-0">
                    <label>Retiro o delivery</label>
                    <select class="form-control" name="shipping_method" id="shipping_method" onchange="showDeliveryInputs()">                    
                        <option value="delivery-pickup" {{old('shipping_method') == 'delivery-pickup' ? 'selected' : ''}}>Delivery y Retiro en local</option>
                        <option value="delivery" {{old('shipping_method') == 'delivery' ? 'selected' : ''}}>Delivery</option>
                        <option value="pickup" {{old('shipping_method') == 'pickup' ? 'selected' : ''}}>Retiro en local</option>
                    </select>

                    <div class="row mt-2 ml-1" id="delivery_options">
                        <label>Costo de envio</label>
                        <div class="input-group mb-3 col-8">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">$</span>
                            </div>
                            <input type="number" class="form-control" name="shipping_price" value="{{old('shipping_price')}}">
                            {!!$errors->first('shipping_price', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        </div>

                        <label>Tiempo de envio</label><small>  (Opcional)</small>
                        <div class="input-group mb-3 col-8">
                        <input type="number" class="form-control" name="shipping_time" value="{{old('shipping_time')}}">
                            <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2" >min.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-2">
                <div class="form-group" id="foto">
                    <label>Foto</label><small> (Opcional)</small>
                    <div class="row">
                        <div class="col-xl-4">
                        <div class="form-group">
                            <div id="image_container" hidden>
                                <img id="view_image" src="" class="img-thumbnail" width="150px">
                                <div id="delete_image"><a href="#foto" onclick="removeImage();">Eliminar</a></div>
                            </div>
                            {{-- <img src="" class="img-thumbnail" width="150px"> --}}
                        </div>
                        </div>
                        <div class="col-xl-6 d-flex align-items-center">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Buscar imagen</label>
                                <input type="file" id="upload_image"  onchange="readURL(this);" name="image" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                        </div>
                    </div>
                    <small>En caso de no seleccionar una foto, se le asignara una por defecto.</small>
                </div>
            <div class="form-group">
                <label>Comidas</label>
                <div class="form-group p-2">
                @foreach($categories as $category)
                    <div class="chiller_cb d-inline mx-3">
                        <input type="checkbox" name="food_categories[]" value="{{$category->id}}" id="{{$category->id}}" {{ (is_array(old('food_categories')) and in_array($category->id, old('food_categories'))) ? ' checked' : '' }}>
                        <label>{{$category->name}}</label>
                        <span></span>
                    </div>
                @endforeach
                <br>{!!$errors->first('food_categories', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            </div>
        </div>
        </form>
</div>
@endsection


@section('js-scripts')
    <script>
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
    </script>
@endsection