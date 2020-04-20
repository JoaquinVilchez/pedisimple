@extends('layouts.admin')

@section('main')
<form action="{{route('restaurant.update', $restaurant->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
        <h1 class="h2"><strong>Horarios de apertura</strong></h1>
        <div class="btn-toolbar mb-2 mb-md-0 ml-5">
        <a href="{{route('restaurant.info')}}" class="btn btn-secondary mr-2">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>

    <table class="table mt-3">
        @foreach($days as $day)
            <tr style="text-align:center" class="mb-4">
                <td width="4%"><input type="checkbox"></td>
                <td width="10%">{{$day->getDayName()}}</td>
                <td width="10%">
                <input type="time" class="form-control" placeholder="Abre" value="{{$day->start_hour_1}}">
                </td>
                <td width="5%">a</td>
                <td width="10%">
                    <input type="time" class="form-control" placeholder="Cierra" value="{{$day->end_hour_1}}">
                </td>
                <td width="5%">/</td>
                <td width="10%">
                    <input type="time" class="form-control" placeholder="Abre" value="{{$day->start_hour_2}}">
                </td>
                <td width="5%">a</td>
                <td width="10%">
                    <input type="time" class="form-control" placeholder="Cierra" value="{{$day->end_hour_2}}">
                </td>
                <td width="100%"></td>
            </tr>
        @endforeach
    </table>
</form>
</div>    
@endsection

@section('js-scripts')
<script type="text/javascript">
    $(function () {
        $('#datetimepicker3').datetimepicker({
            format: 'LT',
            date: false
        });
    });
</script>
@endsection


