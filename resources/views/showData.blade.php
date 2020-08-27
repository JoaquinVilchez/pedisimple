<div class="modal-header">
<h5 class="modal-title">Agregar producto</h5><br>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
    <div class="modal-body">                    
        <div class="container">
            <input type="hidden" value="{{$product->id}}" name="id">
            <div class="row">
                <div class="col-5 col-md-4 pr-0">
                    @if($product->image != 'no_image.png') 
                        <img src="{{asset('images/uploads/products/'.$product->image)}}" class="img-thumbnail">
                    @else
                        <img src="{{asset('images/uploads/products/no_image.png')}}" class="img-thumbnail">
                    @endif
                </div>
                <div class="col-7 col-md-8">
                    <h6 class="txt-bold">{{ucwords($product->name)}}</h6>
                        <div class="ml-2">
                            @if ($product->details)
                                <p class="text-mute my-1" style="font-size:.9em">Descripción: {{$product->details}}</p>
                            @endif
                                <p class="text-mute my-1" style="font-size:.9em">Precio: ${{$product->price}}</p>
                            @if(!$product->variants)
                                <div class="form-group mt-2" style="font-size:.9em">
                                    <label>Cantidad</label>
                                    <select name="quantity" id="product-quantity">
                                        @for ($i = 1; $i < 10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            @else
                                <input name="quantity" id="product-quantity" value="1" hidden>
                            @endif
                        </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    @if($product->variants) 
                        <div class="variants mb-2">
                            <input type="hidden" id="max_variants" value="{{$product->maximum_variants}}">
                            <small><p>Puedes elegir hasta {{$product->maximum_variants}} variantes.</p></small>
                            <div class="d-flex flex-wrap">
                                @foreach ($variants as $variant)
                                    <label class="btn checkbox-variants mx-1">{{$variant->name}}
                                        <input type="checkbox" class="variant-checkbox" name="variants[]" value="{{$variant->id}}">
                                    </label>
                                @endforeach
                            </div>
                            <small style="color:red" id="errormessage"><i class="fas fa-exclamation-circle"></i> Solo puedes elegir hasta 4 variantes</small>
                        </div>
                    @endif
                    <div class="form-group mt-0">
                        <textarea class="form-control" rows="3" name="aditional_notes" id="product-aditional_notes" placeholder="Notas adicionales"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" onclick="addItem({{$product->id}})" class="spinnerButton btn btn-primary float-right mr-2" id="AddToCartButton" >
            <i class="loadingIcon fas fa-spinner fa-spin d-none"></i> 
            <span class="btn-txt">Agregar a mi pedido</span>
        </button>
    </div>

<script>
    limit = $('#max_variants').val();
    $('#errormessage').hide();

    $('input.variant-checkbox').on('change', function(evt) {
        if($(this).siblings(':checked').length >= limit) {
            
            this.checked = false;
            $('#errormessage').show();
        }
    });

    $('.spinnerButton').on('click', function(e){
        $('.loadingIcon').removeClass('d-none');
        $('.spinnerButton').attr('disabled', true);
        $('.btn-txt').text("Espere por favor...");
    });
</script>