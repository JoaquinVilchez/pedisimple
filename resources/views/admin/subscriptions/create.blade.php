@extends('layouts.admin')

@section('main')
    <div class="container m-1 mt-4">
        <div class="row">
            <form action="{{route('subscription.store')}}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-grou col-sm-6">
                        <label>Nombre</label>
                        <input name="name" type="text" class="form-control" placeholder="Nombre del plan" value="{{old('name')}}">
                        {!!$errors->first('name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>

                    <div class="form-grou col-sm-6">
                        <label>Frecuencia de cobro</label>
                        <select name="frequency" class="form-control">
                            <option value="1" @if(old('frequency')==1) selected @endif>Mensual</option>
                            <option value="3" @if(old('frequency')==3) selected @endif>Trimestral</option>
                            <option value="6" @if(old('frequency')==6) selected @endif>Semestral</option>
                            <option value="12" @if(old('frequency')==12) selected @endif>Anual</option>
                        </select>
                    </div>
                    {!!$errors->first('frequency', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                </div>
                <div class="form-row mt-3">

                    <div class="form-group col-sm-4">
                        <label>Precio</label>
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">$</div>
                        </div>
                        <input name="price" type="text" class="form-control" placeholder="Precio del plan" value="{{old('price')}}">
                        </div>
                        {!!$errors->first('price', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>

                    <div class="form-group col-sm-4">
                        <label>Prueba gratis</label>
                        <div class="input-group">
                            <input name="freedays" type="number" class="form-control" placeholder="Días gratis" value="{{old('freedays')}}">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">días</span>
                            </div>
                        </div>
                        {!!$errors->first('freedays', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Días de gracia</label>
                        <div class="input-group">
                            <input name="gracedays" type="number" class="form-control" placeholder="Días de gracia" value="{{old('gracedays')}}">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">días</span>
                            </div>
                        </div>
                        {!!$errors->first('gracedays', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                </div>
                <a href="{{route('subscription.index')}}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
              </form>
        </div>
    </div>
@endsection