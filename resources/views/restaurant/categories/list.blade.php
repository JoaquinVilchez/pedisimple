@extends('layouts.commerce')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Categorías</strong></h1>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn btn-outline-dark dropdown-toggle mx-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Acciones
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#importExcelModal" >Importar</a>
          <a class="dropdown-item" href="{{route('category.export.excel')}}">Exportar</a>
        </div>
      </div>
    <a href="{{route('category.create')}}" type="button" class="btn btn-primary">Agregar<i class="fas fa-plus ml-2"></i></a>
    </div>
  </div>

@include('messages')
@if(count($categories)==0)
  <div style="text-align:center" class="m-auto">
    <img src="{{asset('images/design/new-product.svg')}}" alt="" class="img-default my-2">
    <p>Todavia no tienes categorías.<br>
    <a href="{{route('category.create')}}" class="btn btn-secondary btn-sm mt-2">Agregar</a></p>
  </div>  
@else
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          {{-- <th></th> --}}
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Categoría no disponible</th>
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
      <h5 class="modal-title" id="exampleModalCenterTitle">Eliminar categoría</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
          <form action="{{route('category.destroy')}}" method="POST">
              @method('delete')
              @csrf

      <div class="modal-body">
              <h5>¿Estás seguro de eliminar esta categoría?</h5>  
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


<!-- Modal -->
<div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Importar productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body d-flex justify-content-center" style="text-align:center">

        <form action="{{route('product.import.excel')}}" method="post" enctype="multipart/form-data">
          @csrf
          <h6>Seleccione una opcion: </h6>
          <div class="form-group">
              <label class="btn btn-outline-primary">
                <input class="mr-1" type="radio" value="update" id="method_1" name="method"><strong>Agregue nuevos productos y actualice los existentes</strong>
                <p class="m-0"><small>Los productos existentes serán revisados, no eliminados.</small></p>
              </label>
            <div id="export_info" class="mb-3"><span class="badge badge-warning"><a href="{{route('product.export.excel')}}">Descargue su archivo de productos</a> y actualice la información.</span></div>

              <hr>
              <label class="btn btn-outline-primary mw-100" style="width: 466px">
                <input class="mr-1" type="radio" value="replace" id="method_2" name="method"><strong>Reemplazar productos</strong>
                <p class="m-0"><small>Todos los artículos serán eliminados y reemplazados.</small></p>
              </label>
          
          <hr>
          <h6>Seleccione un archivo de Excel: </h6>
          <div class="form-group">
            <input type="file" name="file">
          </div>
          <hr>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Importar</button>
          </div>

        </form>
    </div>
  </div>
</div>


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