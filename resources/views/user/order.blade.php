@extends('layouts.user')

@section('css-scripts')
<style>
    .tile{
    width: 100%;
    background:#fff;
    border-radius:5px;
    box-shadow:0px 2px 3px -1px rgba(151, 171, 187, 0.7);
    float:left;
    transform-style: preserve-3d;
    margin: 10px 5px;

    }

    .header{
    border-bottom:1px solid #ebeff2;
    padding:19px 0;
    text-align:center;
    color:#59687f;
    font-size:600;
    font-size:19px;	
    position:relative;
    }

    .banner-img {
    padding: 5px 5px 0;
    }

    .banner-img img {
    width: 100%;
    border-radius: 5px;
    }

    .dates{
    border:1px solid #ebeff2;
    border-radius:5px;
    padding:10px 0px;
    margin:10px 20px;
    font-size:16px;
    color:#5aadef;
    font-weight:600;	
    overflow:auto;
    }
    .dates div{
    float:left;
    width:50%;
    text-align:center;
    position:relative;
    }
    .dates strong,
    .stats strong{
    display:block;
    color:#adb8c2;
    font-size:11px;
    font-weight:700;
    }
    .dates span{
    width:1px;
    height:40px;
    position:absolute;
    right:0;
    top:0;	
    background:#ebeff2;
    }
    .stats{
    border-top:1px solid #ebeff2;
    background:#f7f8fa;
    overflow:auto;
    padding:5px 0;
    font-size:16px;
    color:#59687f;
    font-weight:600;
    border-radius: 0 0 5px 5px;
    }
    .stats div{
    border-right:1px solid #ebeff2;
    width: 50%;
    float:left;
    text-align:center
    }

    .stats div:nth-of-type(3){border:none;}

    div.footer {
    text-align: right;
    position: relative;
    margin: 20px 5px;
    }

    div.footer a.Cbtn{
    padding: 10px 25px;
    background-color: #DADADA;
    color: #666;
    margin: 10px 2px;
    text-transform: uppercase;
    font-weight: bold;
    text-decoration: none;
    border-radius: 3px;
    }

    div.footer a.Cbtn-primary{
    background-color: #5AADF2;
    color: #FFF;
    }

    div.footer a.Cbtn-primary:hover{
    background-color: #7dbef5;
    }

    div.footer a.Cbtn-danger{
    background-color: #fc5a5a;
    color: #FFF;
    }

    div.footer a.Cbtn-danger:hover{
    background-color: #fd7676;
    }
</style>
@endsection

@section('info-content')

    <div class="tile">
        <div class="wrapper">
            <div class="header">Pedido a <strong>{{$order->restaurant->name}}</strong><br>
                <span class="{{$order->stateStyle()}}">{{ucwords($order->state)}}</span>
            </div>
        

            <div class="dates">
                <div class="start">
                    <strong>PEDIDO</strong> {{$order->ordered}}
                    <span></span>
                </div>
                <div class="ends">
                    <strong>ENTREGADO</strong> 
                    @if($order->shipped == null)
                    No entregado
                    @else
                    {{$order->shipped}}
                    @endif
                </div>
            </div>

            {{-- Item --}}
            <div class="stats">
                <div>Pizza Muzzarella 8 Porciones</div>
                <div>
                    <div>x1</div> 
                    <div>$182</div>
                </div>
            </div>
            {{-- Item --}}
            <div class="stats">
                {{-- Titulo --}}
                <div>Docena de empanadas</div>
                <div>
                    {{-- Cantidad --}}
                    <div>x1</div> 
                    {{-- Precio unitario --}}
                    <div>$125</div>
                </div>
            </div> 
            <div class="stats">
                    <div class="float-right">
                    <div>Total</div> 
                    {{-- Precio final --}}
                    <div>$225</div>
                    </div>
            </div>   

            <div class="footer">
                <a href="{{route('order.index')}}" class="Cbtn Cbtn-primary">Volver</a>
                <a href="#" class="Cbtn Cbtn-danger" @if($order->state=='pendiente') hidden @endif)>Repetir</a>
            </div>
        </div>
    </div> 
    </div>      

@endsection
