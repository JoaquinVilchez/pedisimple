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
            <h1 class="section-title">Pedí Simple - Marketplace Gastronómico</h1>
            <hr class="my-1">
              <div class="row d-flex justify-content-center">
                  <div class="col-12 col-md-8 m-auto text-center">
                    <h5 class="text-title mt-4">Descripción del Proyecto</h5>
                    <p>
                      Pedí Simple es un marketplace completo desarrollado en Laravel que conecta comercios gastronómicos con sus clientes. 
                      El sistema incluye un panel de administración robusto para comerciantes, gestión de pedidos en tiempo real, 
                      integración con WhatsApp para notificaciones automáticas, y una experiencia de usuario optimizada para 
                      dispositivos móviles. Este proyecto demuestra mi capacidad para desarrollar aplicaciones web complejas 
                      con funcionalidades empresariales reales.
                    </p>

                    <h5 class="text-title mt-4">Funcionalidades Principales</h5>
                    <p>
                      <strong>Para Comerciantes:</strong> Panel de administración completo, gestión de productos y categorías, 
                      recepción de pedidos en tiempo real, sistema de notificaciones automáticas, y dashboard con estadísticas 
                      de ventas.<br><br>
                      <strong>Para Clientes:</strong> Catálogo de productos por comercio, carrito de compras intuitivo, 
                      seguimiento de pedidos en tiempo real, y notificaciones automáticas por WhatsApp sobre el estado de su orden.
                    </p>
                    <a class="btn btn-link" href="{{route('features')}}"> Ver características técnicas detalladas </a>
                </div>
              </div>
              <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 m-auto text-center">
                  <h5 class="text-title mt-4">Estadísticas del Sistema</h5>
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
                        <p class="stadistic-description">Pedidos procesados</p>
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
                    <h5 class="text-title mt-4">Stack Tecnológico</h5>
                    <div class="row my-4 d-flex align-items-center">
                      <div class="col-12 col-md-4 col-lg-2">
                        <div class="d-flex flex-column align-items-center">
                          <i class="fab fa-php fa-4x my-4 text-dark"></i>
                          <p class="text-muted">PHP</p>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <div class="d-flex flex-column align-items-center">
                          <i class="fab fa-laravel fa-3x my-4 text-dark"></i>
                          <p class="text-muted">Laravel</p>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <div class="d-flex flex-column align-items-center">
                          <i class="fas fa-database fa-3x my-4 text-dark"></i>
                          <p class="text-muted">MySQL</p>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <div class="d-flex flex-column align-items-center">
                          <i class="fab fa-js-square fa-3x my-4 text-dark"></i>
                          <p class="text-muted">jQuery</p>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <div class="d-flex flex-column align-items-center">
                          <i class="fab fa-git-alt fa-3x my-4 text-dark"></i>
                          <p class="text-muted">Git</p>
                        </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-2">
                        <div class="d-flex flex-column align-items-center">
                          <i class="fas fa-cloud fa-3x my-4 text-dark"></i>
                          <p class="text-muted">DigitalOcean</p>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 m-auto text-center d-flex flex-column align-items-center">
                  <h5 class="text-title mt-4">Demo del Sistema</h5>
                  <div class="card demo-card">
                    <div class="card-body">
                        <h5 class="text-title">Comerciante</h5>
                        <p class="mb-0"><strong>user:</strong> comerciante@mail.com</p>
                        <p class="mb-0"><strong>pass:</strong> 12345678</p>
                        <h5 class="text-title mt-4">Usuario</h5>
                        <p class="mb-0"><strong>user:</strong> cliente@mail.com</p>
                        <p class="mb-0"><strong>pass:</strong> 12345678</p>
                        <h5 class="text-title mt-4">Administrador</h5>
                        <p class="mb-0"><strong>user:</strong> admin@mail.com</p>
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
