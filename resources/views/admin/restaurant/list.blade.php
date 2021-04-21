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
          <th>Estado</th>
          <th>Vigencia</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
          @foreach($restaurants as $restaurant)
          <tr>
            <td>{{$restaurant->id}}</td>
            <td><a target="_blank" href="{{route('restaurant.show', $restaurant->slug)}}">{{$restaurant->name}}</a></td>
            <td> <span class="ml-2 {{$restaurant->stateStyle()}}">{{$restaurant->translateState()}}</span>
              @if ($restaurant->state!='active')
                <small><a class="docs-link" href="#" data-restaurantid="{{$restaurant->id}}" data-toggle="modal" data-target="#activeRestaurantModal">Activar</a></small>
              @endif
            </td>
            <td>{{ucfirst($restaurant->created_at->diffForHumans())}}</td>
            <td>
              <a href="#"><i class="far fa-edit"></i></a>
              <a href="#" data-restaurantid="{{$restaurant->id}}" data-toggle="modal" data-target="#deleteRestaurantModal"><i class="far fa-trash-alt"></i></a>
              <a href="#" onclick="showUserInfo({{$restaurant->user->id}})" data-toggle="modal" data-target="#ownerInfoModal"><i class="fas fa-info-circle"></i></a>
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



<!-- Modal -->
<div class="modal fade" id="activeRestaurantModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Activar comercio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('subscription.store')}}" method="post">
        @csrf
        <div class="modal-body">
          <h5>¿Estás seguro de activar este comercio?</h5>  
          <input type="hidden" id="restaurantid" name="restaurant_id" value="">
          <label>Plan</label>
          <div class="form-group">
            <select name="plan_id" class="form-control" aria-label="Default select example">
              @foreach ($plans as $plan)
                <option value="{{$plan->id}}">{{$plan->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Activar</button>
        </div>
      </form>
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

$('#activeRestaurantModal').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget)

  var restaurantid = button.data('restaurantid')
  var modal = $(this)

  modal.find('.modal-body #restaurantid').val(restaurantid)
  })

  var restaurantSlug = null

  $('#closedRestaurantModal').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget)

  restaurantSlug = button.data('restaurantslug')
  var modal = $(this)
  })
</script>
@endsection
