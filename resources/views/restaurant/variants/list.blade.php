@extends('layouts.commerce')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Variantes</strong></h1>  
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <a href="{{route('variant.create')}}" type="button" class="btn btn-primary">Agregar<i class="fas fa-plus ml-2"></i></a>
    </div>
</div>

  @include('messages')
  <div class="row">
    <small class="txt-muted mb-3 ml-3">
      <i class="fas fa-info-circle"></i>
      Agregue variaciones de su producto como por ejemplo: Gustos.
    </small>
  </div>
  @if(count($variants)==0)
    <div style="text-align:center" class="m-auto">
      <i class="fas fa-tags fa-4x text-primary my-2"></i>
      <p>Todavía no tienes variantes.<br>
      <a href="{{route('variant.create')}}" class="btn btn-secondary btn-sm mt-2">Agregar</a></p>
    </div>
  @else
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>No disponible</th>
          <th>Última actualización</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
          @foreach ($variants as $variant)
          <tr>
          <td>{{$variant->name}}</td>
            <td style="text-align:center" width="10%">
              <form id="{{'not_available_checkbox_'.$variant->id}}" action="{{route('variant.available', $variant)}}" method="POST">
                @csrf
                <input type="text" value="{{$variant->id}}" name="variant_id" hidden>
                <input name="checkbox" type="checkbox" value="{{$variant->id}}" onchange="notAvailable({{$variant->id}});"
                  @if($variant->state=='not-available')
                    checked
                  @endif
                >
              </form>
            </td>
            {{-- <td><span class="{{$variant->stateStyle()}}">{{$variant->translateState()}}</span></td> --}}
            <td>{{ucfirst($variant->updated_at->calendar())}}</td>
            <td>
              <a href="{{route('variant.edit', $variant->id)}}"><i class="far fa-edit"></i></a>
              <a href="#" data-variantid="{{$variant->id}}" data-toggle="modal" data-target="#deleteVariantModal"><i class="far fa-trash-alt"></i></a>
            </td>
          </tr>
          @endforeach
      </tbody>
  @endif
    </table>
  </div>
  {{$variants->links()}}

@if(count($variants)!=0)
<!-- Modal -->
<div class="modal fade" id="deleteVariantModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Eliminar variante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('variant.destroy')}}" method="POST">
          @csrf
      <div class="modal-body">
        <div style="text-align:center">
          <i class="fas fa-exclamation-triangle fa-4x text-warning my-2"></i>
          <h5 class="modal-title txt-bold" id="exampleModalCenterTitle">¡Cuidado!</h5>
          <p>Al eliminar esta variante, dejará de estar relacionada a los productos que se les había asignado previamente.</p>
          <input type="hidden" id="variantid" name="variantid" value="">
        </div>
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

$('#deleteVariantModal').on('show.bs.modal', function(event){
var button = $(event.relatedTarget)

var variantid = button.data('variantid')
var modal = $(this)

modal.find('.modal-body #variantid').val(variantid)
})

function notAvailable($id){
  var form = document.getElementById('not_available_checkbox_'+$id)
  form.submit();
}

</script>
@endsection
