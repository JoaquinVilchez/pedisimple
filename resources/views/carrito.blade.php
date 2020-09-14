<div class="sticky-top pb-3 pt-1" id="cart-content">
    <div class=" border rounded p-3">
        <div id="cart-data"></div>  
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="align-items-center">
                        <h5 class="d-inline">Tu pedido</h5>
                        @if(!Cart::isEmpty())
                            <small><a class="d-inline" style="cursor: pointer" onclick="confirmAlert()" id="btnConfirmEmptyCart"><span><i class="fas fa-trash-alt"></i></span></a></small>
                        @endif
                    </div>
                    <div>
                        <span class="badge badge-secondary badge-pill d-inline" id="cart-total-quantity">{{Cart::getTotalQuantity()}}</span>
                    </div>
                </div>
                <div class="alert alert-primary mt-2" style="font-size:.8em" role="alert" id="confirmEmptyCart" hidden>
                    ¿Estás seguro de vaciar el carrito? <a onclick="emptyCart({{$restaurant->id}})" style="cursor: pointer" class="alert-link">Si</a> | <a onclick="confirmAlert()" style="cursor: pointer" class="alert-link">No</a>
                </div>
            </div>
        
            {{-- CARRITO --}}
            <div  @if(Cart::isEmpty()) id="cart-empty-true" @else id="cart-empty-false" @endif></div>
            <div id="cart-not-empty">
                <ul class="list-group list-group-flush">
                    @foreach (Cart::getContent() as $item)        
                        <li class="list-group-item d-flex justify-content-between lh-condensed" id="item-{{$item->id}}">
                            <div class="col-3">
                                <div class="row">
                                    <a onclick="removeItem('{{$item->id}}')" style="cursor:pointer"><i style="color: #e70000" class="d-inline fas fa-times-circle mr-2"></i></a>
                                    {{-- <form id="itemUpdate{{$item->id}}">
                                        @csrf
                                        @method('PUT') --}}
                                        @if($item->attributes->variants)
                                            <input type="hidden" name="type" value="rowid">
                                        @else
                                            <input type="hidden" name="type" value="productid">
                                        @endif
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <input type="hidden" name="name" value="{{$item->name}}">
                                        <input type="hidden" name="quantity" value="{{$item->quantity}}">
                                        <input type="hidden" name="price" value="{{formatPrice($item->price)}}">
                                        <select class="d-inline float-left" name="quantity" onchange="updateItemQuantity('{{$item->id}}')" id="cart-update-quantity-{{$item->id}}">
                                            @for ($i = 1; $i < $item->quantity+10; $i++)
                                                <option @if($i==$item->quantity) selected @endif value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    {{-- </form> --}}
                                </div>
                            </div>
                            <div class="col-7">   
                                <h6 class="my-0">{{ucfirst($item->name)}}</h6>
                                @if($item->attributes->variants)
                                    <small><a href="#" data-toggle="modal" data-target="#variantsItemModal" class="ml-2" onclick="showItemVariants({{json_encode($item->attributes->variants)}}, '{{$item->associatedModel->name}}', {{json_encode($item->attributes->aditional_notes)}})">Ver variantes</a></small>
                                @endif
                            </div>
                            <div class="col">
                                <span class="text-muted" id="cart-item-{{$item->id}}-price">{{'$'.formatPrice($item->price*$item->quantity)}}</span>
                            </div>
                        </li>
                    @endforeach
                    @if(isset($restaurant))
                        @if($restaurant->shipping_method=='delivery-pickup')
                        <li class="list-group-item d-flex justify-content-between" style="border-top:2px solid #ffa64d">
                        <form action="{{route('cart.deliveryTax')}}" method="POST" id="taxForm-{{$restaurant->shipping_method}}">
                            @csrf
                            <input type="text" name="restaurant_id" hidden value="{{$restaurant->id}}">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input onchange="updateTax({{$restaurant->id}})" type="radio" id="checkboxDelivery" name="shipping_method" class="custom-control-input" value="delivery" @if(Cart::getCondition('Delivery')) checked @endif>
                                <label class="custom-control-label" for="checkboxDelivery">Delivery</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input onchange="updateTax({{$restaurant->id}})" type="radio" id="checkboxPickup" name="shipping_method" class="custom-control-input" value="pickup" @if(!Cart::getCondition('Delivery')) checked @endif>
                                <label class="custom-control-label" for="checkboxPickup">Retiro en local</label>
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
                        <strong id="cart-subtotal">${{Cart::getSubTotal()}}</strong>
                    </li>
                    {{-- @if(Cart::getCondition('Delivery')) --}}
                    <div id="cart-delivery-info">
                        <li class="list-group-item d-flex justify-content-between rounded-0">
                            <span>Delivery </span>
                            <strong>${{formatPrice($restaurant->shipping_price)}}</strong>
                        </li>
                        <div class="alert alert-warning py-1 mb-0" style="font-size: 12px; border-radius: 0px 0px 2px 2px" role="alert">
                            <i class="fas fa-exclamation-circle"></i> El precio del delivery puede variar en base a la distancia.
                        </div>
                    </div>
                    {{-- @endif --}}
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total </span>
                        <strong id="cart-total">${{Cart::getTotal()}}</strong>
                    </li>
                </ul>
                {{-- CARRITO --}}
                @if(Route::current()->getName()=='checkout.index')
                    <div class="my-3">
                        <a href="{{route('restaurant.show', $restaurant->slug)}}" type="button" class="btn btn-light btn-block"><i class="fas fa-angle-left"></i> Seguir comprando</a>
                    </div>  
                @else
                    <div class="my-3">
                        <a href="{{route('checkout.index')}}" class="btn btn-primary btn-block">Finalizar pedido</a>
                    </div>
                @endif
            </div>
        
            <div class="list-group mb-3" id="cart-empty" style="text-align: center">
                <div style="text-align: center" class="my-4">
                    <img src="{{asset('storage/design/empty_cart.png')}}" alt="" width="100px" style="opacity: 0.7">
                    <small class="d-block mt-2  ">No tienes productos en tu pedido</small>
                </div>
                <a href="{{route('list.index')}}" class="btn btn-primary">Ver comercios</a>
            </div>
    </div>

    @if(Cart::getTotalQuantity()>0)
    <div class="fixed-bottom mb-4 d-lg-none" id="mobileCart">
        <a onclick="goToCart();" class="btn btn-primary d-flex justify-content-between mobileCart">
            <div>
                Tu pedido <span class="badge badge-light ml-1" id="mobileCart-items">{{Cart::getTotalQuantity()}} items</span>
            </div>
            <div>
                <span id="mobileCart-price">${{Cart::getTotal()}}</span>
            </div>
        </a>
    </div>
    @endif
</div>


@section('js-scripts-carrito')

    <script>

        $(document).ready(function() {

            $(window).on('resize scroll', function() {
                if ($('#cart-content').isInViewport()) {
                    $('#mobileCart').fadeOut(300);
                } else {
                    $('#mobileCart').fadeIn(300);
                }
            });

            $.fn.isInViewport = function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();

                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();

                return elementBottom > viewportTop && elementTop < viewportBottom;
            };

            cartFormat();
        });
        

        function cartFormat(){
            var checkboxDelivery = $('#checkboxDelivery');
            var checkboxPickup = $('#checkboxPickup');
            var restaurant = restaurant;

            if(checkboxDelivery.prop('checked')){
                $('#cart-delivery-info').show();
            }else if(checkboxPickup.prop('checked')){
                $('#cart-delivery-info').hide();
            }

            if($('#cart-empty-true').length){
                $('#cart-not-empty').hide();
                $('#cart-empty').show();
                $('#checkout-finish-order').attr('disable', 'disable');
                $("#mobileCart").hide();
            }else if($('#cart-empty-false').length){
                $('#cart-not-empty').show();
                $('#cart-empty').hide();
                $('#checkout-finish-order').removeAttr('disable', 'disable');
                $("#mobileCart").show();
            }
        }

        function removeItem(id){
            $.ajax({
                url : '/carrito/remove',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{id:id},
                success:function(data){
                    if(data['items']==0){
                        $('#cart-not-empty').fadeOut(200);
                        $('#cart-empty').fadeIn(200);
                        $('#cart-total-quantity').html(data['items']);
                        $('#checkout-finish-order').prop('disabled', true);
                        $('#finishOrder').hide();
                        $('#mobileCart').remove();
                    }else{
                        $('#item-'+id).fadeOut(100, function() { $(this).remove(); });
                        $('#cart-subtotal').fadeOut(100);
                        $('#cart-total').fadeOut(100);
                        $('#mobileCart-items').fadeOut(200);
                        $('#mobileCart-price').fadeOut(200);
                        $('#checkout-finish-order').prop('disable', true);
                        setTimeout(function(){ 
                            $('#cart-subtotal').html('$'+data['subtotal']).fadeIn(200);
                            $('#cart-total').html('$'+data['total']).fadeIn(200);
                            $('#cart-total-quantity').html(data['items']).fadeIn(200);
                            $('#mobileCart-items').html(data['items']+' items').fadeIn(200);
                            $('#mobileCart-price').html('$'+data['total']).fadeIn(200);
                        }, 100);
                    }
                },
                error:function(data){
                    $('#cart-data').html(data);
                    $('.cart-message').delay(2000).fadeOut();
                }
            });
        }

        function updateItemQuantity(id){
            var quantity = parseInt($('#cart-update-quantity-'+id+' option:selected').val());
            $.ajax({
                url : '/carrito/'+id,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{quantity:quantity},
                success:function(data){
                    $('#cart-item-'+id+'-price').fadeOut(100);
                    $('#cart-subtotal').fadeOut(100);
                    $('#cart-total').fadeOut(100);
                    $('#cart-total-quantity').fadeOut(200);
                    $('#mobileCart-items').fadeOut(200);
                    $('#mobileCart-price').fadeOut(200);
                    setTimeout(function(){ 
                        $('#cart-item-'+id+'-price').html('$'+data['itemPrice']*quantity).fadeIn(200);
                        $('#cart-subtotal').html('$'+data['subtotal']).fadeIn(200);
                        $('#cart-total').html('$'+data['total']).fadeIn(200);
                        $('#cart-total-quantity').html(data['items']).fadeIn(200);
                        $('#mobileCart-items').html(data['items']+' items').fadeIn(200);
                        $('#mobileCart-price').html('$'+data['total']).fadeIn(200);
                    }, 0);
                },
                error:function(data){
                    $('#cart-data').html('<div class="alert alert-warning cart-message px-4 py-1"><small>'+data+'</small></div>');
                    $('.cart-message').delay(2000).fadeOut();
                }
            });
        }

        function updateTax(restaurant){

            var checkboxDelivery = $('#checkboxDelivery');
            var checkboxPickup = $('#checkboxPickup');
            var restaurant = restaurant;

            if(checkboxDelivery.prop('checked')){
                var shipping_method = 'delivery';
            }else if(checkboxPickup.prop('checked')){
                var shipping_method = 'pickup';
            }

            $.ajax({
                url : '{{ route("cart.deliveryTax") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{restaurant:restaurant,shipping_method:shipping_method},
                success:function(data){

                    if(shipping_method=='delivery'){
                        $('#cart-delivery-info').fadeIn(200);
                        $('#checkout-delivery-info').fadeIn(200);
                        $('.shipping_method_text').text('Delivery');
                        $('#cart-data').html(data);
                        $('#cart-subtotal').fadeOut(100);
                        $('#cart-total').fadeOut(100);
                        $('#cart-total-quantity').fadeOut(200);
                        $('#mobileCart-price').fadeOut(200);
                        setTimeout(function(){ 
                            $('#cart-subtotal').html('$'+data['subtotal']).fadeIn(200);
                            $('#cart-total').html('$'+data['total']).fadeIn(200);
                            $('#mobileCart-price').html('$'+data['total']).fadeIn(200);
                        }, 100);
                    }else{
                        $('#cart-delivery-info').fadeOut(300);
                        $('#checkout-delivery-info').fadeOut(300);
                        $('.shipping_method_text').text('Retiro en local');
                        $('#mobileCart-price').fadeOut(200);
                        setTimeout(function(){ 
                            $('#cart-subtotal').html('$'+data['subtotal']).fadeIn(200);
                            $('#cart-total').html('$'+data['total']).fadeIn(200);
                            $('#mobileCart-price').html('$'+data['total']).fadeIn(200);
                        }, 100);
                    }
                },
                error:function(data){
                    $.each(data.responseJSON.errors, function(key,value) {
                        $('#cart-data').append('<div class="message-error alert alert-danger">'+value+'</div>');
                    });
                }
            });
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
                }
            });
        }

        function confirmAlert(){
            alert = document.getElementById("confirmEmptyCart");
            button = document.getElementById("btnConfirmEmptyCart");

            if ($('#confirmEmptyCart').is(':hidden')) {
                alert.removeAttribute("hidden","");
                button.setAttribute("hidden","");
            }else{
                alert.setAttribute("hidden","");
                button.removeAttribute("hidden","");    
            }
        }

        function emptyCart(restaurant){
            $.ajax({
                url : '/carrito/vaciar',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{restaurant:restaurant},
                success:function(data){
                    $('#cart-content').html(data);
                    cartFormat();
                    $('#finishOrder').hide();
                    $('#checkout-finish-order').prop('disabled', true);
                }
            });
        }

    </script>
@endsection