@extends('layouts.user')

@section('info-content')

    <h5>Mis datos <small></small></h5>

    <section class="userCard col-6 mb-4" id="userDataShow">
        
        <figure>
            <img width="150px" src="{{Storage::url(Auth::user()->image)}}" class="img-thumbnail">
        </figure>
        
        <section>
            <h4>{{$user->fullName()}}</h4>
            <span><i class="fas fa-envelope mr-2"></i>{{$user->email}}</span><br>
            <span><i class="fas fa-phone mr-2"></i>{{$user->phone}}</span>
        </section> 
        <hr>
        
    <a href="#" class="btn btn-outline-danger" id="editData">Editar datos</a>
    </section>
    
    <section class="userFormData col-lg-6 col-xs-12" id="userDataEdit" hidden>
        <form action="{{route('user.update', Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <figure>
                <img width="150px" src="{{Storage::url(Auth::user()->image)}}" class="img-thumbnail">
                <input type="file" name="image" class="form-control-file">
            </figure>
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}">
            </div>
            <div class="form-group">
                <label>Apellido *</label>
                <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}">
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" class="form-control" name="email" value="{{$user->email}}">
            </div>
            <div class="form-group">
                <label>Phone </label>
                <input type="text" class="form-control" name="phone" value="{{$user->phone}}">
            </div>
            <div class="form-group">
                <a href="#">Cambiar contraseña</a>
            </div>
            <small>Todos los campos son requeridos</small>
            <div class="form-group mt-2">
                <button type="button" class="btn btn-outline-secondary" id="cancelData">Cancelar</button>
                <button type="submit" class="btn btn-danger">Cambiar</button>
            </div>
        </form>
    </section>
    
@endsection

@section('js-scripts')
<script>
    var editDataButton = document.getElementById("editData");
    var cancelDataButton = document.getElementById("cancelData");
    
    editDataButton.onclick = function(event){
        document.getElementById("userDataShow").setAttribute("hidden","");
        document.getElementById("userDataEdit").removeAttribute("hidden","");
    }

    cancelDataButton.onclick = function(event){
        document.getElementById("userDataShow").removeAttribute("hidden","");
        document.getElementById("userDataEdit").setAttribute("hidden","");
    }

</script>
@endsection