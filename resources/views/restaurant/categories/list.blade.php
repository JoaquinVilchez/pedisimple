@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Categorias</strong></h1>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <button class="btn btn-outline-success mx-2"><i class="far fa-file-excel"></i> Importar Excel</button>
    <a href="{{route('category.create')}}" type="button" class="btn btn-primary">Agregar<i class="fas fa-plus ml-2"></i></a>
    </div>
  </div>

@include('messages')
@if(count($categories)==0)
<p>Todavia no tienes categorias. <a href="{{route('category.create')}}">Agregar una</a></p>
@else
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          {{-- <th></th> --}}
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Estado</th>
          <th>Categoria no disponible</th>
          <th>Ultima actualizacion</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          {{-- <td><input type="checkbox"></td> --}}
          <td>{{$category->name}}</td>
          <td>{{$category->description}}</td>
          <td><span class="{{$category->stateStyle()}}">{{$category->translateState()}}</span></td>
          <td style="text-align:center" width="10%">
            <form id="{{'not_available_checkbox_'.$category->id}}" action="{{route('category.available', $category)}}" method="POST">
              @csrf
              <input type="text" value="{{$category->id}}" name="category_id" hidden>
              <input name="checkbox" type="checkbox" value="{{$category->id}}" onchange="notAvailable({{$category->id}});"
                @if($category->state=='not-available')
                  checked
                @endif
              >
            </form>
          </td>
          <td>{{$category->updated_at}}</td>
          <td><a href="{{route('category.edit', $category)}}">Editar</a></td>
          <td><a href="#" data-categoryid="{{$category->id}}" data-toggle="modal" data-target="#deleteCategoryModal">Eliminar</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
@endif
  </div>

@if(count($categories)!=0)
<!-- Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Eliminar Categoria</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
          <form action="{{route('category.destroy', $category)}}" method="POST">
              @method('DELETE')
              @csrf

      <div class="modal-body">
              <h5>¿Estás seguro de eliminar esta categoria?</h5>  
              <input type="hidden" id="categoryid" name="categoryid" value="">
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
$('#deleteCategoryModal').on('show.bs.modal', function(event){
var button = $(event.relatedTarget)

var categoryid = button.data('categoryid')
var modal = $(this)

modal.find('.modal-body #categoryid').val(categoryid)
})

function notAvailable($id){
  var form = document.getElementById('not_available_checkbox_'+$id)
  form.submit();
}
</script>
@endsection