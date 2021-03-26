@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Invitaciones</strong></h1>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <div class="btn-group" role="group">
    <a href="{{route('invitation.create')}}" type="button" class="btn btn-primary">Crear<i class="fas fa-plus ml-2"></i></a>
    </div>
    </div>
</div>

  @include('messages')
  
@if(count($invitations)==0)
<p>Todavía no tienes invitaciones. <a href="{{route('invitation.create')}}">Crear una</a></p>
@else
  <div class="table-responsive">
    <table class="table table-sm table-hover">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Email</th>
          <th>Creada</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
          @foreach($invitations as $invitation)
          <tr>
            <td>{{$invitation->fullName()}}</td>
            <td>{{$invitation->email}}</td>
            <td>{{ucfirst($invitation->updated_at->calendar())}}</td>
            <td>
              <a data-invitationid="{{$invitation->id}}" data-toggle="modal" data-target="#resendInvitationModal" href="#"><i class="fas fa-redo-alt"></i></a>
              <a data-invitationid="{{$invitation->id}}" data-toggle="modal" data-target="#deleteInvitationModal" href="#"><i class="fas fa-trash-alt"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
    </table>
    {{$invitations->links()}}
</div>
@endif

@if(count($invitations)!=0)
<!-- Modal -->
<div class="modal fade" id="resendInvitationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Reenviar invitación</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
          <form action="{{route('invitation.resend')}}" method="POST">
              @csrf
      <div class="modal-body">
              <h5>¿Estás seguro de reenviar esta invitación?</h5>  
              <input type="hidden" id="invitationid" name="invitationid" value="">
      </div>
      <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Reenviar</button>
          </form>
      </div>
  </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteInvitationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Reenviar invitación</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
          <form action="{{route('invitation.delete')}}" method="POST">
              @csrf
      <div class="modal-body">
              <h5>¿Estás seguro de reenviar esta invitación?</h5>  
              <input type="hidden" id="invitationid" name="invitationid" value="">
      </div>
      <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Reenviar</button>
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

var invitationid = button.data('invitationid')
var modal = $(this)

modal.find('.modal-body #invitationid').val(invitationid)
})

$('#deleteInvitationModal').on('show.bs.modal', function(event){
var button = $(event.relatedTarget)

var invitationid = button.data('invitationid')
var modal = $(this)

modal.find('.modal-body #invitationid').val(invitationid)
})
</script>
@endsection
