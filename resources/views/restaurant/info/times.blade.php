@extends('layouts.commerce')

@section('main')
<div class="d-flex justify-content-center">
    <div class="container">

            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 border-bottom">
                <h2><strong>Horarios de apertura</strong></h2>
                <div class="btn-toolbar mb-2 mb-md-0 ml-5">
                <form action="{{route('restaurant.times.update')}}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="float-left btn mr-1 btn-primary">Actualizar</button>
                </div>
            </div>

            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger mt-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                            <p><i class="fas fa-exclamation-circle"></i> {{$error}}</p>
                    </div>
                @endforeach
            @endif

            <div class="mt-2">
                @include('messages')
            </div>

            <div class="table-responsive">
                <table class="table mt-3" style="text-align: center">
                    <td>Abierto/Cerrado</td>
                    <td>Día hábil</td>
                    <td>Apertura</td>
                    <td></td>
                    <td>Cierre</td>
                    <td></td>
                    <td>Apertura</td>
                    <td></td>
                    <td>Cierre</td>
                    <td></td>
                    @foreach($schedule as $day)
                            @if (isset($day))
                                <tr class="mb-4" id="day-{{array_search($day,$schedule)}}">
                                    <td style="text-align:center" width="10%"><span class="mr-2">Abierto</span><input id="checkbox-{{array_search($day,$schedule)}}" onchange="checkDisableDay({{array_search($day,$schedule)}})" type="checkbox"
                                            @if(is_array($day)) name="state_{{$day['weekday']}}" @else name="state_{{$day}}" @endif
                                        @if(is_array($day))
                                            @if($day['state']=='open') checked @endif>
                                        @endif
                                    </td>
                                    <td width="10%">
                                        <strong>{{getDayName($day)}}</strong>
                                    </td>
                                    <td width="10%">
                                        <input type="text" class="form-control input-time" placeholder="Abre" id="input-1-day-{{array_search($day,$schedule)}}"
                                            @if(is_array($day))
                                                value="{{old('start_hour_1_'.$day['weekday'], $day['start_hour_1'])}}"
                                                name="start_hour_1_{{$day['weekday']}}"
                                            @else
                                                value="{{old('start_hour_1_'.$day)}}"
                                                name="start_hour_1_{{$day}}"
                                            @endif
                                        >
                                    </td>
                                    <td width="5%">a</td>
                                    <td width="10%">
                                        <input type="text" class="form-control input-time" placeholder="Cierra" id="input-2-day-{{array_search($day,$schedule)}}"
                                            @if(is_array($day))
                                                value="{{old('end_hour_1_'.$day['weekday'], $day['end_hour_1'])}}"
                                                name="end_hour_1_{{$day['weekday']}}"
                                            @else
                                                value="{{old('end_hour_1_'.$day)}}"
                                                name="end_hour_1_{{$day}}"
                                            @endif
                                        >
                                    </td>
                                    <td width="5%">|</td>
                                    <td width="10%">
                                        <input type="text" class="form-control input-time" placeholder="Abre" id="input-3-day-{{array_search($day,$schedule)}}"
                                            @if(is_array($day))
                                                value="{{old('start_hour_2_'.$day['weekday'], $day['start_hour_2'])}}"
                                                name="start_hour_2_{{$day['weekday']}}"
                                            @else
                                                value="{{old('start_hour_2_'.$day)}}"
                                                name="start_hour_2_{{$day}}"
                                            @endif
                                            >
                                    </td>
                                    <td width="5%">a</td>
                                    <td width="10%">
                                        <input type="text" class="form-control input-time" placeholder="Cierra" id="input-4-day-{{array_search($day,$schedule)}}"
                                            @if(is_array($day))
                                                value="{{old('end_hour_2_'.$day['weekday'], $day['end_hour_2'])}}"
                                                name="end_hour_2_{{$day['weekday']}}"
                                            @else
                                                value="{{old('end_hour_2_'.$day)}}"
                                                name="end_hour_2_{{$day}}"
                                            @endif
                                            >
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                </table>
            </div>
        </form>
    </div>
</div>
<hr>

<div class="alert alert-secondary mb-2" style="font-size: .8em; text-align:center" role="alert">
<i class="fas fa-question-circle"></i> ¿Tenés dudas? <a target="_autoblank" href="{{route('help.documentation')}}#docs-horarios-apertura" class="txt-semi-bold">Consultar documentación</a>.
</div>
@endsection

@section('js-scripts')
    <script>

        $('.input-time').toArray().forEach(function(field){
            new Cleave(field, {
                time: true,
                timePattern: ['h', 'm']
            });
        });

        $( document ).ready(function() {
            days = [0,1,2,3,4,5,6];
            days.forEach(day => {
                checkDisableDay(day)
            });
        });

        function checkDisableDay(day){
            dayelement = $('#day-'+day);
            var checkbox = $('#checkbox-'+day);

            if (checkbox.prop("checked")) {
                $('#input-1-day-'+day).prop('disabled', false);
                $('#input-2-day-'+day).prop('disabled', false);
                $('#input-3-day-'+day).prop('disabled', false);
                $('#input-4-day-'+day).prop('disabled', false);
            } else {
                $('#input-1-day-'+day).prop('disabled', true);
                $('#input-2-day-'+day).prop('disabled', true);
                $('#input-3-day-'+day).prop('disabled', true);
                $('#input-4-day-'+day).prop('disabled', true);
            }
        }

    </script>
@endsection