@extends('layouts.commerce')

@section('main')
<form action="{{route('category.update', $category)}}" method="post">
  @csrf
  @method('PUT')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-3">
    <h4 style="font-weight: 900">Editar categoría</h4>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3 d-none d-sm-block">
      <a href="{{route('category.index')}}" class="btn btn-secondary mx-2">Cancelar</a>
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
  </div>
  <div class="container container-fluid">
    <div class="row">
        <div class="col-xl-6 col-12 my-2">
          <div class="card">
            <h5 class="card-header">Detalles de la categoría</h5>
            <div class="card-body">
              <div class="form-group">
                <label>Nombre</label>
              <input type="text" class="form-control" name="name" value="{{old('name', $category->name)}}">
              {!!$errors->first('name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
              </div>
              <div class="form-group">
                <label>Descripción</label>
              <textarea class="form-control" rows="3" name="description" value="{{old('description', $category->description)}}">{{$category->description}}</textarea>
                <small class="form-text text-muted">Este campo es opcional</small>
              </div>
              <div class="form-group">
                <label>Estado</label>
                <select class="form-control" name="state">
                  <option value="available" @if($category->state == 'available') selected @endif>Disponible</option>
                  <option value="not-available" @if($category->state == 'not-available') selected @endif>No disponible</option>
                </select>
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
        <a href="{{route('category.index')}}" class="btn btn-secondary btn-block">Cancelar</a>
        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
      </div>
    </div>
  </div>
{{-- btn-mobile --}}
</form>
<hr>

<div class="alert alert-secondary mb-2" style="font-size: .8em; text-align:center" role="alert">
<i class="fas fa-question-circle"></i> ¿Tenés dudas? <a target="_autoblank" href="{{route('help.documentation')}}#docs-categorias" class="txt-semi-bold">Consultar documentación</a>.
</div>
@endsection

