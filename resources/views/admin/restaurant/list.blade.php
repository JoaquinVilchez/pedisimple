@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Comercios</strong></h1>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    </div>
</div>

  @include('messages')
  
@if(count($restaurants)==0)
<p>Todavía no hay comercios en la plataforma.</p>
@else
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th> 
          <th>Responsable</th>
          <th>Estado</th>
          <th>Creada</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
          @foreach($restaurants as $restaurant)
          <tr>
            <td>{{$restaurant->id}}</td>
            <td>{{$restaurant->name}}</td>
            <td>{{$restaurant->user->fullName()}}</td>   
          <form action="{{route('restaurant.admin.updateStatus')}}" id="stateSelect{{$restaurant->id}}" method="post">
              @csrf
              <input type="text" value="{{$restaurant->id}}" name="restaurant_id" hidden>
              <td><select name="state" onchange="updateStatus({{$restaurant->id}})">
                <option value="active" @if($restaurant->state === 'active') selected @endif>Activo</option>  
                <option value="pending" @if($restaurant->state === 'pending') selected @endif>Pendiente</option>  
                <option value="cancelled" @if($restaurant->state === 'cancelled') selected @endif>Cancelado</option>  
              </select>
              <span class="{{$restaurant->stateStyle()}}">{{$restaurant->translateState()}}</span></td>
            </form>       
              <td>{{$restaurant->created_at}}</td>
            <td><a data-restaurantid="{{$restaurant->id}}" data-toggle="modal" data-target="#resendInvitationModal" href="#">Eliminar</a></td>
          </tr>
          @endforeach
        </tbody>
    </table>
</div>
@endif

@if(count($restaurants)!=0)
<!-- Modal -->
<div class="modal fade" id="deleteCommerceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Reenviar invitación</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
          <form action="#" method="POST">
              @csrf
      <div class="modal-body">
              <h5>¿Estás seguro de eliminar este comercio?</h5>  
              <input type="hidden" id="invitationid" name="invitationid" value="">
      </div>
      <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
      </div>
  </div>
  </div>
</div>
@endif

@endsection

@section('js-scripts')
<script>

$('#resendInvitationModal').on('show.bs.modal', function(event){
var button = $(event.relatedTarget)

var restaurantid = button.data('restaurantid')
var modal = $(this)

modal.find('.modal-body #restaurantid').val(restaurantid)
})

function updateStatus(id){
            var form = document.getElementById('stateSelect'+id)
            form.submit();
        }

</script>
@endsection
