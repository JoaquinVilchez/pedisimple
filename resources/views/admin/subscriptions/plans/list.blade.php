@extends('layouts.admin')

@section('main')
        <div class="row mt-4">
            <div class="container-fluid d-flex flex-wrap">

            @include('messages')

            @foreach ($plans as $plan)
                <div class="card m-2" style="width: 18rem; text-align:center; min-height:250px">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="card-body">
                        <h3 class="card-title txt-bold">{{$plan->name}}</h3>
                        <h4 class="card-subtitle mb-2 text-muted txt-bold">${{$plan->price}}</h4>
                            <div class="features mb-3">
                                <p class="card-text m-0">
                                    @switch($plan->invoice_period)
                                        @case(1)
                                            -Mensual
                                            @break
                                        @case(3)
                                            -Trimestral
                                            @break
                                        @case(6)
                                            -Semestral
                                            @break
                                        @case(12)
                                            -Anual
                                        @break
                                    @endswitch
                                </p>
                                <p class="card-text m-0">-Días gratis: {{$plan->trial_period}} </p>
                                <p class="card-text m-0">-Días de gracia: {{$plan->grace_period}}</p>
                            </div>
                        <a href="{{route('plan.edit', $plan->id)}}" class="card-link"><i class="fas fa-edit"></i> Editar</a>
                        <a href="#" data-planid="{{$plan->id}}" class="card-link" data-toggle="modal" data-target="#deletePlanModal"><i class="fas fa-trash"></i> Eliminar</a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="card m-2" style="width: 18rem; text-align:center; min-height:250px">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <a href="{{route('plan.create')}}" style="font-size: 5em; color: #c1c1c1">
                        <i class="fas fa-plus-circle"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deletePlanModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="text-align:center">
                <img src="{{asset('storage/design/alarm.svg')}}" width="70px" class="my-2" alt="">
                <h5 class="modal-title txt-bold">¡Cuidado!</h5>
                <form action="{{route('plan.destroy')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h5>¡Estás a punto de eliminar un plan!</h5>
                        <p style="font-size: .85em">Si hay comercios suscritos a este plan, se eliminarán dichas suscripciones.<br>
                        ¿Estás seguro de realizar esta acción?</p>
                        <input name="planid" type="hidden" id="planid" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Sí, estoy seguro</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

@endsection

@section('js-scripts')
<script>

    $('#deletePlanModal').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)

        var planid = button.data('planid')
        var modal = $(this)

        modal.find('.modal-body #planid').val(planid)
    })

</script>
@endsection
