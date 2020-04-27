@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('restaurant.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="align-items-center pt-3 pb-2 border-bottom" style="text-align:center">
            <img src="{{asset('images/design/shop.svg')}}" class="img-default my-3">
            <h4 class="txt-bold">Configura tu comercio</h4>
            <p>Completa los datos de tu comercio por única vez.</p>
        </div>

    <div class="row mt-2 justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12 mt-2">
                <div class="mb-4" style="text-align:center">
                    <small style="color:red">Los campos que tienen * son obligatorios</small>
                </div>
                <div class="form-group">
                <label>Nombre del comercio <small style="color:red">*</small></label>
                    <input type="text" class="form-control" name="name" value="{{old('name')}}" autocomplete="flase">
                    {!!$errors->first('name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
                <hr class="my-2">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-8">
                            <label>Dirección <small style="color:red">*</small></label>
                            <input type="text" class="form-control" name="street" value="{{old('street')}}" autocomplete="flase">
                            
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-4">
                            <label>Número<small style="color:red">*</small></label>
                            <input type="text" class="form-control" name="number" value="{{old('number')}}" autocomplete="flase">
                            {{-- {!!$errors->first('number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!} --}}
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <label>Ciudad <small style="color:red">*</small></label>
                            <select class="form-control" name="city_id">
                                @foreach ($cities as $city)
                                <option value="{{$city->id}}" {{old('city_id') == $city->id ? 'selected' : ''}}>{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {!!$errors->first('street', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
                <hr class="my-2">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-8">
                            <label>Teléfono <small style="color:red">*</small></label>
                            <input type="text" class="form-control" name="phone" value="{{old('phone')}}" autocomplete="flase">
                        </div>
                    </div>
                </div>
                {!!$errors->first('phone', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                <hr class="my-2">
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea class="form-control" rows="3" name="description" value="{{old('description')}}" autocomplete="flase">{{old('description')}}</textarea>
                </div>
                <hr class="my-2">
                <div class="form-group pl-0">
                    <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12 col-12">
                        <label>Retiro o delivery <small style="color:red">*</small></label>
                        <select class="form-control" name="shipping_method" id="shipping_method" onchange="showDeliveryInputs()" autocomplete="flase">                    
                            <option value="delivery-pickup" {{old('shipping_method') == 'delivery-pickup' ? 'selected' : ''}}>Delivery y Retiro en local</option>
                            <option value="delivery" {{old('shipping_method') == 'delivery' ? 'selected' : ''}}>Delivery</option>
                            <option value="pickup" {{old('shipping_method') == 'pickup' ? 'selected' : ''}}>Retiro en local</option>
                        </select>
                    </div>
                    <div id="delivery_options">
                        <div class="row mt-2 ml-1">
                            <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-8">
                                <label>Costo de envío <small style="color:red">*</small></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">$</span>
                                    </div>
                                    <input min="0" type="number" class="form-control" name="shipping_price" value="{{old('shipping_price')}}" autocomplete="flase">
                                </div>
                            </div>
                            {!!$errors->first('shipping_price', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        </div>
                        <div class="row mt-2 ml-1">
                            <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-8">
                                <label>Tiempo aproximado de envío</label>
                                <div class="input-group mb-3">
                                <input min="0" type="number" class="form-control" name="shipping_time" value="{{old('shipping_time')}}" autocomplete="flase">
                                    <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2" >min.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-2">
                <div class="form-group" id="foto">  
                        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-8">
                            <label>Foto</label>
                            <div class="row mt-2 ml-1">
                                    <div id="image_container" hidden>
                                        <img id="view_image" src="" class="img-thumbnail" width="150px">
                                        <div id="delete_image"><a href="#foto" onclick="removeImage();">Eliminar</a></div>
                                    </div>
                                    {{-- <img src="" class="img-thumbnail" width="150px"> --}}
                            </div>
                            <div class="row mt-2 ml-1">
                                <label for="exampleFormControlFile1">Buscar imágen</label>
                                <input type="file" id="upload_image"  onchange="readURL(this);" name="image" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                        </div>
                        <div class="row mt-2 ml-1">
                            <small>En caso de no seleccionar una foto, se le asignará una por defecto.</small>
                        </div>
                </div>
            <div class="form-group">
                <label>Comidas <small style="color:red">*</small></label>
                <div class="form-group p-2">
                @foreach($categories as $category)
                    <div class="chiller_cb d-inline mx-2">
                        <label>
                            <span class="btn btn-checkbox">
                            <input type="checkbox" name="food_categories[]" value="{{$category->id}}" id="{{$category->id}}" {{ (is_array(old('food_categories')) and in_array($category->id, old('food_categories'))) ? ' checked' : '' }}>
                            {{$category->name}}
                            </span>
                        </label>
                        
                    </div>
                @endforeach
                <br>{!!$errors->first('food_categories', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
            </div>
            
            <div id="alert_info" class="alert alert-danger" role="alert" hidden>
                Espere mientras guardamos sus datos...
            </div>

            <div class="form-group">
                <button  onclick="show()" type="submit" id="btn_submit" class="btn btn-primary btn-block">Guardar</button>
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

        function show(){
            document.getElementById('alert_info').removeAttribute('hidden')
        }
    </script>
@endsection