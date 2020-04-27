@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="text-align: center">
        <div class="col-md-8">
        <img src="{{asset('images/logo.png')}}" alt="" width="300px" class="mt-5 mb-3">
            <hr>    
        <h4 class="txt-bold">¡Bienvenido {{Auth::user()->first_name}}!</h4>
                <h6>Ahora podés:</h6>

                <div class="container">

                    <a href="{{route('user.index')}}" type="button" class="btn btn-outline-image d-block my-4">
                        <img src="{{asset('images/design/chef.svg')}}" alt="" width="100px">
                        <h6 class="txt-bold m-2 d-inline-xl d-block-sm ml-4">Configurar mis datos</h6>
                    </a>
                    
                    @if(Auth::user()->type=='merchant')
                    <a href="{{route('restaurant.create')}}" type="button" class="btn btn-outline-image d-block my-4">
                        <img src="{{asset('images/design/shop.svg')}}" alt="" width="100px">
                        <h6 class="txt-bold m-2 d-inline-xl d-block-sm ml-4">Configurar mi comercio</h6>
                    </a>    
                    @endif
                </div>
                
        </div>
    </div>
</div>
@endsection
