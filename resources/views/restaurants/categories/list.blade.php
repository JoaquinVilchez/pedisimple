@extends('layouts.admin')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h1 class="h2"><strong>Categorias</strong></h1>
    <div class="btn-toolbar mb-2 mb-md-0 mr-3">
    <a href="{{route('category.create')}}" type="button" class="btn btn-primary">Agregar<i class="fas fa-plus ml-2"></i></a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th></th>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Categoria no disponible</th>
          <th>Ultima actualizacion</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          <td><input type="checkbox"></td>
          <td>{{$category->name}}</td>
          <td>{{$category->description}}</td>
          <td><input type="checkbox"></td>
          <td>{{$category->updated_at}}</td>
          <td><a href="{{route('category.edit', $category)}}">Editar</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection