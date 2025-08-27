@extends('layouts.commerce')

@section('css-scripts')
@endsection

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom mb-4">
        <h1 class="h2"><strong>Pedidos cerrados</strong></h1>
        <div class="mb-2" style="font-size: .8em;">
            <i class="fas fa-question-circle"></i> ¿Tenés dudas? <a target="_autoblank" href="{{route('help.documentation')}}#docs-pedidos" class="txt-semi-bold">Consultar documentación</a>.
        </div>
    </div>

    @include('messages')
    @if($orders->count()>0)
    <div class="table-responsive table-hover">
        <table class="table table-sm ">
            <thead>
            <tr>
                <th>Código</th>
                <th>Solicitante</th>
                <th>Total</th>
                <th>Fecha</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{$order->code}}</td>
                    <td>{{$order->getFullName()}}</td>
                    <td>${{formatPrice($order->total)}}</td>
                    <td>{{ucfirst($order->created_at->calendar())}}</td>
                    <td><a class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#orderDetailsModal" onclick="showClosedOrder({{$order->id}})">Detalle</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$orders->links()}}
    </div>
    @else
        <div style="text-align:center" class="m-auto">
            <i class="fas fa-check-circle fa-4x text-success my-2"></i>
            <p>No tienes pedidos cerrados.</p>
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
            <div class="d-flex justify-content-center">
                <i class="fas fa-spinner fa-spin fa-4x text-primary"></i>
                <p>Procesando...</p>
            </div>
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
        async: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data:{id:id},
        success:function(data){
            $('#detail-closed-order-modal').html(data)
        },
        error:function(data){
            console.log(data);
        }
    });
}

</script>
@endsection