@extends('layouts.admin')

@section('main')
<form action="{{route('invitation.store')}}" method="post"">
@csrf
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-3">
  <h4 style="font-weight: 900">Crear invitación</h4>
  <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <a href="{{route('invitation.index')}}" class="btn btn-secondary mx-2">Cancelar</a>
    <button type="submit" class="btn btn-primary">Crear</button>
  </div>
</div>
<div class="container container-fluid">
<div class="row">
<div class="col-xl-6 col-xs-12 my-2">
      <div class="card">
        <h5 class="card-header">Detalles de la invitación</h5>
        <div class="card-body">
          <div class="form-group">
            <label>Nombre</label>
          <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}">
              {!!$errors->first('first_name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
          </div>
          <div class="form-group">
            <label>Apellido</label>
          <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}">
              {!!$errors->first('last_name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
          </div>
          <div class="form-group">
            <label>Email</label>
          <input type="email" name="email" class="form-control" value="{{old('email')}}">
              {!!$errors->first('email', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
          </div>
        </div>
      </div>
</div>
</div>
</div>
</form>
@endsection



