@extends('layouts.app')

@section('css-scripts')
<style>
</style>
@endsection

@section('content')
    <section style="background-color: #FFC500; height: 83vh" class="d-flex justify-content-center align-items-center">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="my-2 txt-semi-bold">Configura tus horarios para continuar</h4>
                        <hr class="m-0">
                        <p class="mt-2">Para poder activar el servicio es obligatorio que configures los horarios de tu comercio.</p>
                        
                        <div class="row my-4">
                            <img data-original="{{asset('/storage/design/calendartimes.svg')}}" alt="" class="img-default m-auto">
                        </div>
        
                        <a class="btn btn-primary" href="{{route('restaurant.times')}}">Establecer horarios</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection