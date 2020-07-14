@extends('layouts.commerce')

@section('main')
<form action="{{route('variant.update', $variant->id)}}" method="post" enctype="multipart/form-data">
@method('put')
@csrf
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-3">
  <h4 style="font-weight: 900">Agregar variación</h4>
  <div class="btn-toolbar mb-2 mb-md-0 mr-3 d-none d-sm-block">
    <a href="{{route('variant.index')}}" class="btn btn-secondary mx-2">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </div>
</div>
<div class="container container-fluid">
  <div class="row">
      <div class="col-xl-6 col-12 my-2 pl-0">
        <div class="card">
          <h5 class="card-header">Detalles del producto</h5>
          <div class="card-body">
            <div class="form-group">
              <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{old('name', $variant->name)}}">
                {!!$errors->first('name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Detalles</label>
              <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" value={{old('description', $variant->description)}}>{{old('description', $variant->description)}}</textarea>
              <small class="form-text text-muted">Este campo es opcional</small>
            </div>
            <div class="form-group">
              <label>Estado</label>
              <select class="form-control" name="state" value={{old('state')}}>
                <option value="available" @if($variant->state=='available') selected @endif>Disponible</option>
                <option value="not-available" @if($variant->state=='not-available') selected @endif>No disponible</option>
              </select>
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

</form>
@endsection


