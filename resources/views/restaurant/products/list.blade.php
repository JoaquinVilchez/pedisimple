@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Productos</strong></h1>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <div class="btn-group" role="group">
      <button id="btnGroupDrop1" type="button" class="btn btn-outline-dark dropdown-toggle mx-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Acciones
      </button>
      <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#importExcelModal" >Importar</a>
        <a class="dropdown-item" href="{{route('product.export.excel')}}">Exportar</a>
      </div>
    </div>
    <a href="{{route('product.create')}}" type="button" class="btn btn-primary">Agregar<i class="fas fa-plus ml-2"></i></a>
    </div>
  </div>

  @include('messages')
  
  @if(count($products)==0)
    <p>Todavia no tienes productos. <a href="{{route('product.create')}}">Agregar uno</a></p>
  @else
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          {{-- <th></th> --}}
          <th>Foto</th>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Categoria</th>
          <th>Precio</th>
          <th>Estado</th>
          <th>Producto no disponible</th>
          <th>Ultima actualizacion</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
          @foreach($products as $product)
          <tr>
            {{-- <td><input type="checkbox"></td> --}}
            <td><img src="{{Storage::url($product->image)}}" class="img-thumbnail" width="70px" alt=""></td>
            <td>{{$product->name}}</td>
            <td>{{$product->description}}</td>
            <td>{{$product->category->name}}</td>
            <td>${{$product->price}}</td>
            <td><span class="{{$product->stateStyle()}}">{{$product->translateState()}}</span></td>
            <td style="text-align:center" width="10%">
              <form id="{{'not_available_checkbox_'.$product->id}}" action="{{route('product.available', $product)}}" method="POST">
                @csrf
                <input type="text" value="{{$product->id}}" name="product_id" hidden>
                <input name="checkbox" type="checkbox" value="{{$product->id}}" onchange="notAvailable({{$product->id}});"
                  @if($product->state=='not-available')
                    checked
                  @endif
                >
              </form>
            </td>
            <td>{{$product->updated_at}}</td>
            <td>
              <a href="{{route('product.edit', $product)}}">Editar</a>
              <a href="#" data-productid="{{$product->id}}" data-toggle="modal" data-target="#deleteProductModal">Eliminar</a>
            </td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>

@if(count($products)!=0)
<!-- Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalCenterTitle">Eliminar producto</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
          <form action="{{route('product.destroy')}}" method="POST">
              @method('delete')
              @csrf

      <div class="modal-body">
              <h5>¿Estás seguro de eliminar este producto?</h5>  
              <input type="hidden" id="productid" name="productid" value="">
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
            <div class="btn-group-toggle my-3" width="100%" data-toggle="buttons">
              <label class="btn btn-outline-success">
                <input type="checkbox" value="update" id="method_1" name="method"><strong>Agregue nuevos productos y actualice los existentes</strong>
                <p class="m-0"><small>Los productos existentes serán revisados, no eliminados.</small></p>
              </label>
            </div>
            <div id="export_info"><span class="badge badge-warning"><a href="{{route('product.export.excel')}}">Descargue su archivo de productos</a> y actualice la información.</span></div>
            <div class="btn-group-toggle my-3" width="100%" data-toggle="buttons">
              <label class="btn btn-outline-success">
                <input type="checkbox" value="replace" id="method_2" name="method"><strong>Reemplazar productos</strong>
                <p class="m-0"><small>Todos los artículos serán eliminados y reemplazados.</small></p>
              </label>
            </div>
          </div>
          <hr>
          <h6>Seleccione un archivo de Excel: </h6>
          <div class="form-group">
            <input type="file" name="file">
          </div>
          <hr>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Importar</button>
          </div>

        </form>
    </div>
  </div>
</div>

@endsection

@section('js-scripts')
<script>

$( document ).ready(function() {
    var method_1 = document.getElementById('method_1');
    var method_2 = document.getElementById('method_2');

    if(method_1.checked){ 
      console.log('El metodo 1 esta seleccionado');
    }else if(method_2.checked){
      console.log('El metodo 2 esta seleccionado');
    }

});

$('#deleteProductModal').on('show.bs.modal', function(event){
var button = $(event.relatedTarget)

var productid = button.data('productid')
var modal = $(this)

modal.find('.modal-body #productid').val(productid)
})

function notAvailable($id){
  var form = document.getElementById('not_available_checkbox_'+$id)
  form.submit();
}



</script>
@endsection
