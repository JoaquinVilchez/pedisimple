@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Suscripciones</strong></h1>
    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addNewSubscription">Crear nueva suscripción</a>
</div>

  @include('messages')
@if($subscribed_restaurants->count()==0)
<p>Todavía no hay suscripciones.</p>
@else
  <div class="table-responsive">
    <table class="table table-sm table-hover">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Estado</th>
          <th>Prueba</th>
          <th>Comenzó el</th>
          <th>Termina el</th>
          <th>Días de gracia</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
          @foreach($subscribed_restaurants as $subscribed_restaurant)
          <tr>
            <td>{{$subscribed_restaurant->name}}
            <td>
              @if($subscribed_restaurant->user->subscriptionIsActive()=='trial')
                <span class="badge badge-primary">Prueba</span>
              @else
                  @if($subscribed_restaurant->user->subscriptionIsActive()=='active')
                    <span class="badge badge-success">Activo</span>
                  @elseif($subscribed_restaurant->user->subscriptionIsActive()=='canceled')
                    <span class="badge badge-danger">Cancelado</span>
                  @elseif($subscribed_restaurant->user->subscriptionIsActive()=='ended')
                    <span class="badge badge-warning">Inactivo</span>
                  @endif
              @endif

              @if($subscribed_restaurant->user->checkUnpaidSubscriptions()==1)
                <span class="badge badge-danger">{{$subscribed_restaurant->user->checkUnpaidSubscriptions()}} Mes impago</span>
              @elseif($subscribed_restaurant->user->checkUnpaidSubscriptions()==2)
                <span class="badge badge-danger">{{$subscribed_restaurant->user->checkUnpaidSubscriptions()}} Meses impagos</span>
              @endif
            </td>
            <td>
            @if($subscribed_restaurant->user->subscriptionIsActive()=='trial')
              @if($subscribed_restaurant->user->getRemainingFreeDays()<=1)
                  Último día
              @else
                  Quedan {{round($subscribed_restaurant->user->getRemainingFreeDays(), 0, PHP_ROUND_HALF_DOWN)}} días
              @endif
            @else
                Finalizado
            @endif
            </td>
            <td>{{$subscribed_restaurant->user->subscriptionStartsAt()}}</td>
            <td>{{$subscribed_restaurant->user->subscriptionEndsAt()}}</td>
            <td>
              @if($subscribed_restaurant->user->hasGraceDays()!=null)
                @if ($subscribed_restaurant->user->checkUnpaidSubscriptions()==2)
                    Finalizado
                @else
                    {{$subscribed_restaurant->user->hasGraceDays()}}
                @endif
              @else
                -
              @endif
            
            </td>
            </td><td>
              <a href="#" data-restaurantid="{{$subscribed_restaurant->id}}" data-toggle="modal" data-target="#renewSubscriptionModal"><i class="fas fa-sync"></i></a>
              <a href="#"><i class="fas fa-info-circle"></i></a>
              <a href="{{route('subscription.edit', $subscribed_restaurant->id)}}"><i class="far fa-edit"></i></a>
                <a href="#" data-restaurantid="{{$subscribed_restaurant->id}}" data-toggle="modal" data-target="#deleteSubscriptionModal"><i class="far fa-trash-alt"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endif


<!-- Modal -->
<div class="modal fade" id="addNewSubscription" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Agregar nueva suscripción</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
          <div class="row d-flex justify-content-center">
            <div class="col-12">
              <form action="{{route('subscription.store')}}" method="post">
                  @csrf
                  <div class="form-group">
                    <label>Comercio</label>
                    <select name="restaurant_id" class="selectpicker" data-live-search="true" title="Seleccione un comercio" data-width="100%">
                        @foreach ($available_restaurants as $available_restaurant)
                          <option value="{{$available_restaurant->id}}" data-name="{{$available_restaurant->name}}">{{$available_restaurant->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <label>Plan</label>
                  <div class="form-group">
                    <select name="plan_id" class="form-control" aria-label="Default select example">
                      @foreach ($plans as $plan)
                        <option value="{{$plan->id}}">{{$plan->name}}</option>
                      @endforeach
                    </select>
                  </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Suscribir</button>
          </form>
      </div>
  </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="renewSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Renovar suscripción</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <form action="{{route('subscription.renew')}}" method="POST">
        @csrf
        <div class="modal-body" style="text-align:center">
          <h5>¿Estás seguro de renovar esta suscripción?</h5>
          <input type="hidden" value="" name="restaurantid" id="restaurantid">
        </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Confirmar</button>
        </div>
      </form>
  </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div style="text-align:center">
        <img src="{{asset('storage/design/alarm.svg')}}" width="70px" class="my-2" alt="">
        <h5 class="modal-title txt-bold" id="exampleModalCenterTitle">¡Cuidado!</h5>
      </div>
      <form action="{{route('subscription.destroy')}}" method="POST">
          @csrf

      <div class="modal-body" style="text-align:center">
          <h5>¡Estás a punto de eliminar esta suscripción!</h5>
          <p>Los cambios serán permanentes.<br>
            ¿Estás seguro de realizar esta acción?</p>
          <input type="hidden" value="" name="restaurantid" id="restaurantid">
      </div>
      <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Sí, estoy seguro</button>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js-scripts')
<script>
    $('#deleteSubscriptionModal').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)

      var restaurantid = button.data('restaurantid')
      var modal = $(this)

      modal.find('.modal-body #restaurantid').val(restaurantid)
    })


    $('#renewSubscriptionModal').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)

      var restaurantid = button.data('restaurantid')
      var modal = $(this)

      modal.find('.modal-body #restaurantid').val(restaurantid)
    })
</script>
@endsection