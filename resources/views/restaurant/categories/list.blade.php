@extends('layouts.commerce')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Categorías</strong></h1>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
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
          <th>Ultima actualización</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          {{-- <td><input type="checkbox"></td> --}}
        <td>{{$category->name}} <small class="txt-muted ml-4"> ({{count($category->products)}} productos)</small></td>
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
          <td>{{$category->updated_at->calendar()}}</td>
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
              @csrf

          <div class="modal-body">
                  <div style="text-align:center">
                      <img src="{{asset('images/design/alarm.svg')}}" width="70px" class="my-2" alt="">
                      <h5 class="modal-title txt-bold" id="exampleModalCenterTitle">¡Cuidado!</h5>
                      <hr>
                      <h5>¿Estás seguro de eliminar esta categoría?</h5>
                      <p>Si eliminas esta categoría se eliminarán todos los productos que estén relacionados a la categoría.</p>  
                      <p>Los cambios serán permanentes.<br>
                        ¿Estás seguro de realizar esta acción?</p>  
                  </div>
                  <input type="hidden" id="categoryid" name="categoryid" value="">
          </div>
      <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Si, estoy seguro</button>
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