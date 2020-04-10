    <ul class="list-group mb-3">
        @foreach (Cart::session(Auth::user()->id)->getContent() as $item)
    <li class="list-group-item d-flex justify-content-between lh-condensed">
        <div class="col-2">
            <form action="{{route('cart.remove', $item->id)}}" method="post">
                @csrf
                <button type="submit"><i class="fas fa-minus-circle"></i></button>
            </form>
        </div>
        <div class="col-2">
            <form id="itemUpdate{{$item->id}}" action="{{route('cart.update')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$item->id}}">
                <input type="hidden" name="name" value="{{$item->name}}">
                <input type="hidden" name="quantity" value="{{$item->quantity}}">
                <input type="hidden" name="price" value="{{$item->price}}">
                <select class="float-left" name="quantity" onchange="updateQuantity({{$item->id}})" id="cartQuantity">
                    @for ($i = 1; $i < 10; $i++)
                        <option @if($i==$item->quantity) selected @endif value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </form>
        </div>
        <div class="col-6">   
            <h6 class="my-0">{{$item->name}}</h6>    
        </div>
        <div class="col">
            <span class="text-muted">{{'$'.$item->price}}</span>
        </div>
    </li>
        @endforeach
    <li class="list-group-item d-flex justify-content-between">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline1">Delivery</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline2">Lo voy a buscar</label>
        </div>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <span>Subtotal </span>
        <strong>${{Cart::session(Auth::user()->id)->getSubTotal()}}</strong>
    </li>
    <li class="list-group-item d-flex justify-content-between">
        <span>Total </span>
        <strong>${{Cart::session(Auth::user()->id)->getTotal()}}</strong>
    </li>
    </ul>

@section('js-scripts-carrito')

    <script>
        function updateQuantity(id){
            var form = document.getElementById('itemUpdate'+id)
            form.submit();
        }
    </script>

@endsection
