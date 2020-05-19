@extends('layouts.commerce')

@section('main')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="h2"><strong>Horarios de apertura</strong></h1>
        <div class="btn-toolbar mb-2 mb-md-0 ml-5">
        </div>
    </div>

    <table class="table mt-3 table-responsive" style="text-align: center">
            <td>Día hábil</td>
            <td>Abierto/Cerrado</td>
            <td>Apertura</td>
            <td></td>
            <td>Cierre</td>
            <td></td>
            <td>Apertura</td>
            <td></td>
            <td>Cierre</td>
            <td></td>
        @foreach($schedule as $day)
            @if(is_array($day))
            <form action="{{route('restaurant.times.update')}}" method="post">
                @csrf
                @method('PUT')
                <tr class="mb-4">
                    <td width="10%">
                        <strong>{{getDayName($day)}}</strong>
                        <input type="text" value="{{$day['id']}}" name="id" hidden>
                    </td>
                    <td style="text-align:center" width="10%"><span class="mr-2">Abierto</span><input type="checkbox" name="state" @if($day['state']=='open') checked @endif></td>
                    <td width="10%">
                    <input type="time" class="form-control" placeholder="Abre" value="{{$day['start_hour_1']}}"  name="start_hour_1">
                    </td>
                    <td width="5%">a</td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Cierra" value="{{$day['end_hour_1']}}" name="end_hour_1">
                    </td>
                    <td width="5%">|</td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Abre" value="{{$day['start_hour_2']}}" name="start_hour_2">
                    </td>
                    <td width="5%">a</td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Cierra" value="{{$day['end_hour_2']}}" name="end_hour_2">
                    </td>
                    <td width="100%">
                        <button type="submit" class="float-left btn btn-sm mr-1 btn-primary">Actualizar</button>
                    </td>
                </tr>
            </form>
            @else
            <form action="{{route('restaurant.times.update')}}" method="post">
                @csrf
                @method('PUT')
                <tr class="mb-4">
                    <td width="10%">
                        <strong>{{getDayName($day)}}</strong>
                    </td>
                    <td style="text-align:center" width="10%"><span class="mr-2">Abierto</span><input type="checkbox" name="state"></td>
                    <input type="text" value="{{$day}}" name="weekday" hidden>
                    <td width="10%">
                    <input type="time" class="form-control" placeholder="Abre" value="" name="start_hour_1">
                    </td>
                    <td width="5%">a</td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Cierra" value="" name="end_hour_1">
                    </td>
                    <td width="5%">|</td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Abre" value="" name="start_hour_2">
                    </td>
                    <td width="5%">a</td>
                    <td width="10%">
                        <input type="time" class="form-control" placeholder="Cierra" value="" name="end_hour_2">
                    </td>
                    <td width="100%">
                        <button type="submit" class="float-left btn btn-sm mr-1 btn-primary">Actualizar</button>
                    </td>
                </tr>
            </form>
            @endif
        @endforeach
            <div class="mt-2">
                @include('messages')
                {{-- {{dd(array_sum($schedule))}} --}}
                @if (array_sum($schedule)==28)
                <div class="alert alert-primary" role="alert">
                    Ingrese y actualice cada un día.
                </div>
                @endif
            </div>
            @if($errors->any())
            <div class="alert alert-danger mt-2" role="alert">
                {!!$errors->first('start_hour_1', '<p><i class="fas fa-exclamation-circle"></i> :message</p>') !!}    
                {!!$errors->first('end_hour_1', '<p><i class="fas fa-exclamation-circle"></i> :message</p>') !!}  
                {!!$errors->first('start_hour_2', '<p><i class="fas fa-exclamation-circle"></i> :message</p>') !!}    
                {!!$errors->first('end_hour_2', '<p><i class="fas fa-exclamation-circle"></i> :message</p>') !!}  
              </div>
            @endif
    </table>
</div>    
@endsection



