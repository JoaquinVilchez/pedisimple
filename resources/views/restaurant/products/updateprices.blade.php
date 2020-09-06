@extends('layouts.commerce')

@section('css-scripts')
<style>
.my-custom-scrollbar {  
  position: relative;
  height: 100vh;
  overflow: auto;
}
.table-wrapper-scroll-y {
  display: block;
}
</style>
@endsection

@section('main')
<form action="{{route('product.updateprices')}}" method="POST">
  @csrf
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Actualizar precios</strong></h1>
  </div>

  @include('messages')
  <div class="row">
    <small class="txt-muted mb-3 ml-3">
      <i class="fas fa-info-circle"></i>
      Modifica el precio de cada producto y luego haz click en actualizar para guardar los cambios.
    </small>
  </div>
  <hr>
  <h6 class="txt-bold pb-2">Delivery</h6>
  <div class="input-group" style="max-width: 150px">
    <div class="input-group-prepend">
      <span class="input-group-text" id="basic-addon1">$</span>
    </div>
    <input type="number" class="form-control" name="delivery" value="{{formatPrice($restaurant->shipping_price)}}">
  </div>
  <hr>
  <h6 class="txt-bold pb-2">Productos</h6>
  <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
    <table class="table table-hover table-sm">
      <thead>
        <tr>
          <th></th>
          <th>Nombre</th>
          <th>Categoría</th>
          {{-- <th>Disponibilidad</th> --}}
          <th>Precio</th>
        </tr>
      </thead>
      <tbody>
          @foreach($products as $product)
          <tr>
            <input type="text" value="{{$product->id}}" name="product[]" hidden>
            <td><small><i @if($product->state=='available') style="color:#28a745" @else style="color:#dc3545" @endif class="fas fa-circle"  data-toggle="tooltip" data-placement="bottom" @if($product->state=='available') title="Disponible" @else title="No disponible"@endif></i></small></td>
            <td>
              {{ucwords($product->name)}}  
            </td>
            <td>{{$product->category->name}}</td>
            <td>
              <div class="input-group" style="max-width: 150px">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">$</span>
                </div>
                <input type="number" class="form-control" name="price[]" value="{{formatPrice($product->price)}}">
              </div>
            </td>
          </tr>
          @endforeach
      </tbody>
      <tfoot>
        <div class="row fixed-bottom" style="background:white">
          <button class="spinnerClickButton btn btn-primary btn-block my-4 mx-4" onclick="submit()" id="btn-submit-form" type="button">
            <i class="loadingIcon fas fa-spinner fa-spin d-none"></i> 
            <span class="btn-txt">Guardar cambios</span>
          </button>
        </div>
      </tfoot>
    </table>
  </div>
</form>
@endsection

