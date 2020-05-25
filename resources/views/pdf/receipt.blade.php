<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>{{config('app.name')}} - Detalle de pedido</title>
  </head>
  <body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <table class="table table-sm">
                    <thead>
                      <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>${{$item->product->price}}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td></td>
                            <td><strong>Subtotal</strong></td>
                            <td>${{$order->subtotal}}</td>
                        </tr>
                    @if($order->delivery != null)
                        <tr>
                            <td></td>
                            <td><strong>Delivery</strong></td>
                            <td>${{$order->delivery}}</td>
                        </tr>
                    @endif
                        <tr>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td>${{$order->total}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
    </div>

  </body>
</html>