@extends('layouts.user')

@section('info-content')

    <h5>Mis pedidos</h5>
    @if(count($orders)>0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <th>Comercio</th>
                <th>Fecha de pedido</th>
                <th>Estado</th>
                <th>Importe</th>
                <th>Detalle</th>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->restaurant->name}} 
                        <a target=”_blank” class="ml-2" href="https://wa.me/549{{str_replace('-', '', $order->restaurant->getPhone())}}"><i class="fab fa-whatsapp"></i></a>
                    </td>
                    <td><small>{{$order->ordered}}</small></td>
                    <td><span class="{{$order->stateStyle()}}">{{$order->stateLang()}}</span></td>
                    <td>$ {{$order->total}}</td>
                    <td><a href="" data-toggle="modal" data-target="#orderDetailsModal" onclick="showClosedOrder({{$order->id}})">Ver pedido</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        {{$orders->links()}}
    @else
        <div style="text-align:center" class="m-auto">
            <img src="{{asset('images/design/basket.svg')}}" alt="" class="img-default my-2">
            <p>Aún no tienes pedidos.<br>
            <a href="{{route('list.index')}}" class="btn btn-sm btn-primary mt-2">Hacer un pedido</a>
        </div>  
    @endif

<!-- Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel">Resumen de pedido</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="detail-closed-order-modal">
            
        </div>
      </div>
    </div>
</div>

@endsection

@section('js-scripts')
<script>

function showClosedOrder(id){
    $.ajax({
        url : '{{ route("order.closedDetails") }}',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data:{id:id},
        success:function(data){
            $('#detail-closed-order-modal').html(data)
        },
    });
}

</script>
@endsection
