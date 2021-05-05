@extends('layouts.commerce')

@section('css-scripts')
<style>
  .sortable{
    cursor: move;
  }
</style>
@endsection

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <div class="d-flex">
      <h1 class="h2 d-inline"><strong>Categorías</strong></h1>
      <div class="sort-messages ml-2 d-inline"></div>
    </div>  
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <a href="{{route('category.create')}}" type="button" class="btn btn-primary">Agregar<i class="fas fa-plus ml-2"></i></a>
    </div>
</div>
@if(count($categories)>1)
  <small class="ml-2"><i class="fas fa-exclamation-circle"></i> Organice el orden de muestra de sus categorías moviendo los nombres en la tabla.</small>
@endif

@include('messages')
@if(count($categories)==0)
  <div style="text-align:center" class="m-auto">
    <img data-original="{{asset('storage/design/new-product.svg')}}" alt="" class="img-default my-2">
    <p>Todavia no tienes categorías.<br>
    <a href="{{route('category.create')}}" class="btn btn-secondary btn-sm mt-2">Agregar</a></p>
  </div>  
@else
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>No disponible</th>
          <th>Ultima actualización</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody class="sortable">
        <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
      @foreach($categories as $category)
        <tr data-id="{{$category->id }}">
            <td class="pr-0">
              <small>
                <i style="color: rgb(133, 133, 133)" class="fas fa-arrows-alt"></i>
              </small>
            </td>
            <td class="pl-1">
                <small>
                    <i @if($category->state=='available') style="color:#28a745" @else style="color:#dc3545" @endif class="fas fa-circle"  data-toggle="tooltip" data-placement="bottom" @if($category->state=='available') title="Disponible" @else title="No disponible"@endif></i>
                </small>
            </td>
            <td>{{$category->name}} <small class="txt-muted"> ({{count($category->getProducts())}})</small></td>
            <td width="40%">{{$category->description}}</td>
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
            <td>{{ucfirst($category->updated_at->calendar())}}</td>
            <td class="pr-1">
                <a href="{{route('category.edit', $category)}}"><i class="far fa-edit"></i></a>
            </td>
            <td class="pl-1">
              <a href="#" data-categoryid="{{$category->id}}" data-toggle="modal" data-target="#deleteCategoryModal"><i class="far fa-trash-alt"></i></a>
          </td>
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
                      <img src="{{asset('storage/design/alarm.svg')}}" width="70px" class="my-2" alt="">
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

  $(document).ready(function () {
      var $categories = $('.sortable');
      $categories.sortable({
            cancel: 'input',
            stop: () => {
                var _token = $('#token').val();
                var items = $categories.sortable('toArray', {attribute: 'data-id'});
                var ids = $.grep(items, (item) => item !== "");
                console.log(items);
                console.log(ids);
                console.log(_token);
                $.post('{{ route('category.reorder') }}', {
                        _token,
                        ids
                })
                $('.sort-messages').html('<div class="alert alert-success alert-dismissible fade show py-1" role="alert">Reubicado con éxito.</div>');
                setTimeout(function(){ $('.alert').fadeOut(200); }, 1000);
            }
      });


    $('#deleteCategoryModal').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)

      var categoryid = button.data('categoryid')
      var modal = $(this)

      modal.find('.modal-body #categoryid').val(categoryid)
    })
  });


  function notAvailable($id){
    var form = document.getElementById('not_available_checkbox_'+$id)
    form.submit();
  }
</script>
@endsection