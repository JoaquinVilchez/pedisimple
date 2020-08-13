    <ul class="list-group mb-3">
        @foreach (Cart::getContent() as $item)        
    <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div class="col-2">
            <form action="{{route('cart.destroy', $item->id)}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger px-1 py-0"><i class="fas fa-times-circle"></i></button>
            </form>
        </div>
        <div class="col-2">
            <form id="itemUpdate{{$item->id}}" action="{{route('cart.update', $item->id)}}" method="post">
                @csrf
                @method('PUT')
                @if($item->attributes->variants)
                    <input type="hidden" name="type" value="rowid">
                @else
                    <input type="hidden" name="type" value="productid">
                @endif
                <input type="hidden" name="id" value="{{$item->id}}">
                <input type="hidden" name="name" value="{{$item->name}}">
                <input type="hidden" name="quantity" value="{{$item->quantity}}">
                <input type="hidden" name="price" value="{{$item->price}}">
                <select class="float-left" name="quantity" onchange="updateQuantity('{{$item->id}}')" id="cartQuantity">
                    @for ($i = 1; $i < $item->quantity+10; $i++)
                        <option @if($i==$item->quantity) selected @endif value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </form>
        </div>
        <div class="col-6">   
            <h6 class="my-0">{{ucfirst($item->name)}}</h6>
            @if($item->attributes->variants)
                <small><a href="#" data-toggle="modal" data-target="#variantsItemModal" class="ml-2" onclick="showItemVariants({{json_encode($item->attributes->variants)}}, '{{$item->associatedModel->name}}', {{json_encode($item->attributes->aditional_notes)}})">Ver variantes</a></small>
            @endif
        </div>
        <div class="col">
            <span class="text-muted">{{'$'.$item->price}}</span>
        </div>
    </li>
        @endforeach
    @if(isset($restaurant))
        @if($restaurant->shipping_method=='delivery-pickup')
        <li class="list-group-item d-flex justify-content-between">
        <form action="{{route('cart.deliveryTax')}}" method="POST" id="taxForm-{{$restaurant->shipping_method}}">
            @csrf
            <input type="text" name="restaurant_id" hidden value="{{$restaurant->id}}">
            <div class="custom-control custom-radio custom-control-inline">
                <input onchange="updateTax('{{$restaurant->shipping_method}}')" type="radio" id="customRadioInline2" name="shipping_method" class="custom-control-input" value="delivery" @if(Cart::getCondition('Delivery')) checked @endif>
                <label class="custom-control-label" for="customRadioInline2">Delivery</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input onchange="updateTax('{{$restaurant->shipping_method}}')" type="radio" id="customRadioInline1" name="shipping_method" class="custom-control-input" value="pickup" @if(!Cart::getCondition('Delivery')) checked @endif>
                <label class="custom-control-label" for="customRadioInline1">Retiro en local</label>
            </div>
        </form>        
        </li>
        @elseif($restaurant->shipping_method=='delivery')
        <li class="list-group-item d-flex justify-content-center">
            <small style="color:red; text-align:center">
                <p class="mb-0">Este comercio solo hace entregas por delivery.</p>
                <p class="mb-0">El costo está incluido en el total del pedido.</p>
            </small>        
        </li>
        @endif
    @endif
    <li class="list-group-item d-flex justify-content-between">
        <span>Subtotal </span>
        <strong>${{Cart::getSubTotal()}}</strong>
    </li>
    @if(Cart::getCondition('Delivery'))
    <li class="list-group-item d-flex justify-content-between">
        <span>Delivery </span>
        <strong>${{number_format(Cart::getCondition('Delivery')->getValue())}}</strong>
    </li>
    <li class="list-group-item text-center" style="background-color: #f7f7f7">
        <small><strong><p class="mb-0" style="color:red; font-family: 'Roboto', sans-serif;">Importante: El precio del delivery puede variar en base a la distancia.</p></strong></small> 
    </li>
    @endif
    <li class="list-group-item d-flex justify-content-between">
        <span>Total </span>
        <strong>${{Cart::getTotal()}}</strong>
    </li>
    </ul>
    

@section('js-scripts-carrito')

    <script>
        function updateQuantity(id){
            var form = document.getElementById('itemUpdate'+id)
            form.submit();
        }

        function updateTax(shipping_method){
            var form = document.getElementById('taxForm-'+shipping_method)
            form.submit();
        }
        
        function showItemVariants(variants, product, aditional_notes){
            $.ajax({
                url : '{{ route("variant.showItemVariants") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{variants:variants,product:product,aditional_notes:aditional_notes},
                success:function(data){
                    $('#product-modal-body').html(data)
                },
            });
        }
    </script>
@endsection