@extends('layouts.commerce')

@section('main')
<form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
@csrf
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-3">
  <h4 style="font-weight: 900">Agregar producto</h4>
  <div class="btn-toolbar mb-2 mb-md-0 mr-3 d-none d-sm-block">
    <a href="{{route('product.index')}}" class="btn btn-secondary mx-2">Cancelar</a>
    @if(count($categories)!=0)
    <button type="submit" class="btn btn-primary">Guardar</button>
    @endif
  </div>
</div>
<div class="container container-fluid">
@if(count($categories)==0)
  <p>Primero debes crear una categoría antes que un producto. <br>
    <a class="btn btn-sm btn-secondary my-2" href="{{route('category.create')}}">Crear categorías</a></p>
@else
  <div class="row">
      <div class="col-xl-6 col-12 my-2">
        <div class="card">
          <h5 class="card-header">Detalles del producto</h5>
          <div class="card-body">
            <div class="form-group">
              <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}">
                {!!$errors->first('name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Detalles</label>
              <textarea class="form-control" name="details" id="exampleFormControlTextarea1" rows="3" value={{old('name')}}>{{old('name')}}</textarea>
              <small class="form-text text-muted">Este campo es opcional</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-6 col-12 my-2">
        <div class="card">
          <h5 class="card-header">Categoría</h5>
          <div class="card-body">
            @foreach($categories as $category)
            <div class="row">
              <div class="col-6">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="category_id" value="{{$category->id}}" value="{{old('category_id')}}">
                    {{$category->name}} 
                </label>
              </div>
            </div>
            </div>
            @endforeach
            {!!$errors->first('category_id', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
          </div>
        </div>
      </div>
    
      <div class="col-xl-6 col-12 my-2">
        <div class="card">
          <h5 class="card-header">Otros</h5>
          <div class="card-body">
            <label>Precio</label>
            <div class="input-group mb-3 col-xl-6 pl-0">
              <div class="input-group-prepend">
                <span class="input-group-text">$</span>
              </div>
              <input type="number" name="price" class="form-control" value="{{old('price')}}">
              {!!$errors->first('price', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>
            <div class="form-group">
              <label>Estado</label>
              <select class="form-control" name="state" value={{old('state')}}>
                <option value="available" selected>Disponible</option>
                <option value="not-available">No disponible</option>
              </select>
            </div>
            <label>Imágen</label>
              <div class="form-group">
                <div id="image_container" hidden><img id="view_image" src="{{asset('images/uploads/products/no_image.png')}}" class="img-thumbnail" width="150px"></div>
                <div id="delete_image" hidden><a href="#" onclick="removeImage();">Eliminar</a></div>
              </div>
              <div class="input-group mb-3">
                <div class="custom-file">
                  <input type="file" name="image" class="custom-file-input" onchange="readURL(this);" value="{{old('file')}}">
                  <label class="custom-file-label" id="upload_image" for="inputGroupFile01">Seleccionar archivo</label>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
{{-- btn-mobile --}}
<div class="d-block d-sm-none">
<div class="row my-3">
    <div class="col-xl-12">
      <a href="{{route('product.index')}}" class="btn btn-secondary btn-block">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-block">Guardar</button>
    </div>
  </div>
</div>
{{-- btn-mobile --}}
@endif

</form>
@endsection

@section('js-scripts')
<script>
  function readURL(input) {
      document.getElementById('image_container').removeAttribute('hidden')
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
  }
</script>
@endsection


