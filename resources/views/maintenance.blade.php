@extends('layouts.maintenance')

@section('css-scripts')
<style>
  body{
    background-color: #fffbf5;
  }

  .section-title{
    font-weight: 800;
    text-align: center;
    letter-spacing: -1.5px;
  }

  .text-title{
    font-weight: 600;
    text-align: center;
    letter-spacing: -1.5px;
  }

  .mnt-description{
    font-weight: 400;
    text-align: center;
    letter-spacing: -.7px;
    font-size: 1.5em;
  }

  .mnt-second-description{
    font-weight: 400;
    text-align: center;
    letter-spacing: -.7px;
    margin: auto;
  }

  .stadistic-description {
    font-size: 16px;
    width: 150px;
  }

  .demo-card {
    width: 500px;
    max-width: 100%;
    padding: 0 30px;
    background-color: #fffbf5;
    border: none;
    box-shadow: 0px 4px 97px rgba(0, 0, 0, 0.07);
    border-radius: 17px;
  }

  @media screen and (max-width:767px){
    .section-title{
        font-size: 25px;
    }
    .mnt-description{
        font-size: 18px;
    }
    }
</style>
@endsection

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="section-title">¡Sistema en venta!</h1>
            <hr class="my-1">
              <div class="row d-flex justify-content-center">
                  <div class="col-12 col-md-8 m-auto text-center">
                    <h5 class="text-title mt-4">¿En qué consiste?</h5>
                    <p>
                      Pedí Simple es un marketplace de comercios gastronómicos que permite brindarle a cada comerciante,
                      un perfil propio para mostrar sus productos, recibir pedidos online  desde la plataforma y gestionarlos
                      a través de mensajes automáticos en WhatsApp. El comerciante gestiona los pedidos a través de un panel
                      de administración para mantener al cliente informado sobre el estado de su pedido en todo momento.
                    </p>

                    <h5 class="text-title mt-4">¿Cómo funciona?</h5>
                    <p>
                      Los clientes que ingresan a la paltaforma, pueden elegir cualquiera de los comercios disponibles, ingresar
                      a su perfil y agregar al carrito los productos que desea comprar. Una vez realizado el pedido, al comerciante
                      le llega una alerta en tiempo real en su panel de administración indicando la recepción del nuevo pedido.
                      El comerciante puede aceptar o rechazar, indicar tiempo de demora, cancelar o editar el pedido. Cada vez que el
                      pedido cambia de estado (Aceptado-Editado-Cancelado) se le notifica automáticamente por WhatsApp al comprador,
                      agilizando así, la gestión de los pedidos a los comerciantes.
                    </p>
                    <a class="btn btn-link" href="{{route('features')}}"> Ver más características del sistema </a>
                </div>
              </div>
              <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 m-auto text-center">
                  <h5 class="text-title mt-4">Estadísticas</h5>
                  <div class="row my-4 d-flex align-items-center">
                    <div class="col-12 col-md-6 col-lg-3">
                      <div class="d-flex flex-column align-items-center">
                        <h2 class="text-title">867</h2>
                        <p class="stadistic-description">Usuarios registrados</p>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                      <div class="d-flex flex-column align-items-center">
                        <h2 class="text-title">2546</h2>
                        <p class="stadistic-description">Pedidos realizados</p>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                      <div class="d-flex flex-column align-items-center">
                        <h2 class="text-title">1126</h2>
                        <p class="stadistic-description">Pedidos de usuarios</p>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                      <div class="d-flex flex-column align-items-center">
                        <h2 class="text-title">1420</h2>
                        <p class="stadistic-description">Pedidos de invitados</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row d-flex justify-content-center">
                  <div class="col-12 col-md-8 m-auto text-center">
                    <h5 class="text-title mt-4">Tecnologías utilizadas</h5>
                    <div class="row my-4 d-flex align-items-center">
                      <div class="col-12 col-md-4 col-lg-2">
                        <img class="my-4" src="{{asset('storage/technologies/PHP.svg')}}" >
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <img class="my-4" src="{{asset('storage/technologies/LARAVEL.svg')}}" >
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <img class="my-4" src="{{asset('storage/technologies/MYSQL.svg')}}" >
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <img class="my-4" src="{{asset('storage/technologies/JQUERY.svg')}}" >
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <img class="my-4" src="{{asset('storage/technologies/GIT.svg')}}" >
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <img class="my-4" src="{{asset('storage/technologies/DIGITALOCEAN.svg')}}" >
                      </div>
                    </div>
                </div>
              </div>
              <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 m-auto text-center d-flex flex-column align-items-center">
                  <h5 class="text-title mt-4">Demo</h5>
                  <div class="card demo-card">
                    <div class="card-body">
                      <h5 class="text-title">Comerciante</h5>
                      <p class="mb-0"><strong>user:</strong> pedisimple@gmail.com</p>
                      <p class="mb-0"><strong>pass:</strong> 12345678</p>
                      <h5 class="text-title mt-4">Usuario</h5>
                      <p class="mb-0"><strong>user:</strong> juanperez@gmail.com</p>
                      <p class="mb-0"><strong>pass:</strong> 12345678</p>
                      @if(Auth::user())
                        <a href="{{route('home.index')}}" class="btn btn-primary btn-block mt-4">Ir a inicio</a>
                      @else
                        <a href="{{route('login')}}" class="btn btn-primary btn-block mt-4">Iniciar sesión</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="row d-flex justify-content-center mt-4">
                <div class="col-12 col-md-6 m-auto text-center d-flex flex-column align-items-center">
                  <h5 class="text-title mt-4">Contacto</h5>
                  <a class="btn btn-link" href="mailto:joaquinvilchez95@gmail.com">joaquinvilchez95@gmail.com</a>
                </div>
              </div>
        </div>
    </div>


</div>
@endsection
