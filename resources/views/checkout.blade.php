@extends('layouts.app')

@section('content')
<section class="jumbotron" style="background: url('https://images.pexels.com/photos/2733918/pexels-photo-2733918.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940') no-repeat scroll 0px 40% / cover transparent;">
    <div class="container text-white text-center">
       <h1>Checkout</h1>
    </div>
</section>

<div class="container">
    <div class="row mb-5">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Tu pedido</span>
                <span class="badge badge-secondary badge-pill">{{Cart::session(Auth::user()->id)->getTotalQuantity()}}</span>
            </h4>
            @include('carrito')
        </div>
        <div class="col-md-8 order-md-1">
        <form class="needs-validation" action="{{route('checkout.store')}}" method="POST" novalidate>
            @csrf
            {{-- HACERLO DINAMICO --}}
            <input type="hidden" name="restaurant_id" value="1"> 
            {{-- HACERLO DINAMICO --}}
            <input type="hidden" name="shipping_method" value="delivery">
            {{-- HACERLO DINAMICO --}} 
            <div class="mb-4">
                <h4 class="mb-3">Direccion de entrega</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <span><strong>Chacabuco 315</strong> - 3462642680</span><a href="#" class="ml-3">Editar</a>
                        <hr class="my-0">
                        <small class="ml-2"><a href="#">Ver todas mis direcciones</a></small>
                    </div>
                </div>
            </div>  
            <div class="mb-4">
                <h4 class="mb-3">Selecciona un metodo de pago</h4>
                <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#nav-tab-delivery">
                        <i class="fas fa-motorcycle"></i> Pago al delivery</a></li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#nav-tab-card">
                        <i class="fa fa-credit-card"></i> Pago online</a></li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="nav-tab-delivery">
                        <div class="form-group">
                            <label for="cardNumber">Ingresa el con cuanto vas a pagar:</label>
                            <div class="input-group col-lg-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupPrepend2">$</span>
                                </div>
                                <input type="text" class="form-control" id="validationDefaultUsername"  aria-describedby="inputGroupPrepend2" required>
                              </div>
                            <small class="ml-3">Opcional</small>                            
                        </div>
                    </div> <!-- tab-pane.// -->

                        <div class="tab-pane fade" id="nav-tab-card">
                            <p class="alert alert-success">Some text success or error</p>
                                <div class="form-group">
                                    <label for="username">Full name (on the card)</label>
                                    <input type="text" class="form-control" name="username" placeholder="" required="">
                                </div> <!-- form-group.// -->
                            
                                <div class="form-group">
                                    <label for="cardNumber">Card number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cardNumber" placeholder="">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-muted">
                                                <i class="fab fa-cc-visa"></i>   <i class="fab fa-cc-amex"></i>   
                                                <i class="fab fa-cc-mastercard"></i> 
                                            </span>
                                        </div>
                                    </div>
                                </div> <!-- form-group.// -->
                            
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label><span class="hidden-xs">Expiration</span> </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="MM" name="">
                                                <input type="number" class="form-control" placeholder="YY" name="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                            <input type="number" class="form-control" required="">
                                        </div> <!-- form-group.// -->
                                    </div>
                                </div> <!-- row.// -->
                        </div> <!-- tab-pane.// -->
                </div> <!-- tab-content .// -->
            </div>
            <hr class="my-4">
            <div class="form-group">
                <h4>Notas adicionales</h4>
                <textarea class="form-control" rows="3" placeholder="Notas adicionales"></textarea>
              </div>
            <button class="subscribe btn btn-danger btn-block" type="submit" @if(Cart::isEmpty())disabled @endif> Confirmar pedido </button>
        </form>
        </div>
    </div>
</div>
@endsection