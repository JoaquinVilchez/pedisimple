@extends('layouts.app')
@section('content')

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
              <form action="{{route()}}" method="POST">
                <p>Dejanos tus datos</p>
                <div class="form-group">
                  <input type="text" class="form-input" placeholder="Nombre y Apellido">
                </div>
                <div class="form-group">
                  <input type="email" class="form-input" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="text" class="form-input" placeholder="Teléfono">
                </div>
                <p class="mt-4">Comentanos sobre tu comercio</p>
                <div class="form-group">
                  <input type="text" class="form-input" placeholder="Nombre de tu comercio">
                </div>
                <div class="form-group">
                  <input type="text" class="form-input" placeholder="Dirección">
                </div>
                <div class="form-group">
                  <input type="text" class="form-input" placeholder="¿Tienes una computadora?">
                </div>
                <div class="form-group">
                  <textarea class="form-input" name="" id="" cols="30" rows="4" placeholder="¿A qué se dedica tu comercio?"></textarea>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Enviar</button>
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
      <p class="review__quote">“Pedí Simple resolvió muchos problemas de tiempos y gestión que tenía en mi comercio. ¡Es excelente!</p>
      <p class="review__author">Fernando Gimenez - El Bajonazo</p>
    </div>
  </div>
  </div>
  </div>
  </div> --}}
  </div>
</section>
<section class="features my-5">

  <div class="row d-flex align-items-center">
    <div class="col-12 col-md-6 d-flex justify-content-end">
      <div>
        <h1 class="feature__title">Recibe pedidos 100% online</h1>
        <div class="feature__description">
          <p>No pierdas más tiempo o pedidos por utilizar el teléfono.</p>
          <p>Recibe, gestiona y organiza tus pedidos <span class="highlight-text">con un sólo click.</span></p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 px-0 mx-0">
      <img src="{{asset('storage/design/commerce-request/1-controlpanel.png')}}" class="feature-1__image">
    </div>
  </div>

  <div class="row d-flex justify-content-end align-items-center my-5  ">
    <div class="col-12 col-md-6 float-right">
      <img src="{{asset('storage/design/commerce-request/2-phonewhatsapp.png')}}" class="feature-2__image">
    </div>
    <div class="col-12 col-md-6 d-flex justify-content-start">
      <div>
        <h1 class="feature__title">Mensajes automáticos</h1>
        <div class="feature__description">
          <p>Confirmá y envía el detalle del pedido a tu cliente a través de tu WhatsApp con un solo click y <span class="highlight-text">sin escribir nada.</span></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row d-flex align-items-center my-5">
    <div class="col-12 col-md-6">
      <div class="float-right">
        <h1 class="feature__title">Productos temporales</h1>
        <div class="feature__description">
          <p>Crea productos que sólo se muestren por un tiempo determinado.</p>
          <p><span class="highlight-text">Ideal para promociones o fechas especiales.</span></p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 px-0 mx-0">
      <img src="{{asset('storage/design/commerce-request/3-temporaryproducts.png')}}" class="feature-3__image">
    </div>
  </div>

  <div class="row d-flex align-items-center my-5">
    <div class="col-12 col-md-6 d-flex justify-content-end">
      <img src="{{asset('storage/design/commerce-request/4-variants.png')}}" class="feature-4__image">
    </div>
    <div class="col-12 col-md-6">
      <div class="float-left">
        <h1 class="feature__title">Variantes</h1>
        <div class="feature__description">
          <p>Agregue variantes a sus productos para ofrecer <span class="highlight-text">más opciones a sus clientes.</span></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row d-flex align-items-center my-5">
    <div class="col-12 col-md-6">
      <div class="float-right">
        <h1 class="feature__title">Delivery</h1>
        <div class="feature__description">
          <p>Solicite un delivery en cualquier momento <span class="highlight-text">para poder entregar su pedido.</span></p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 px-0 mx-0">
      <img src="{{asset('storage/design/commerce-request/5-delivery.png')}}" class="feature-5__image">
    </div>
  </div>

</section>

@endsection

@section('css-scripts')
<style>
  .background {
    position: absolute;
    top: -10%;
    z-index: -1;
    width: 100%;
  }

  .header {
    position: relative;
    padding-top: 4%;
  }

  .left-info {
    margin-top: 8%;
  }

  .left-info__title {
    width: 400px;
    font-size: 46px;
    line-height: 40px;
    font-weight: 800;
    letter-spacing: -1px;
  }

  .left-info__description {
    font-size: 27px;
    line-height: 27px;
    width: 300px;
    font-weight: 500;
    margin-top: 10px;
    letter-spacing: -1px;
  }

  .left-info__arrow {
    position: absolute;
    top: 50%;
    left: 25%;
    width: 25%;
  }

  .highlight-text {
    background: linear-gradient(to top, #ffc500 40%, transparent 40%);
  }

  .card-form {
    background-color: white;
    border: 1px solid #DADADA;
    box-sizing: border-box;
    box-shadow: 0px 4px 25px rgba(0, 0, 0, 0.05);
    border-radius: 25px;
    width: 28rem;
  }

  .card-body {
    margin: 15px 25px 0px 25px;
  }

  .form-input {
    width: 100%;
    background-color: white;
    border: 0px;
    border-bottom: 1px solid #E0E0E0;
    padding: 3px 10px;
  }

  .form-input::placeholder {
    color: #CFCFCF;
  }

  .form-input {
    outline: none;
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
  }

  /* REVIEWS */
  .reviews {
    text-align: center;
  }

  .reviews__title {
    font-weight: 800;
    font-size: 30px;
  }

  .review {
    width: 50%;
    padding: 10px 0px;
    border-top: 1px solid red;
    border-bottom: 1px solid red;
  }

  .review__quote {
    margin: 10px 0px;
    font-weight: normal;
    font-size: 14px;
    line-height: 104%;
  }

  .review__author {
    font-size: 16px;
    line-height: 104%;
    letter-spacing: -0.04em;
    color: #7D7D7D;
  }

  .review__image {
    width: 12%;
  }

  /* FEATURES */
  .feature__title {
    font-weight: 800;
    width: 350px;
    font-size: 45px;
    line-height: 104%;
    letter-spacing: -0.04em;
  }

  .feature__description {
    margin-top: 30px;
  }

  .feature__description p {
    width: 400px;
    font-size: 22px;
    line-height: 104%;
    letter-spacing: -0.04em;
  }

  .feature-1__image {
    width: 40rem;
  }

  .feature-2__image {
    width: 12rem;
    margin-right: 7rem;
    float: right;
  }

  .feature-3__image {
    width: 25rem;
  }

  .feature-4__image {
    width: 25rem;
    margin-right: 5rem;
  }

  .feature-5__image {
    width: 25rem;
    margin-left: 2rem;
  }

  @media (max-width: 576px) {
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

    .features {
      text-align: center
    }

    .feature__title {
      font-size: 1em;
      width: 100%;
      margin: 0;
    }

    .feature__description p {
      margin: 0;
      width: 100%;
      font-size: .5em;
    }

    .feature-1__image {
      width: 50%;
    }

    .feature-2__image {
      width: 50%;
    }

    .feature-3__image {
      width: 50%;
    }

    .feature-4__image {
      width: 50%;
    }

    .feature-5__image {
      width: 50%;
    }
  }
</style>