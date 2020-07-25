<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>{{config('app.name')}} - Detalle de pedido</title>

    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <style type="text/css">
      /* @import url('https://fonts.googleapis.com/css?family=Poppins:400,900&display=swap'); */
      @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: normal;
            src: url('https://fonts.googleapis.com/css?family=Poppins:400,900&display=swap') format('truetype');
      }

      @page {
          margin: 0cm 0cm;
          font-family: 'Poppins', sans-serif;
      }


      body {
          margin: 3cm 2cm 2cm;
          font-family: 'Poppins', sans-serif;
      }

      header {
          position: fixed;
          top: 0cm;
          left: 0cm;
          right: 0cm;
          height: 120px;
          padding-top: 20px;
          padding-bottom: 10px;
          margin-bottom: 20px;
          background-color: #f1f1f1;
          border-bottom: 10px solid #FFC500;
          color: rgba(20, 20, 20);
          text-align: center;
          line-height: 30px;
      }

      .header h3{
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
      }

      footer {
          position: fixed;
          bottom: 0cm;
          left: 0cm;
          right: 0cm;
          height: 2cm;
          background-color: #FFC500;
          color: white;
          text-align: center;
          line-height: 35px;
      }

      customer-details{
        border: 1px solid rgb(221, 221, 221);
      }
  </style>

  </head>
  <body>
    <header>
        <h3>¡Gracias por pedir en {{env('APP_NAME')}}!</h3>
        <p>Este es el resumen de tu pedido hecho a <strong>{{$order->restaurant->name}}</strong></p>
        <p>Fecha del pedido: {{date("d-m-Y g:i A", strtotime($order->ordered))}}</p>
    </header>
    <main>
      <div class="container mt-5">
          <div class="row justify-content-center">
              <div class="col-12">
                <div class="customer-details">
                  <p><strong>Datos del pedido:</strong></p>
                    <ul style="list-style: none">
                      <li>Código de referencia: {{$order->code}}</li>
                      <li>Método de envío: {{$order->getShippingMethod()}}</li>
                      <li>Nombre: {{$order->getFullName()}}</li>
                      <li>Dirección: {{$order->getFullAddress()}}</li>
                      <li>Teléfono: {{$order->getPhone()}}</li>
                    </ul>
                </div>
                <p><strong>Detalle de productos:</strong></p>
                  <table class="table table-sm table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">Producto</th>
                          <th scope="col">Cantidad</th>
                          <th scope="col">Precio</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($items as $item)
                          <tr>
                          <td>
                            <span style="display: block">{{$item->product->name}}</span>
                            @if ($item->variants!=null)
                              <span class="text-muted"><small>Variantes: {{implode(', ', $item->showVariants())}}</small></span>  
                            @endif
                          </td>
                          <td style="text-align: center">{{$item->quantity}}</td>
                          <td style="text-align: right">${{$item->product->price}}</td>
                          </tr>
                      @endforeach
                          <tr>
                              <td></td>
                              <td><strong>Subtotal</strong></td>
                              <td style="text-align: right">${{$order->subtotal}}</td>
                          </tr>
                      @if($order->delivery != null)
                          <tr>
                              <td></td>
                              <td><strong>Delivery</strong></td>
                              @if ($order->shipping_method=='delivery')
                                <td style="text-align: right">${{$order->delivery}}</td>
                              @else
                                <td style="text-align: center">-</td>
                              @endif
                          </tr>
                      @endif
                          <tr>
                              <td></td>
                              <td><strong>Total</strong></td>
                              <td style="text-align: right">${{$order->total}}</td>
                          </tr>
                      </tbody>
                  </table>

                  <div class="alert alert-secondary mt-5" role="alert">
                    <p><small>Recuerda:</small></p>
                      <ul>
                        <small><li>El comercio se comunicará contigo por Whatsapp para concretar y coordinar el pedido.</li></small>
                        <small><li>El precio del delivery puede variar en base a la distancia.</li></small>
                      </ul>
                    
                  </div>
              </div>
            </div>
      </div>
    </main>

    <footer>
      <div class="container">
        <div class="mx-5">
          <small><strong>{{env('APP_NAME')}} no es responsable de cualquier inconveniente con el producto o envío.</strong></small>
        </div>
      </div>
    </footer>
  </body>
</html>