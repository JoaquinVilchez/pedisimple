@extends('layouts.user')

@section('info-content')

    <h5 class="txt-bold">Mis datos</h5>
    <hr>

    <section class="userCard col-xl-6 col-xs-12 mb-4" id="userDataShow">
        
        <section>
            <h4>{{$user->fullName()}}</h4>
            <span><i class="fas fa-envelope mr-2"></i>{{$user->email}}</span><br>
            <span><i class="fas fa-phone mr-2"></i>{{$user->characteristic.' - '.$user->phone}}</span>
        </section> 
        <hr>
    <a href="#" class="btn btn-primary btn-block" id="editData">Editar datos</a>
    <a href="/password/reset" class="btn btn-secondary btn-block">Cambiar contraseña</a>
    </section>
    
    <section class="userFormData col-lg-6 col-xs-12" id="userDataEdit" hidden>
        <form action="{{route('user.update', Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- <figure>
                <img width="150px" src="{{Storage::url(Auth::user()->image)}}" class="img-thumbnail">
                <div class="form-group">
                    <input type="file" name="image" class="form-control-file mt-4">
                </div>
            </figure> --}}

            <label>Imágen</label>
            <div class="form-group">
              <div id="image_container" ><img id="view_image" data-original="{{asset('storage/uploads/user/'.$user->image)}}" class="img-thumbnail" width="150px"></div>
              <div id="delete_image"><a href="#" onclick="removeImage();">Eliminar</a></div>
            </div>
            <div class="input-group mb-3">
              <div class="custom-file">
                <input type="file" name="image" class="custom-file-input" onchange="readURL(this);">
                <label class="custom-file-label" id="upload_image" for="inputGroupFile01">Seleccionar archivo</label>
                <input type="hidden" id="img_action" name="action" value="">
              </div>
            </div>

            <div class="form-group">
                <label>Nombre <small style="color:red">*</small></label>
                <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}">
                {!!$errors->first('first_name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>
            <div class="form-group">
                <label>Apellido <small style="color:red">*</small></label>
                <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}">
                {!!$errors->first('last_name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>
            <div class="form-group">
                <label>Email <small style="color:red">*</small></label>
                <input type="email" class="form-control" name="email" value="{{$user->email}}">
                {!!$errors->first('email', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>
            <div class="form-group">
                <label>Teléfono </label>
                <div class="row">
                    <div class="col-md-4 col-4 pr-1">
                        <input type="text" class="form-control" name="characteristic" value="{{old('characteristic',$user->characteristic)}}" autocomplete="false" placeholder="Prefijo" maxlength="4" onkeypress="return onlyNumberKey(event)">
                    </div> 
                    <div class="col-md-8 col-8 pl-1">
                        <input id="phone" type="text" class="form-control" name="phone" value="{{old('phone',$user->phone)}}" autocomplete="false" placeholder="Teléfono" maxlength="6" onkeypress="return onlyNumberKey(event)">
                    </div>
                </div>
                {!!$errors->first('characteristic', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                {!!$errors->first('phone', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>
            <div class="form-group mt-2">
                <button type="button" class="btn btn-secondary" id="cancelData">Cancelar</button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
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

<script>
  function readURL(input) {
    document.getElementById('image_container').removeAttribute('hidden');
    document.getElementById("img_action").value = "";
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#view_image')
                  .attr('src', e.target.result)

              document.getElementById('delete_image').removeAttribute('hidden')
          };

          reader.readAsDataURL(input.files[0]);
      }
  }

  function removeImage(){
      document.getElementById('image_container').setAttribute('hidden', '');
      document.getElementById('delete_image').setAttribute('hidden', '');
      document.getElementById("upload_image").value = "";
      document.getElementById("img_action").value = "delete";
  }


</script>


@endsection