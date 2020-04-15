@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Productos</strong></h1>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <a href="{{route('product.create')}}" type="button" class="btn btn-primary">Agregar<i class="fas fa-plus ml-2"></i></a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th></th>
          <th>Foto</th>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Categoria</th>
          <th>Precio</th>
          <th>Producto no disponible</th>
          <th>Ultima actualizacion</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $product)
        <tr>
          <td><input type="checkbox"></td>
          <td><img src="https://img.interempresas.net/fotos/1622791.jpeg" class="img-thumbnail" width="70px" alt=""></td>
          <td>{{$product->name}}</td>
          <td>{{$product->description}}</td>
          <td>{{$product->category->name}}</td>
          <td>${{$product->price}}</td>
          <td><input type="checkbox"></td>
          <td>{{$product->updated_at}}</td>
          <td><a href="{{route('product.edit', $product)}}">Editar</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection