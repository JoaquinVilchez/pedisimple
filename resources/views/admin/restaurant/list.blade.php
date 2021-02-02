@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Comercios</strong></h1>
    <a href="{{route('restaurant.check')}}" class="btn btn-sm btn-primary">Inhabilitar comercios sin horarios</a>
</div>

  @include('messages')
  
@if(count($restaurants)==0)
<p>Todavía no hay comercios en la plataforma.</p>
@else
  <div class="table-responsive">
    <table class="table table-sm table-hover">
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
            <td><a href="#" onclick="showUserInfo({{$restaurant->user->id}})" data-toggle="modal" data-target="#ownerInfoModal">{{$restaurant->user->fullName()}}</a></td>   
          <form action="{{route('restaurant.admin.updateStatus')}}" id="stateSelect{{$restaurant->id}}" method="post">
              @csrf
              <input type="text" value="{{$restaurant->id}}" name="restaurant_id" hidden>
              @if($restaurant->state === 'without-times')
                <td>Sin horarios</td>
              @else
                <td>
                  <select name="state" onchange="updateStatus({{$restaurant->id}})">
                    <option value="active" @if($restaurant->state === 'active') selected @endif>Activo</option>  
                    <option value="pending" @if($restaurant->state === 'pending') selected @endif>Pendiente</option>  
                    <option value="cancelled" @if($restaurant->state === 'cancelled') selected @endif>Cancelado</option>  
                    <option value="without-times" @if($restaurant->state === 'without-times') selected @endif>Sin horarios</option> 
                  </select>
                </td>
              @endif
            </form>
              <td>{{$restaurant->created_at->calendar()}}</td>
            <td>
              <a><i class="far fa-edit"></i></a>
              <a href="#" data-restaurantid="{{$restaurant->id}}" data-toggle="modal" data-target="#deleteRestaurantModal"><i class="far fa-trash-alt"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{$restaurants->links()}}
@endif

@if(count($restaurants)!=0)
<!-- Modal -->
<div class="modal fade" id="deleteRestaurantModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Reenviar invitación</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
          <form action="{{route('restaurant.destroy')}}" method="POST">
              @csrf
      <div class="modal-body">
              <h5>¿Estás seguro de eliminar este comercio?</h5>  
              <input type="hidden" id="restaurantid" name="restaurantid" value="">
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

<!-- Modal -->
<div class="modal fade" id="ownerInfoModal" tabindex="-1" aria-labelledby="ownerInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body" id="modal-body">

      </div>
    </div>
  </div>
</div>

@endsection

@section('js-scripts')
<script>

function showUserInfo(id){
    $.ajax({
      url : '{{ route("restaurant.admin.ownerData") }}',
      type: 'POST',
      headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data:{id:id},
      success:function(data){
          $('#modal-body').html(data);
      },
      error:function(error){
        console.log(error)
        $('#modal-body').html(error);
      }
    });
}

$('#resendInvitationModal').on('show.bs.modal', function(event){
var button = $(event.relatedTarget)

var restaurantid = button.data('restaurantid')
var modal = $(this)

modal.find('.modal-body #restaurantid').val(restaurantid)
})

$('#deleteRestaurantModal').on('show.bs.modal', function(event){
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
