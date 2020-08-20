<div class="modal-header">
<h5 class="modal-title">{{$product->name}}</h5><br>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
    <form action="{{route('cart.store')}}" method="post">
            @csrf
        <div class="modal-body">                    
            <input type="hidden" value="{{$product->id}}" name="id">
            <div id="modalImage" class="img-fluid img-modal mb-2">
                @if($product->image != 'no_image.png') 
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{asset('images/uploads/products/'.$product->image)}}" alt="">
                            </div>
                        </div>
                    </div>                                              
                    <hr>
                @endif
            </div>
            <div class="container">
                @if ($product->details)
                    <h6>Descripción del producto:</h6>
                    <p class="text-mute">{{$product->details}}</p>
                    <hr>
                @endif
                @if(!$product->variants)
                    <div class="form-group">
                        <label>Cantidad</label>
                        <select name="quantity">
                            @for ($i = 1; $i < 10; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                @else
                    <input name="quantity" value="1" hidden>
                @endif
                @if($product->variants)
                    <hr>
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
                    <hr>
                @endif
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="aditional_notes" placeholder="Notas adicionales"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary float-right mr-2" id="AddToCartButton" onsubmit="addItemToCart()">Agregar a mi pedido</button>
    </form>
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
</script>