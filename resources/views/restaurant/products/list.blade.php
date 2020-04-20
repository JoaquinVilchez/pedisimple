@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Productos</strong></h1>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <button class="btn btn-outline-success mx-2"><i class="far fa-file-excel"></i> Importar Excel</button>
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
          <form action="{{route('product.destroy', $product)}}" method="POST">
              @method('DELETE')
              @csrf

      <div class="modal-body">
              <h5>¿Estás seguro de eliminar este producto?</h5>  
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