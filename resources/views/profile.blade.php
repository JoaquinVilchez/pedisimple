@extends('layouts.app')

@section('content')
<section class="jumbotron pb-0" style="background: url('https://images.pexels.com/photos/326279/pexels-photo-326279.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px 10% / cover transparent;">
    <div class="container text-white d-flex align-items-end col-lg-8">
        <div class="row d-flex align-items-end">
            <figure>
            <img class="d-block border m-1" width="110px" src="https://img.pystatic.com/restaurants/green-eat-billinghurst.jpg" alt="">
            </figure>
            <section class="ml-3 mb-3">
                <div class="title"><h3><strong>Green Eat</strong></h3></div>
                <div class="info mb-0 ml-3"><p class="mb-0">Jujuy 229, Venado Tuerto, Santa Fe</p></div>
                <div class="extra ml-3 mb-10"><small>Pizzas - Empanadas</small><span class="mx-2" style="border-left: 1px solid white;height: 100px;"></span><small>Costo de envio: $50</small></div>
            </section>
        </div>  
    </div>
</section>

<!-- Page Content -->
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                <h6 class="my-0">Product name</h6>
                <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$12</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                <h6 class="my-0">Second product</h6>
                <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$8</span>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                <h6 class="my-0">Third item</h6>
                <small class="text-muted">Brief description</small>
                </div>
                <span class="text-muted">$5</span>
            </li>
            <li class="list-group-item d-flex justify-content-between bg-light">
                <div class="text-success">
                <h6 class="my-0">Promo code</h6>
                <small>EXAMPLECODE</small>
                </div>
                <span class="text-success">-$5</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Total (USD)</span>
                <strong>$20</strong>
            </li>
            </ul>
            <div class="float-right">
                <a href="{{route('checkout')}}" class="btn btn-danger">Continuar</a>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="categoria mb-4">
                <h3>Empanadas</h3>
                <div class="row">
                    <div class="col-lg-6 px-1">
                        <div class="card p-2 m-1">
                            <div class="row">
                                <div class="col-4 pr-0">
                                <img class="d-block border m-1" width="80px" src="https://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2019/11/masa-para-empanadas-economica.jpg" alt="">
                                </div>
                                <div class="col-8 pl-0">
                                <div class="card-block mt-2">
                                    <!--           <h4 class="card-title">Small card</h4> -->
                                    <h6><strong>Empanada de Jamon y Queso</strong></h6>
                                    <span>$35</span>
                                    <a href="{{route('profile')}}" style="border-radius:100px;" class="btn btn-outline-primary btn-sm float-right mr-2">+</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 px-1">
                        <div class="card p-2 m-1">
                            <div class="row">
                                <div class="col-4 pr-0">
                                <img class="d-block border m-1" width="80px" src="https://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2019/11/masa-para-empanadas-economica.jpg" alt="">
                                </div>
                                <div class="col-8 pl-0">
                                <div class="card-block mt-2">
                                    <!--           <h4 class="card-title">Small card</h4> -->
                                    <h6><strong>Empanada de Jamon y Queso</strong></h6>
                                    <span>$35</span>
                                    <a href="{{route('profile')}}" style="border-radius:100px" class="btn btn-outline-primary btn-sm float-right mr-2">+</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 px-1">
                        <div class="card p-2 m-1">
                            <div class="row">
                                <div class="col-4 pr-0">
                                <img class="d-block border m-1" width="80px" src="https://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2019/11/masa-para-empanadas-economica.jpg" alt="">
                                </div>
                                <div class="col-8 pl-0">
                                <div class="card-block mt-2">
                                    <!--           <h4 class="card-title">Small card</h4> -->
                                    <h6><strong>Empanada de Jamon y Queso</strong></h6>
                                    <span>$35</span>
                                    <a href="{{route('profile')}}" style="border-radius:100px" class="btn btn-outline-primary btn-sm float-right mr-2">+</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 px-1">
                        <div class="card p-2 m-1">
                            <div class="row">
                                <div class="col-4 pr-0">
                                <img class="d-block border m-1" width="80px" src="https://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2019/11/masa-para-empanadas-economica.jpg" alt="">
                                </div>
                                <div class="col-8 pl-0">
                                <div class="card-block mt-2">
                                    <!--           <h4 class="card-title">Small card</h4> -->
                                    <h6><strong>Empanada de Jamon y Queso</strong></h6>
                                    <span>$35</span>
                                    <a href="{{route('profile')}}" style="border-radius:100px" class="btn btn-outline-primary btn-sm float-right mr-2">+</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="categoria mb-4">
                <h3>Pizzas</h3>
                <div class="row">
                    <div class="col-lg-6 px-1">
                        <div class="card p-2 m-1">
                            <div class="row">
                                <div class="col-4 pr-0">
                                <img class="d-block border m-1" width="80px" src="https://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2019/11/masa-para-empanadas-economica.jpg" alt="">
                                </div>
                                <div class="col-8 pl-0">
                                <div class="card-block mt-2">
                                    <!--           <h4 class="card-title">Small card</h4> -->
                                    <h6><strong>Empanada de Jamon y Queso</strong></h6>
                                    <span>$35</span>
                                    <a href="{{route('profile')}}" style="border-radius:100px" class="btn btn-outline-primary btn-sm float-right mr-2">+</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 px-1">
                        <div class="card p-2 m-1">
                            <div class="row">
                                <div class="col-4 pr-0">
                                <img class="d-block border m-1" width="80px" src="https://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2019/11/masa-para-empanadas-economica.jpg" alt="">
                                </div>
                                <div class="col-8 pl-0">
                                <div class="card-block mt-2">
                                    <!--           <h4 class="card-title">Small card</h4> -->
                                    <h6><strong>Empanada de Jamon y Queso</strong></h6>
                                    <span>$35</span>
                                    <a href="{{route('profile')}}" style="border-radius:100px" class="btn btn-outline-primary btn-sm float-right mr-2">+</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 px-1">
                        <div class="card p-2 m-1">
                            <div class="row">
                                <div class="col-4 pr-0">
                                <img class="d-block border m-1" width="80px" src="https://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2019/11/masa-para-empanadas-economica.jpg" alt="">
                                </div>
                                <div class="col-8 pl-0">
                                <div class="card-block mt-2">
                                    <!--           <h4 class="card-title">Small card</h4> -->
                                    <h6><strong>Empanada de Jamon y Queso</strong></h6>
                                    <span>$35</span>
                                    <a href="{{route('profile')}}" style="border-radius:100px" class="btn btn-outline-primary btn-sm float-right mr-2">+</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 px-1">
                        <div class="card p-2 m-1">
                            <div class="row">
                                <div class="col-4 pr-0">
                                <img class="d-block border m-1" width="80px" src="https://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2019/11/masa-para-empanadas-economica.jpg" alt="">
                                </div>
                                <div class="col-8 pl-0">
                                <div class="card-block mt-2">
                                    <!--           <h4 class="card-title">Small card</h4> -->
                                    <h6><strong>Empanada de Jamon y Queso</strong></h6>
                                    <span>$35</span>
                                    <a href="{{route('profile')}}" style="border-radius:100px" class="btn btn-outline-primary btn-sm float-right mr-2">+</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 px-1">
                        <div class="card p-2 m-1">
                            <div class="row">
                                <div class="col-4 pr-0">
                                <img class="d-block border m-1" width="80px" src="https://cdn2.cocinadelirante.com/sites/default/files/styles/gallerie/public/images/2019/11/masa-para-empanadas-economica.jpg" alt="">
                                </div>
                                <div class="col-8 pl-0">
                                <div class="card-block mt-2">
                                    <!--           <h4 class="card-title">Small card</h4> -->
                                    <h6><strong>Empanada de Jamon y Queso</strong></h6>
                                    <span>$35</span>
                                    <a href="{{route('profile')}}" style="border-radius:100px" class="btn btn-outline-primary btn-sm float-right mr-2">+</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <nav aria-label="..." class="float-right mt-3">
                <ul class="pagination">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
        </div>
    </div>
</div>
@endsection