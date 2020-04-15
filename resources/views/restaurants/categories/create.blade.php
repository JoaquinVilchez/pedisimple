@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-3">
  <h4 style="font-weight: 900">Agregar categoria</h4>
  <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <button type="submit" class="btn btn-outline-success mx-2"><i class="far fa-file-excel"></i> Importar Excel</button>
    <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>
<div class="container container-fluid">
<div class="row">
  <div class="col-xl-6 col-12 my-2">
      <div class="card">
        <h5 class="card-header">Detalles de la categoria</h5>
        <div class="card-body">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Descripcion</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            <small class="form-text text-muted">Este campo es opcional</small>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
@endsection

