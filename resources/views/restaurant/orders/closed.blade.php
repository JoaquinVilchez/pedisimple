@extends('layouts.commerce')

@section('css-scripts')
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-4">
        <h1 class="h2"><strong>Pedidos cerrados</strong></h1>
    </div>

    @include('messages')
    @if($orders->count()>0)
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Total</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{$order->code}}</td>
                    <td>{{ucfirst($order->created_at->calendar())}}</td>
                    <td>${{$order->total}}</td>
                    <td><a class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#orderDetailsModal" onclick="showClosedOrder({{$order->id}})">Detalle</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align:center" class="m-auto">
            <img src="{{asset('images/design/complete.svg')}}" alt="" class="img-default my-2">
            <p>No tienes pedidos aceptados.<br>
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