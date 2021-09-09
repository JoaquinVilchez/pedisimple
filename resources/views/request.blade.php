@extends('layouts.app')
@section('content')
@if (session('success_message'))
<div class="alert alert-success rounded-0 my-0 text-center" role="alert">
  ¡Gracias! La solicitud fue enviada con éxito.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@elseif (session('error_message'))
<div class="alert alert-danger rounded-0 my-0 text-center" role="alert">
  ¡Hubo un problema! No pudimos enviar la solicitud, por favor intente de nuevo.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<section class="position-relative">
  <img src="{{asset('storage/design/commerce-request/background.svg')}}" class="background" alt="">
  <div class="container">
    <div class="row header d-flex justify-content-center position-relative">
      <div class="col-12 col-md-6">
        <div class="left-info d-flex flex-column justify-content-center">
          <h1 class="left-info__title">¡Únase hoy para aumentar sus ventas en línea!</h1>
          <p class="left-info__description">Complete el siguiente formulario y obtenga <span class="highlight-text" style="font-weight: 800;">un mes sin cargo</span></p>
          <img class="left-info__arrow d-none d-md-block" src="{{asset('storage/design/commerce-request/arrow.svg')}}" alt="">
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="rigth-info">
          <div class="card-form">
            <div class="card-body">
              <form  action="{{route('restaurant.request')}}" method="POST">
                @csrf
                <p>Dejanos tus datos</p>
                <div class="form-group" data-error="{{$errors->first('name', ':message')}}">
                  <input type="text" name="name" class="form-input" placeholder="Nombre y Apellido" value="{{old('name')}}">
                </div>
                <div class="form-group"  data-error="{{$errors->first('email', ':message')}}">
                  <input type="email" name="email" class="form-input" placeholder="Email" value="{{old('email')}}">
                </div>
                <div class="form-group"  data-error="{{$errors->first('phone', ':message')}}">
                  <input type="text" name="phone" class="form-input" placeholder="Teléfono" value="{{old('phone')}}">
                </div>
                <p class="mt-4">Comentanos sobre tu comercio</p>
                <div class="form-group"  data-error="{{$errors->first('commerce', ':message')}}">
                  <input type="text" name="commerce" class="form-input" placeholder="Nombre de tu comercio" value="{{old('commerce')}}">
                </div>
                <div class="form-group"  data-error="{{$errors->first('address', ':message')}}">
                  <input type="text" name="address" class="form-input" placeholder="Dirección" value="{{old('address')}}">
                </div>
                <div class="form-group"  data-error="{{$errors->first('havecomputer', ':message')}}">
                  <input type="text" name="havecomputer" class="form-input" placeholder="¿Tienes una computadora?" value="{{old('havecomputer')}}">
                </div>
                <div class="form-group"  data-error="{{$errors->first('commercerole', ':message')}}">
                  <textarea class="form-input" name="commercerole" id="" cols="30" rows="4" placeholder="¿A qué se dedica tu comercio?" value="{{old('commercerole')}}">{{old('commercerole')}}</textarea>
                </div>
                <button class="spinnerSubmitButton btn btn-primary btn-block" type="submit">
                    <i class="loadingIcon fas fa-spinner fa-spin d-none"></i>
                    <span class="btn-txt">Enviar</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <div class="row my-3 reviews ">
      <div class="col-12">
          <h2 class="reviews__title">¿Qué dicen nuestros clientes?</h2>
          <div class="review d-flex align-items-center justify-content-center text-left">
            <img class="rounded-circle review__image" src="{{asset('storage/uploads/commerce/hg31Jkst8XhKJlObZkHzTuuQGxSINz28maiwANnB.jpg')}}" alt="">
            <div class="mx-2 d-flex flex-column">
              <p class="review__quote">“{{env('APP_NAME')}} resolvió muchos problemas de tiempos y gestión que tenía en mi comercio. ¡Es excelente!</p>
              <p class="review__author">Fernando Gimenez - El Bajonazo</p>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
  </div>
</section>
<section class="features my-5">

  <div class="feature-1">
    <div class="feature-1__info">
      <h1 class="feature__title">Recibe pedidos 100% online</h1>
      <div class="feature__description">
        <p>No pierdas más tiempo o pedidos por utilizar el teléfono.</p>
        <p>Recibe, gestiona y organiza tus pedidos <span class="highlight-text">con un sólo click.</span></p>
      </div>
    </div>
    <img src="{{asset('storage/design/commerce-request/1-controlpanel.png')}}" class="feature-1__image">
  </div>

  <div class="feature-2">
    <img src="{{asset('storage/design/commerce-request/2-phonewhatsapp.png')}}" class="feature-2__image">
    <div class="feature-2__info">
      <h1 class="feature__title">Mensajes automáticos</h1>
      <div class="feature__description">
        <p>Confirmá y envía el detalle del pedido a tu cliente a través de tu WhatsApp con un solo click y <span class="highlight-text">sin escribir nada.</span></p>
      </div>
    </div>
  </div>

  <div class="feature-3">
    <div class="feature-3__info">
      <h1 class="feature__title">Productos temporales</h1>
      <div class="feature__description">
        <p>Crea productos que sólo se muestren por un tiempo determinado.</p>
        <p><span class="highlight-text">Ideal para promociones o fechas especiales.</span></p>
      </div>
    </div>
    <img src="{{asset('storage/design/commerce-request/3-temporaryproducts.png')}}" class="feature-3__image">
  </div>

  <div class="feature-4">
    <img src="{{asset('storage/design/commerce-request/4-variants.png')}}" class="feature-4__image">
    <div class="feature-4__info">
      <h1 class="feature__title">Variantes</h1>
      <div class="feature__description">
        <p>Agregue variantes a sus productos para ofrecer <span class="highlight-text">más opciones a sus clientes.</span></p>
      </div>
    </div>
  </div>

  <div class="feature-5">
    <div class="feature-5__info">
      <h1 class="feature__title">Delivery</h1>
      <div class="feature__description">
        <p>Solicite un delivery en cualquier momento <span class="highlight-text">para poder entregar su pedido.</span></p>
      </div>
    </div>
    <img src="{{asset('storage/design/commerce-request/5-delivery.png')}}" class="feature-5__image">
  </div>

</section>

<section class="video">
  <hr width="50%">
  <div class="d-flex flex-column align-items-center my-4">
    <h1 class="video__title">Así es como funciona {{env('APP_NAME')}}</h1>
    <iframe class="video__iframe" width="560" height="315" src="https://www.youtube.com/embed/440iz108vgg?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  </div>
  <hr width="50%">
</section>

<section class="free-month">
  <div class="d-flex justify-content-center">
    <div>
      <p class="free-month__title-1">Obtenga</p>
      <p class="free-month__title-2 highlight-text">1 MES GRATIS</p>
      <a class="free-month__cta btn btn-primary" onclick="scrollToTop()">Quiero sumarme a {{env('APP_NAME')}}</a>
    </div>
  </div>
</section>

@endsection

@section('js-scripts')
<script>
function scrollToTop() {
  window.scroll({top: 0, left: 0, behavior: 'smooth'});
}
</script>
@endsection

@section('css-scripts')
<style>
  .background{
    position: absolute;
    top:-10%;
    z-index: -1;
    width: 100%;
  }
  .header{
    position: relative;
    padding-top: 4%;
  }
  .left-info{
    margin-top: 8%;
  }
  .left-info__title{
    width:400px;
    font-size: 46px;
    line-height: 40px;
    font-weight: 800;
    letter-spacing: -1px;
  }
  .left-info__description{
    font-size: 27px;
    line-height: 27px;
    width: 300px;
    font-weight: 500;
    margin-top: 10px;
    letter-spacing: -1px;
  }
  .left-info__arrow{
    position: absolute;
    top:50%;
    left: 25%;
    width: 25%;
  }
  .highlight-text{
    background: linear-gradient(to top, #ffc500 40%, transparent 40%);
  }
  .card-form{
    background-color: white;
    border: 1px solid #DADADA;
    box-sizing: border-box;
    box-shadow: 0px 4px 25px rgba(0, 0, 0, 0.05);
    border-radius: 25px;
    width: 28rem;
  }
  .card-body{
    margin: 15px 25px 0px 25px;
  }
  .form-input{
    width: 100%;
    background-color: white;
    border: 0px;
    border-bottom: 1px solid #E0E0E0;
    padding: 3px 10px;
  }
  .form-input::placeholder{
    color:#CFCFCF;
  }
  .form-input {
    outline: none;
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
  }
  .form-group[data-error]::after{
    margin-left: 10px;
    content: attr(data-error);
    color: red;
    font-size: 13px;
    line-height: 16px;
  }

  /* REVIEWS */
  .reviews{
    text-align: center;
  }
  .reviews__title{
    font-weight: 800;
    font-size: 30px;
  }
  .review{
    width: 50%;
    padding: 10px 0px;
    border-top: 1px solid red;
    border-bottom: 1px solid red;
  }
  .review__quote{
    margin: 10px 0px;
    font-weight: normal;
    font-size: 14px;
    line-height: 104%;
  }
  .review__author{
    font-size: 16px;
    line-height: 104%;
    letter-spacing: -0.04em;
    color: #7D7D7D;
  }
  .review__image{
    width: 12%;
  }

  /* FEATURES */
  .feature-1{
    margin: 3rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
  }
  .feature-1__image{
    width: 35%;
  }
  .feature-2{
    margin: 3rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
  }
  .feature-2__image{
    width: 13%;
    margin: 0 4rem;
  }
  .feature-3{
    margin: 3rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
  }
  .feature-3__image{
    width: 23%;
  } 
  .feature-4{
    margin: 2rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
  }
  .feature-4__image{
    width: 25%;
    margin: 0 4rem;
  }
  .feature-5{
    margin: 3rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
  }
  .feature-5__image{
    width: 30%;
  }
  .feature__title {
    font-weight: 800;
    width: 350px;
    font-size: 40px;
    line-height: 104%;
    letter-spacing: -0.04em;
  }
  .feature__description {
    margin-top: 30px;
  }
  .feature__description p {
    width: 400px;
    font-size: 20px;
    line-height: 104%;
    letter-spacing: -0.04em;
  }
  /* VIDEO */
  .video{
    margin-bottom: 4rem;
  }
  .video__title{
    margin: 2rem 0;
    font-weight: 800;
    font-size: 2rem;
    line-height: 104%;
    letter-spacing: -0.04em;
  }

  /* CALL TO ACTION */

  .free-month{
    margin: 0 2rem;
    margin-bottom: 4rem;
    text-align: center;
  }
  .free-month__title-1{
    font-size: 2em;
    line-height: 10px;
    font-weight: 800;
    letter-spacing: -1px;
  }
  .free-month__title-2{
    font-size: 3em;
    line-height: 40px;
    font-weight: 800;
    letter-spacing: -1px;
  }
  .free-month__cta{
    margin-top: 2rem;
  }
  @media (max-width: 768px) {
    .left-info{
      margin: 20px 0px;
    }
    .left-info__title {
      text-align: center;
      width: 100%;
      line-height: 1em;
      font-size: 2em;
      letter-spacing: -1px;
    }
    .left-info__description {
      text-align: center;
      font-size: 1em;
      line-height: 1em;
      width: 80%;
      margin: auto;
    }
    .left-info__arrow {
      display: none;
    }
    .card-form {
      margin-top: 20px;
      font-size: .8em;
      width: 100%;
    }
    .card-body {
      margin: 10px 15px 0px 15px;
    }
    .features{
      margin: 0px 2rem;
      text-align: center;
    }
    .feature__title {
      width: 100%;
      font-size: 2em;
    }
    .feature__description {
      margin-top: 30px;
    }
    .feature__description p {
      width: 100%;
      font-size: 1em;
    }
    .feature-1__info{
      text-align: center;
    }
    .feature-1 img{
      width: 100%;
    }
    .feature-2{
      flex-direction: column-reverse;
    }
    .feature-2 img{
      width: 30%;
      margin-top: 1rem;
    }
    .feature-3 img{
      width: 100%;
    }
    .feature-4{
      flex-wrap: nowrap;
      flex-direction: column-reverse;
    }
    .feature-4 img{
      width: 100%;
    }
    .feature-5 img{
      margin: 1rem 0;
      width: 100%;
    }
    .features{
      margin: 0 2rem;
      text-align: center;
    }
    .video__title{
      margin: 2rem .5rem;
      text-align: center;
    }
    .video__iframe{
      width: 100%;
    }
    /* CALL TO ACTION */
    .free-month__title-1{
    font-size: 1em;
    line-height: 5px;
    font-weight: 800;
    letter-spacing: -1px;
  }
  .free-month__title-2{
    font-size: 2em;
    line-height: 20px;
    font-weight: 800;
    letter-spacing: -1px;
  }
  }
}
</style>

