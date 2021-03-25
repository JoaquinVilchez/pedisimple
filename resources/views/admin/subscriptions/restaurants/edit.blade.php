@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Editar suscripción</strong></h1>
</div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('subscription.update', $restaurant->id)}}" method="POST">
                        @method('PUT')
                        @csrf
                        <p>Comercio: {{$restaurant->name}}</p>
                        <p>Estado:
                            @if($restaurant->user->subscriptionIsActive()=='trial')
                                <span class="badge badge-primary">Prueba</span>
                            @else
                                @if($restaurant->user->subscriptionIsActive()=='active')
                                    <span class="badge badge-success">Activo</span>
                                @elseif($restaurant->user->subscriptionIsActive()=='canceled')
                                    <span class="badge badge-danger">Cancelado</span>
                                @elseif($restaurant->user->subscriptionIsActive()=='ended')
                                    <span class="badge badge-warning">Inactivo</span>
                                @endif
                            @endif

                            <div class="form-row">
                                <div class="col">
                                      <input type="text" class="form-control datepicker" name="trial_ends_at" value="{{old('trial_ends_at', date('d/m/Y', strtotime($subscription->trial_ends_at)))}}" autocomplete="off" @if($restaurant->user->subscriptionIsActive()!='trial') readonly @endif>
                                      <small>Fecha de fin de la prueba</small>
                                </div>
                            </div>

                            @if($restaurant->user->checkUnpaidSubscriptions()==1)
                                <span class="badge badge-danger">{{$restaurant->user->checkUnpaidSubscriptions()}} Mes impago</span>
                            @elseif($restaurant->user->checkUnpaidSubscriptions()==2)
                                <span class="badge badge-danger">{{$restaurant->user->checkUnpaidSubscriptions()}} Meses impagos</span>
                            @endif
                        </p>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Estado de suscripción</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                              <option>Activo</option>
                              <option>Cancelado</option>
                            </select>
                        </div>

                        <div class="form-row">
                          <div class="col">

                                <input type="text" class="form-control datepicker" name="subscription_starts_at" value="{{old('subscription_starts_at', date('d/m/Y', strtotime($subscription->starts_at)))}}" autocomplete="off">
                                <small>Fecha de inicio de la suscripción</small>
                          </div>
                          <div class="col">
                                <input type="text" class="form-control datepicker" name="subscription_ends_at" value="{{old('subscription_ends_at', date('d/m/Y', strtotime($subscription->ends_at)))}}" autocomplete="off">
                                <small>Fecha de fin de la suscripción</small>
                          </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary btn-block mt-4">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection