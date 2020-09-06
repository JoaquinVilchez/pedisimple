<style>
#order-itemsTable tr td{
    padding: 5px 10px;
}
#order-itemsTable tr{
    min-width: 100%;
}
</style>

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Editar pedido</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{route('order.updateOrder')}}" method="POST" id="order-form">
    @csrf
<div class="modal-body">
<div class="container">
    <div style="text-align:center">
        <h4>Código: {{$order->code}}</h4>
        <p class="text-muted">Solicitante: {{$order->getFullName()}}</p>
        <div class="col-12 m-auto col-md-4">
            <select class="custom-select mr-sm-2" id="order-shippingmethod" name="shippingmethod">
                <option value="delivery" @if($order->shipping_method=='delivery') selected @endif>Delivery</option>
                <option value="pickup" @if($order->shipping_method=='pickup') selected @endif>Retiro en local</option>
            </select>
        </div>
    </div>
    <div id="order-address">
        <div class="d-flex justify-content-center mt-1">
            <div class="col-12 col-md-10">
                <div class="form-group">
                    
                    <div class="row">
                        <div class="mx-auto">
                            <small>Nueva dirección de envío</small>
                        </div>
                    </div>
                    <div class="row border rounded p-4">
                        <div class="col-12 col-md-5 px-1">
                            <input type="text" id="order-streetInput" class="form-control form-control-sm" name="street" value="{{old('street')}}" autocomplete="off">
                            <small id="order-streetInput" class="form-text text-muted">Calle</small>
                            {!!$errors->first('street', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        </div>
                        <div class="col-6 col-md-2 px-1">
                            <input type="text" id="order-numberInput" class="form-control form-control-sm" name="number" value="{{old('number')}}" autocomplete="off">
                            <small id="order-numberInput" class="form-text text-muted">Número</small>
                            {!!$errors->first('number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                        </div>
                        <div class="col-6 col-md-4 pl-1 pr-0">
                            <div class="input-group">
                                <input type="text" id="order-floorInput" name="floor" value="{{old('floor')}}" class="form-control form-control-sm" autocomplete="off">
                                <input type="text" id="order-departmentInput" name="department" value="{{old('department')}}" class="form-control form-control-sm" autocomplete="off">
                            </div>
                            <small id="order-floorInput" class="form-text text-muted">Piso/Depto</small>
                            {!!$errors->first('number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}
                            {!!$errors->first('number', '<small style="color:red"><i class="fas fa-exclamation-circle"></i> :message</small>') !!}  
                        </div>
                        <div class="col-12 col-md-1 pl-md-1">
                            <button type="button" id="order-buttonSubmit" class="btn btn-sm btn-outline-success d-none d-md-block d-lg-block"><i class="far fa-check-circle"></i></button>
                        </div>
                    </div>
                    <div class="row" id="order-alert">
                        <div class="mx-auto" style="text-align: center">
                            <small id="order-msg"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h6 class="txt-muted order-title mb-2">Productos pedidos</h6>
        <div class="col-12">
            <table class="table table-sm m-auto" id="order-itemsTable">
                <thead>
                    <th width="60%">Producto</th>
                    <th width="15%">Cantidad</th>
                    <th width="15%">Precio</th>
                    <th width="10%"></th>
                </thead>
                <tbody>
                    @foreach($order->lineItems as $item)
                    <div hidden>{{$item->product->name}}</div>
                    @endforeach
                </tbody>
            </table>
            <div class="container row mt-2">
                <a href="#" id="order-addproductlink" style="color: rgb(3, 193, 3)"><i class="fas fa-plus-circle"></i><span class="text-muted"><small>Agregar producto</small></span></a>
            </div>
            <div id="order-addProductForm" class="border mt-2" >
                <a href="#" id="order-closeProductLink"><i style="position: relative; float:right; z-index:1; top: 0px; right: 0px;" class="fas fa-times m-1"></i></a>
                <div class="container p-3">
                    <form>
                        <div class="form-row align-items-center">
                            <div class="row" style="text-align: center">
                                <div class="col-12 col-sm-6 col-md-5">
                                    <select class="selectpicker" id="addItem-select" data-live-search="true" title="Seleccione un producto" style="width: 100%">
                                        @foreach ($order->restaurant->availableProducts() as $product)
                                    <option value="{{$product->id}}" data-variants="{{$product->variants}}" data-name="{{$product->name}}" data-price="{{formatPrice($product->price)}}" data-maximumvariants="{{$product->maximum_variants}}">{{$product->name}}</option>                                    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2">
                                    <div class="input-group my-1">
                                    <input type="number" class="form-control" id="addItem-quantity" placeholder="Cantidad" onchange="changeItemPrice()" min="1">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2"> 
                                <span class="form-control my-1" id="addItem-price">$0</span>
                                </div>
                                <div class="col-12 col-sm-12 col-md-2">
                                    <button type="button" class="btn btn-primary btn-block my-1" id="addItem-button">Agregar</button>
                                </div>
                            </div>
                            <div class="row mt-2" id="variants">
                                <div class="col-12">
                                    <select class="selectpicker" width="auto" id="selectVariants" title="Seleccione variantes" data-live-search="true" multiple>
                                        @foreach ($order->restaurant->variants as $variant)
                                            <option value="{{$variant->id}}">{{$variant->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div style="text-align: center">
            <hr>
            <h6 class="text-muted" id="delivery"></h6>
            <h4 id="total"></h4>
            <div id="data"></div>
        </div>
</div>  
    </div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary" id="order-submit">Confirmar</button>
</form>
</div>

<script>
    var items = [];
    var order = '';

    $(document).ready(function(){
        $('#order-addProductForm').hide();
        $('#variantsRow').selectpicker();
        $('.selectpicker').selectpicker();
        $('#variants').hide();
        $('#order-address').hide();
        $('#order-msg').hide();
        $('#addItem-button').prop('disabled', true);
        
        
        var full_order = @json($order);
        var full_items = @json($order->lineItems);
        for(var i in full_items) {
            var id = generateId();
            var item = {
                id:id,
                order_id:full_items[i].order_id,
                product_id:full_items[i].product_id,
                name:full_items[i].product.name,
                price:full_items[i].product.price,
                quantity:full_items[i].quantity,
                variants:full_items[i].variants,
                aditional_notes:full_items[i].aditional_notes,
                maximum_variants:full_items[i].product.maximum_variants
            }   
            items.push(item);
            addRow(item);
        }
        
        $('#variantsInputRow').hide();

        order = {
            id:full_order.id,
            code:full_order.code,
            shipping_method:full_order.shipping_method,
            delivery:full_order.restaurant.shipping_price,
            street:null,
            number:null,
            floor:null,
            department:null,
            subtotal:full_order.subtotal,
            total:full_order.total,
            items:items
        }
                
        showTotalPrice(items,order);

        $('#order-addproductlink').on('click', function(){
            $('#order-addProductForm').fadeIn(600);
            $('#order-addproductlink').hide();
        })

        $('#order-closeProductLink').on('click', function(){
            $('#order-addproductlink').show();
            $('#order-addProductForm').hide();
            $('#addItem-select').selectpicker('val', '');
            $('#addItem-quantity').val('');
            $('#addItem-price').text('$0.00');
        })

        $('#addItem-select').on('change', function(){
            var dataprice = $('#addItem-select option:selected').attr('data-price');
            var dataid = $('#addItem-select option:selected').val();
            var maximum_variants = parseInt($('#addItem-select option:selected').attr('data-maximumvariants'));
            $('#selectVariants').attr('data-max-options', maximum_variants);
            $('#addItem-quantity').val(1);
            $('#addItem-price').text('$'+dataprice);
            if($('#addItem-select option:selected').attr('data-variants')==1){
                $('#variants').show();
            }else{
                $('#variants').hide();
            }
            $('#addItem-button').prop('disabled', false);
        });

        $('#addItem-quantity').on('change', function(){
            var element = $('#addItem-quantity').val();
            if (element==0) {
                $('#addItem-button').prop('disabled', true);
            }else{
                $('#addItem-button').prop('disabled', false);
            }
        });

        $('#addItem-button').on('click', function(){
            var product_id = parseInt($('#addItem-select option:selected').val());
            var name = $('#addItem-select option:selected').attr('data-name');
            var quantity = parseInt($('#addItem-quantity').val());
            var price = parseFloat($('#addItem-select option:selected').attr('data-price'));
            var maximum_variants = parseInt($('#addItem-select option:selected').attr('data-maximumvariants'));
            var id = generateId();
            var variants = $('#selectVariants').selectpicker('val');
            if (variants.length==0) {
               variants = null; 
            }
            var item = {
                id:id,
                order_id:order.id,
                product_id:product_id,
                name:name,
                price:price,
                quantity:quantity,
                variants:variants,
                aditional_notes:null,
                maximum_variants:maximum_variants
            } 
            order.items.push(item);
            $('#order-addProductForm').fadeOut(300);
            $('#order-addproductlink').show();    
            $('#product').val('');
            $('#addItem-select').selectpicker('val', '');
            $('#addItem-quantity').val('');
            $('#addItem-price').text('$0.00');
            addRow(item);
            showTotalPrice(items,order);
        });

        $('#order-shippingmethod').on('change', function(){
            changeShippingMethod(items, order);
            if($('#order-shippingmethod option:selected').val()=='delivery'){
                if(((full_order.address_id == null) || (full_order.address_id == '')) && ((full_order.guest_street == null && full_order.guest_number == null) || (full_order.guest_street == '' && full_order.guest_number == ''))){
                    $('#order-address').fadeIn(500);
                    if((order.street==null && order.number==null) || (order.street=='' && order.number=='')){
                        
                        $('#order-streetInput').on('change', function(){
                            order.street=$('#order-streetInput').val();
                        });
                        $('#order-numberInput').on('change', function(){
                            order.number=$('#order-numberInput').val();
                        });
                        $('#order-floorInput').on('change', function(){
                            order.floor=$('#order-floorInput').val()
                        });
                        $('#order-departmentInput').on('change', function(){
                            order.department=$('#order-departmentInput').val();
                        });

                        $('#order-buttonSubmit').on('click', function(){
                            if($('#order-streetInput').val() == '' && $('#order-numberInput').val() == ''){
                                $('#order-msg').attr('style',"color: #c41111");
                                $('#order-msg').text('Los campos calle y número son obligatorios');
                                $('#order-alert').fadeIn(400);
                                $('#order-alert').fadeOut(3000);
                                console.log(order);
                            }else{
                                order.street=$('#order-streetInput').val();
                                order.number=$('#order-numberInput').val();
                                order.floor=$('#order-floorInput').val();
                                order.department=$('#order-departmentInput').val();
                                $('#order-msg').attr('style',"color: #009a1a");
                                $('#order-msg').text('Dirección registrada con éxito');
                                $('#order-buttonSubmit').removeClass('btn-outline-success');
                                $('#order-buttonSubmit').addClass('btn-success');
                                $('#order-alert').fadeIn(400);
                                $('#order-alert').fadeOut(3000);
                            }
                        });
                    }else{
                        $('#order-streetInput').text(order.street);
                        $('#order-numberInput').text(order.number);
                        $('#order-floorInput').text(order.floor);
                        $('#order-departmentInput').text(order.department);
                    }
                }
            }else{
                $('#order-address').fadeOut(300);
            }
        });

        $('#variantsInputLink').on('click', function(){
            $('#variantsInputRow').show();
        });

        $('#order-submit').on('click', function(){
            $.ajax({
                url:"{{ route('order.updateOrder') }}",
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data:{order:order},
                success:function(data) {
                    alert = '<div class="alert alert-success mt-2" role="alert">El pedido se ha editado con éxito.</div>';
                    $('#data').html(alert);
                    window.location.href = "{{ route('order.accepted')}}";              
                },
                error: function(data) {
                    $.each(data.responseJSON.errors, function(key,value) {
                        $('#data').append('<div class="message-error alert alert-danger">'+value+'</div>');
                    });

                    setTimeout(function() {
                        $(".message-error").remove();
                    }, 5000);
                }
            })
        });
    });

    function changeShippingMethod(items, order){
        if($('#order-shippingmethod option:selected').val() == 'delivery'){
            order.shipping_method = 'delivery';        
        }else{
            order.shipping_method = 'pickup';        
        }
        
        showTotalPrice(items,order);
    }

    function generateId(){
        var id = Math.floor(1000 + Math.random() * 9000);
        return id;
    }

    function changeItemPrice(){
        if($('#addItem-select option:selected').attr('data-price')==null){
            var price = 0;
        }else{
            var price = $('#addItem-select option:selected').attr('data-price');
        }
        var quantity = $('#addItem-quantity').val();
        $('#addItem-price').text('$'+quantity*price)
    }

    function showVariantsInput(id){
        var element = document.getElementById('variants-input-'+id);
        var select = $('#variants-select-'+id);
        var item = '';
        items.forEach(function(currentValue, index, arr){
            if(items[index].id==id){
                item = items[index];
            }   
        })
        select.selectpicker('val', item.variants);
        select.selectpicker();
        select.on('change', function(){
            item.variants=select.selectpicker('val');
        })
        if(element.hasAttribute('hidden')){
            element.removeAttribute('hidden');
        }else{
            element.setAttribute('hidden','');
        }
    }

    function showTotalPrice(items, order){
        var subtotal = 0;
        for(var j in items) {
            subtotal = subtotal + (parseInt(items[j].quantity)*parseInt(items[j].price))
        }
        delivery = parseInt(order.delivery);
        if(order.shipping_method=='delivery'){
            total = subtotal + delivery;
            $('#delivery').show();
            $('#delivery').text('Delivery: $'+delivery)
            $('#total').text('Total: $'+total)
        }else{
            total = subtotal;
            $('#delivery').hide();
            $('#total').text('Total: $'+total)
        }
        order.delivery=parseInt(delivery);
        order.subtotal=parseInt(subtotal);
        order.total=parseInt(total);
    }

    function addRow(item){
        if(item.variants==null){
            var VARIANTS_LINK = '';
            var VARIANTS_INPUT = '';
        }else{
            var VARIANTS_LINK = '<div class="row ml-1"><small style="font-size:12px"><a onclick="showVariantsInput('+item.id+')" id="variants-link-'+item.id+'" href="#">Variantes</a></small></div>'
            var VARIANTS_INPUT = '<div class="row ml-1" id="variants-input-'+item.id+'" hidden><div class="col-12"><select class="form-control form-control-sm" width="auto" id="variants-select-'+item.id+'" title="Seleccione variantes" data-live-search="true" multiple data-max-options="'+item.maximum_variants+'">@foreach ($order->restaurant->variants as $variant)<option value="{{$variant->id}}">{{$variant->name}}</option>@endforeach</select></div></div>'
        }
        var ROW = '<td><div class="row mt-2">'+item.name+'</div>'+VARIANTS_LINK+VARIANTS_INPUT+'</td><td><input onchange="updateRowPrice('+item.id+')" id="item-quantity-'+item.id+'" type="number" min="1" value="'+item.quantity+'" style="border:1px solid #efefef; padding: 0px; width: 50px; text-align:center"></td><td id="item-price-'+item.id+'">$'+item.quantity*item.price+'</td><td><a class="delete-item" onclick="deleteRow('+item.id+')" href="#" style="color: red"><i class="fas fa-times-circle"></i></a></td>';
        var HTML = '<tr data-id="'+item.id+'">'+ROW+'</tr>';
        $('#order-itemsTable').append(HTML);
    }

    function deleteRow(id){
        items.forEach(function(currentValue, index, arr){
            if(items[index].id==id){
                items.splice(index, 1);  
                $('#order-itemsTable').find("[data-id='"+id+"']").remove();   
            }
        })
        showTotalPrice(items, order);
    }

    function updateRowPrice(id){
        var quantity = $('#item-quantity-'+id).val();
        items.forEach(function(currentValue, index, arr){
            if(items[index].id==id){
                items[index].quantity = parseInt(quantity);
                var total = parseInt(quantity)*parseInt(items[index].price)
                $('#item-price-'+id).text('$'+total);
            }   
        })
        showTotalPrice(items, order);
    }

</script>