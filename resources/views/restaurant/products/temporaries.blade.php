@extends('layouts.commerce')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Productos temporales</strong></h1>  
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <a href="{{route('product.create')}}" type="button" class="btn btn-primary">Agregar<i class="fas fa-plus ml-2"></i></a>
    </div>
</div>

  @include('messages')
  <div class="row">
    <small class="txt-muted mb-3 ml-3">
      <i class="fas fa-info-circle"></i>
      El producto sólo se mostrará en una fecha determinada y luego desaparecerá.
    </small>
  </div>
  @if(count($products)==0)
    <div style="text-align:center" class="m-auto">
      <img data-original="{{asset('storage/design/new-product.svg')}}" alt="" class="img-default my-2">
      <p>Todavía no tienes productos temporales.<br>
      <a href="{{route('product.create')}}" class="btn btn-secondary btn-sm mt-2">Agregar</a></p>
      {{-- <a href="{{route('product.create')}}" class="btn btn-secondary btn-sm mt-2 d-inline">Importar planilla</a></p> --}}
    </div>
  @else
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          {{-- <th></th> --}}
          <th>Foto</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Categoría</th>
          <th>Precio</th>
          <th>Estado</th>
          <th>Última actualización</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
          @foreach($products as $product)
          <tr>
            <td>
              <div class="d-inline">
                <img data-original="{{asset('storage/uploads/products/'.$product->image)}}" class="img-thumbnail" style="object-fit: cover; width:50px" alt="">
              </div>
            </td>
            <td>
              {{$product->name}}
              @if(count($product->getVariants)>0)
                <br><small><a href="#" data-toggle="modal" data-target="#variantsModal" onclick="showVariants({{$product->id}})">Ver variantes</a></small>
              @endif
            </td>
            <td>{{$product->details}}</td>
              @if($product->category_id!=null)
                <td>{{$product->category->name}}</td>
              @else
                <td>Sin categoría</td>
              @endif
            <td>${{formatPrice($product->price)}}</td>
            <td><small>{{$product->getTemporaryDate()}}</small></td>
            <td>{{ucfirst($product->updated_at->calendar())}}</td>
            <td>
              <a href="{{route('product.edit', $product)}}"><i class="far fa-edit"></i></a>
              @if ($product->isTemporaryActive())
                <a href="#" data-toggle="modal" data-target="#stopTemporaryProductModal" data-productid="{{$product->id}}"><i class="fas fa-minus-circle"></i></a>
              @endif
            </td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>

<!-- Modal -->
<div class="modal fade" id="variantsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Variantes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="product-modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="stopTemporaryProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Detener producto temporal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('product.temporary.stop')}}" method="POST">
          @method('post')
          @csrf
      <div class="modal-body">
          <p>¿Estás seguro de detener la publicación de este producto temporal?</p>  
          <input type="hidden" id="productid" name="productid" value="">
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Detener</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js-scripts')
<script>

$('#stopTemporaryProductModal').on('show.bs.modal', function(event){
var button = $(event.relatedTarget)

var productid = button.data('productid')
var modal = $(this)

modal.find('.modal-body #productid').val(productid)
})

function notAvailable($id){
  var form = document.getElementById('not_available_checkbox_'+$id)
  form.submit();
}

function showVariants(productid){
    $.ajax({
      url : '{{ route("variant.getVariants") }}',
      type: 'POST',
      headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data:{productid:productid},
      success:function(data){
          $('#product-modal-body').html(data)
      },
    });
}

</script>
@endsection
