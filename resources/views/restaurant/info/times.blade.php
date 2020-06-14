@extends('layouts.commerce')

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="h2"><strong>Horarios de apertura</strong></h1>
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
                <tr class="mb-4">
                    <td style="text-align:center" width="10%"><span class="mr-2">Abierto</span><input type="checkbox" @if(is_array($day)) name="state_{{$day['weekday']}}" @else name="state_{{$day}}" @endif @if($day['state']=='open') checked @endif></td>
                    <td width="10%">
                        {{getDayName($day)}}
                    </td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Abre" 
                            @if(is_array($day)) 
                                value="{{old('start_hour_1_'.$day['weekday'], $day['start_hour_1'])}}" 
                                name="start_hour_1_{{$day['weekday']}}" 
                            @else 
                                value="{{old('start_hour_1_'.$day, $day['start_hour_1'])}}" 
                                name="start_hour_1_{{$day}}" 
                            @endif
                            >
                    </td>
                    <td width="5%">a</td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Cierra" 
                            @if(is_array($day)) 
                                value="{{old('end_hour_1_'.$day['weekday'], $day['end_hour_1'])}}" 
                                name="end_hour_1_{{$day['weekday']}}" 
                            @else 
                                value="{{old('end_hour_1_'.$day, $day['end_hour_1'])}}" 
                                name="end_hour_1_{{$day}}" 
                            @endif
                            >
                    </td>
                    <td width="5%">|</td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Abre" 
                            @if(is_array($day)) 
                                value="{{old('start_hour_2_'.$day['weekday'], $day['start_hour_2'])}}" 
                                name="start_hour_2_{{$day['weekday']}}" 
                            @else 
                                value="{{old('start_hour_2_'.$day, $day['start_hour_2'])}}" 
                                name="start_hour_2_{{$day}}" 
                            @endif
                            >
                    </td>
                    <td width="5%">a</td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Cierra"                             
                            @if(is_array($day)) 
                                value="{{old('end_hour_2_'.$day['weekday'], $day['end_hour_2'])}}" 
                                name="end_hour_2_{{$day['weekday']}}" 
                            @else 
                                value="{{old('end_hour_2_'.$day, $day['end_hour_2'])}}" 
                                name="end_hour_2_{{$day}}" 
                            @endif
                            >
                    </td>
                </tr>
            @endforeach
        </table>
        </form>
</div>    
@endsection



