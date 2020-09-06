@extends('layouts.commerce')

@section('main')
<form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
@csrf
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-3">
  <h4 style="font-weight: 900">Agregar producto</h4>
  <div class="btn-toolbar mb-2 mb-md-0 mr-3 d-none d-sm-block">
    <a href="{{route('product.index')}}" class="btn btn-secondary mx-2">Cancelar</a>
    @if(count($categories)!=0)
    <button type="submit" class="btn btn-primary">Guardar</button>
    @endif
  </div>
</div>
<div class="container container-fluid">
@if(count($categories)==0)
  <p>Primero debes crear una categoría antes que un producto. <br>
    <a class="btn btn-sm btn-secondary my-2" href="{{route('category.create')}}">Crear categorías</a></p>
@else
  <div class="row">
      <div class="col-xl-6 col-12 my-2 pl-0">
        <div class="card">
          <h5 class="card-header">Detalles del producto</h5>
          <div class="card-body">
            <div class="form-group">
              <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}" autocomplete="off">
                {!!$errors->first('name', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Detalles</label>
              <textarea class="form-control" name="details" id="exampleFormControlTextarea1" rows="3" value={{old('details')}}>{{old('details')}}</textarea>
              <small class="form-text text-muted">Este campo es opcional</small>
            </div>

            @if($variants->count()>0)
              <label>Variantes</label>
              <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingOne">
                      <label class="form-check-label ml-3">
                        <input class="form-check-input" type="checkbox" id="has_variants" name="has_variants" data-toggle="collapse" data-target="#variantsCollapse" aria-expanded="true" aria-controls="variantsCollapse">
                        Este producto tiene variantes <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Por ejemplo: Gustos de helado, gustos de pizza, etc."></i>
                      </label>
                  </div>
              
                  <div id="variantsCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                      <div class="row my-2">
                        <div class="input-group mb-3 col-xl-6">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Mínimo</span>
                          </div>
                          <input type="number" id="minimum" name="minimum" class="form-control" min="0" value="{{old('minimum')}}" autocomplete="off">
                          {!!$errors->first('minimum', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        </div>
    
                        <div class="input-group mb-3 col-xl-6">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Máximo</span>
                          </div>
                          <input type="number" id="maximum" name="maximum" class="form-control" min="0" value="{{old('maximum')}}" autocomplete="off">
                          {!!$errors->first('maximum', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        </div>
                      </div>
                      <div class="variants-details">
                        <small>
                          <a href="">
                            <label>
                              <td><input type="checkbox" id="select_all" /> Seleccionar todas</td>
                            </label>
                          </a>
                        </small><br>
                        @foreach ($variants as $variant)
                        <span class="btn-checkbox m-1 p-1 rounded">
                          <label>
                            <input name="variants[]" type="checkbox" value="{{$variant->id}}">
                            {{$variant->name}}
                          </label>
                        </span>
                        @endforeach
                      </div>
                        {!!$errors->first('variants', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                    </div>
                    <div class="container">
                      <small><a href="#" class="btn btn-sm btn-block btn-outline-success mb-2" data-toggle="modal" data-target="#addVariant">+ Crear variante</a></small>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>

      <div class="col-xl-6 col-12 my-2 pl-0">
        <div class="card">
          <h5 class="card-header">Categoría</h5>
          <small class="txt-muted px-3 pt-3">
            <i class="fas fa-info-circle"></i>
            Si el producto es temporal, no es obligatorio indicar una categoría.
          </small>
          <div class="card-body">
            @foreach($categories as $category)
            <div class="row">
              <div class="col-6">
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="radio" name="category_id" value="{{$category->id}}" value="{{old('category_id')}}">
                    {{$category->name}} 
                </label>
              </div>
            </div>
            </div>
            @endforeach
            {!!$errors->first('category_id', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
          </div>
        </div>

      </div>    
    
      <div class="col-xl-6 col-12 pl-0">
        <div class="card my-2">
          <h5 class="card-header">Otros</h5>
          <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <label>Precio</label>
                  <div class="input-group mb-3 pl-0">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="price" class="form-control" min="0" value="{{old('price')}}" autocomplete="off">
                    {!!$errors->first('price', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Estado</label>
                    <select class="form-control" name="state" value={{old('state')}}>
                      <option value="available" selected>Disponible</option>
                      <option value="not-available">No disponible</option>
                    </select>
                  </div>
                </div>
              </div>

            <label>Imágen</label>
              <div class="form-group">
                <div id="image_container" hidden><img id="view_image" data-original="{{asset('storage/uploads/products/no_image.png')}}" class="upload-image-preview"></div>
                <div id="delete_image" hidden><a href="#" onclick="removeImage();">Eliminar</a></div>
              </div>
              <div class="input-group mb-3">
                <div class="custom-file">
                  <input type="file" name="image" class="custom-file-input" onchange="readURL(this);" value="{{old('file')}}">
                  <label class="custom-file-label" id="upload_image" for="inputGroupFile01">Seleccionar archivo</label>
                </div>
              </div>
          </div>
        </div>
      </div>

      <div class="col-xl-6 col-12 pl-0">
      
        <div class="accordion my-2" id="temporalAccordion">
          <div class="card">
            <div class="card-header" id="headingOne">
              <label class="form-check-label ml-3">
                <input class="form-check-input" type="checkbox" name="temporary" @if(old('temporary')) checked @endif" data-toggle="collapse" data-target="#temporalCollapse" aria-expanded="true" aria-controls="temporalCollapse">
                  Este producto Es temporal <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="El producto sólo se mostrará en una fecha determinada y luego desaparecerá."></i>
              </label>
            </div>
        
            <div id="temporalCollapse" class="collapse" aria-labelledby="headingOne" data-parent="#temporalAccordion">
              <div class="card-body">
                <label>Período</label>
                  <div class="form-group">
                    <div class="row">
                      <div class="input-group col-6">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="">Inicio</span>
                          </div>
                          <input type="text" class="form-control datepicker" name="start_date" value="{{old('start_date')}}" autocomplete="off">
                          <small>Comienza a las 00:00hs de este día (Este día está incluido)</small>
                      </div>
                      <div class="input-group col-6">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="">Fin</span>
                        </div>
                        <input type="text" class="form-control datepicker" name="end_date" value="{{old('end_date')}}" autocomplete="off">
                        <small>Termina a las 00:00hs de este día (Este día no está incluido)</small>
                      </div>
                    </div>
                  </div>             
                  {!!$errors->first('start_date', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                  <br>
                  {!!$errors->first('end_date', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
              </div>
            </div>
          </div>          
        </div>
      </div>
  </div>
{{-- btn-mobile --}}
<div class="d-block d-sm-none">
<div class="row my-3">
    <div class="col-xl-12">
      <a href="{{route('product.index')}}" class="btn btn-secondary btn-block">Cancelar</a>
      <button type="submit" class="btn btn-primary btn-block">Guardar</button>
    </div>
  </div>
</div>
{{-- btn-mobile --}}
@endif
</form>

<!-- Modal -->
<div class="modal fade" id="addVariant" tabindex="-1" role="dialog" aria-labelledby="addVariantLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addVariantLabel">Crear variante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="variantForm" method="POST">
          @csrf
          @method('POST')
          <div class="form-group">
            <label for="variantName">Nombre de la variante</label>
            <input type="text" class="form-control" id="variantName" name="variant-name" autocomplete="off">
          </div>  
          <div class="form-group">
            <label>Descripción</label>
            <textarea class="form-control" name="variant-description" rows="3"></textarea>
          </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="createVariant();">Guardar</button>
      </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('js-scripts')
<script>
  function readURL(input) {
      document.getElementById('image_container').removeAttribute('hidden')
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
  }

  $('#select_all').change(function() {
    var checkboxes = $(this).closest('.variants-details').find(':checkbox');
    checkboxes.prop('checked', $(this).is(':checked'));
  });

  function createVariant(){
    let name = $("input[name=variant-name]").val();
    let description = $("textarea[name=variant-description]").val();
    $.ajax({
      url : '{{ route("variant.ajaxcreate") }}',
      type: 'POST',
      headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data:{name:name,description:description},
      success:function(data){
          $('.variants-details').append(data);
          $('#addVariant').find("input[type=text], textarea").val("");
          $('#addVariant').modal('hide');
      },
    });
  }

</script>
@endsection


