<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Cart;
use Carbon\Carbon;
use App\Rules\validatePhone;
use App\Order;
use App\Product;
use App\Address;
use App\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\LineItem;
use PDF;
use App\Notifications\OrderProcessed;
use App\Notifications\NewOrder;
use App\Exceptions\Handler;

class CheckoutController extends Controller
{

    public function download($data)
    {
        $id = Crypt::decryptString($data);
        $order = Order::find($id);
        $items = $order->lineitems;
        $pdf = PDF::loadView('pdf.receipt', array('order' => $order, 'items' => $items));
        return $pdf->stream('recibo.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Cart::isEmpty()) {
            return abort(404);
        } else {
            foreach (\Cart::getContent() as $item) {
                $itemId = $item->attributes->product_id;
                if ($itemId != null) {
                    break;
                }
            }

            $restaurant = Product::find($itemId)->restaurant;

            return view('checkout')->with('restaurant', $restaurant);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //OPTIMIZACION: SE PUEDE HACER UN ARRAY $args QUE CONTENGA LOS CAMPOS GENERALES A USAR
        //EN CREATE Y VALIDATE Y DEPENDIENDO DE LAS CONDICIONES IR AGREGANDOLE LAS CARACTERISTICAS
        //QUE FALTEN CON UNA FUNCION DE AGREGAR ELEMENTOS A ARRAY. ESTO ES PARA NO REPETIR TANTO CODIGO

        $restaurant = Restaurant::find($request->restaurant_id);
        if ($restaurant->getOpeningHoursData()->isOpen()) {
            if ($restaurant->getOrderStatus() == 1) {
                //CREAR CODIGO
                //Genera un codigo de referencia para el pedido
                do {
                    $code = generateCode();
                    $oderCode = Order::where('code', $code)->first();
                } while ($oderCode != null);

                //CHECKEA METODO DE ENVIO
                if (\Cart::getCondition('Delivery')) {
                    $shipping_method = 'delivery';
                } else {
                    $shipping_method = 'pickup';
                }

                //CREAR PEDIDO
                if ($request->auth_user == 'true') {

                    $user = Auth::user();

                    if ($user->restaurant == $restaurant) {
                        return back()->with('error_message', 'No puedes hacer un pedido a tu propio comercio.');
                    } else {

                        if ($request->address_type == 'data-address') {
                            $request->validate([
                                'address' => 'required'
                            ]);
                        } elseif ($request->address_type == 'new-address') {
                            $request->validate([
                                'client_street' => 'required',
                                'client_number' => 'required|numeric'
                            ]);
                        }

                        $transaction = DB::transaction(function () use ($request, $shipping_method, $code, $user, $restaurant) {

                            try {
                                //CHECKEA SI EL PEDIDO ES CON DELIVERY O SIN (EN CASO DE QUE SEA RETIRO EN LOCAL NO REGISTRA DIRECCION)
                                if (\Cart::getCondition('Delivery')) {

                                    $delivery_price = \Cart::getCondition('Delivery')->getValue();
                                    //DIRECCION
                                    if ($request->address_type == 'data-address') {

                                        $address = Address::find($request->address);
                                        //Crea el pedido con la direccion registrada previamente del usuario
                                        $order = Order::create([
                                            'user_id' => $user->id,
                                            'address_id' => $address->id,
                                            'restaurant_id' => $request->restaurant_id,
                                            'ordered' => Carbon::now(),
                                            'state' => 'pending',
                                            'shipping_method' => $shipping_method,
                                            'delivery' => $delivery_price,
                                            'subtotal' => \Cart::getSubtotal(),
                                            'client_aditional_notes' => $request->client_aditional_notes,
                                            'total' => \Cart::getTotal(),
                                            'code' => $code
                                        ]);
                                    } elseif ($request->address_type == 'new-address') {

                                        //Si el usuario apreta checkbox para guardar direccion en su perfil
                                        if ($request->save == 'on') {
                                            $address = Address::create([
                                                'street' => $request->client_street,
                                                'number' => $request->client_number,
                                                'floor' => $request->client_floor,
                                                'department' => $request->client_department,
                                                'user_id' => $user->id,
                                                'city_id' => 1 //Venado Tuerto - Unica ciudad
                                            ]);

                                            //Crea el pedido con la direccion creada recientemente
                                            $order = Order::create([
                                                'user_id' => $user->id,
                                                'address_id' => $address->id,
                                                'restaurant_id' => $request->restaurant_id,
                                                'ordered' => Carbon::now(),
                                                'state' => 'pending',
                                                'shipping_method' => $shipping_method,
                                                'delivery' => $delivery_price,
                                                'subtotal' => \Cart::getSubtotal(),
                                                'total' => \Cart::getTotal(),
                                                'client_aditional_notes' => $request->client_aditional_notes,
                                                'code' => $code
                                            ]);
                                        } else {
                                            //Crea el pedido con la direccion de paso
                                            $order = Order::create([
                                                'user_id' => $user->id,
                                                'restaurant_id' => $request->restaurant_id,
                                                'ordered' => Carbon::now(),
                                                'state' => 'pending',
                                                'shipping_method' => $shipping_method,
                                                'delivery' => $delivery_price,
                                                'subtotal' => \Cart::getSubtotal(),
                                                'total' => \Cart::getTotal(),
                                                'guest_street' => $request->client_street,
                                                'guest_number' => $request->client_number,
                                                'guest_floor' => $request->client_floor,
                                                'guest_department' => $request->client_department,
                                                'client_aditional_notes' => $request->client_aditional_notes,
                                                'code' => $code
                                            ]);
                                        }
                                    } //FIN-DIRECCION
                                } else {
                                    //Crea el pedido sin direccion de envio (retiro en local)
                                    $order = Order::create([
                                        'user_id' => $user->id,
                                        'restaurant_id' => $request->restaurant_id,
                                        'ordered' => Carbon::now(),
                                        'state' => 'pending',
                                        'shipping_method' => $shipping_method,
                                        'subtotal' => \Cart::getSubtotal(),
                                        'total' => \Cart::getTotal(),
                                        'client_aditional_notes' => $request->client_aditional_notes,
                                        'code' => $code
                                    ]);
                                }

                                $items = \Cart::getContent();

                                foreach ($items as $item) {
                                    LineItem::create([
                                        'order_id' => $order->id,
                                        'product_id' => $item->attributes->product_id,
                                        'price' => $item->price,
                                        'quantity' => $item->quantity,
                                        'variants' => $item->attributes->variants,
                                        'aditional_notes' => $item->attributes->aditional_notes
                                    ]);
                                }

                                \Cart::clear();

                                //WHATSAPP
                                $restaurant_owner = $restaurant->user;

                                //MENSAJE DE WHATSAPP AL COMERCIANTE
                                // $restaurant_owner->notify(new OrderProcessed($order));
                                //MAIL AL COMERCIANTE
                                //=================
                                $restaurant_owner->notify(new NewOrder($order));

                                DB::commit();
                                return true;
                            } catch (\Throwable $e) {
                                DB::rollback();
                                return false;
                            }
                        });
                    }
                } elseif ($request->auth_user == 'false') {

                    if (\Cart::getCondition('Delivery')) {

                        $request->validate([
                            'client_first_name' => 'required',
                            'client_last_name' => 'required',
                            'client_phone' => ['required', new validatePhone],
                            'client_street' => 'required',
                            'client_number' => 'required|numeric',
                        ]);
                    } else {
                        $request->validate([
                            'client_first_name' => 'required',
                            'client_last_name' => 'required',
                            'client_phone' => ['required', new validatePhone],
                        ]);
                    }

                    $transaction = DB::transaction(function () use ($request, $restaurant, $shipping_method, $code) {

                        try {
                            $phone = validatePhone($request->client_phone);

                            //CHECKEA SI EL PEDIDO ES CON DELIVERY O SIN (EN CASO DE QUE SEA RETIRO EN LOCAL NO REGISTRA DIRECCION)
                            if (\Cart::getCondition('Delivery')) {

                                $order = Order::create([
                                    'restaurant_id' => $request->restaurant_id,
                                    'ordered' => Carbon::now(),
                                    'state' => 'pending',
                                    'shipping_method' => $shipping_method,
                                    'delivery' => $restaurant->shipping_price,
                                    'subtotal' => \Cart::getSubtotal(),
                                    'total' => \Cart::getTotal(),
                                    'client_aditional_notes' => $request->client_aditional_notes,
                                    'guest_first_name' => $request->client_first_name,
                                    'guest_last_name' => $request->client_last_name,
                                    'guest_street' => $request->client_street,
                                    'guest_number' => $request->client_number,
                                    'guest_floor' => $request->client_floor,
                                    'guest_department' => $request->client_department,
                                    'guest_characteristic' => $phone['area'],
                                    'guest_phone' => $phone['local'],
                                    'code' => $code
                                ]);
                            } else {

                                $order = Order::create([
                                    'restaurant_id' => $request->restaurant_id,
                                    'ordered' => Carbon::now(),
                                    'state' => 'pending',
                                    'shipping_method' => $shipping_method,
                                    'delivery' => $restaurant->shipping_price,
                                    'subtotal' => \Cart::getSubtotal(),
                                    'total' => \Cart::getTotal(),
                                    'client_aditional_notes' => $request->client_aditional_notes,
                                    'guest_first_name' => $request->client_first_name,
                                    'guest_last_name' => $request->client_last_name,
                                    'guest_characteristic' => $phone['area'],
                                    'guest_phone' => $phone['local'],
                                    'code' => $code
                                ]);
                            }

                            $items = \Cart::getContent();

                            foreach ($items as $item) {
                                LineItem::create([
                                    'order_id' => $order->id,
                                    'product_id' => $item->attributes->product_id,
                                    'price' => $item->price,
                                    'quantity' => $item->quantity,
                                    'variants' => $item->attributes->variants,
                                    'aditional_notes' => $item->attributes->aditional_notes
                                ]);
                            }

                            \Cart::clear();

                            //WHATSAPP
                            $restaurant_owner = $restaurant->user;

                            //MENSAJE DE WHATSAPP AL COMERCIANTE
                            // $restaurant_owner->notify(new OrderProcessed($order));
                            //MAIL AL COMERCIANTE
                            //=================
                            $restaurant_owner->notify(new NewOrder($order));

                            DB::commit();
                            return true;
                        } catch (\Throwable $e) {
                            DB::rollback();
                            return false;
                        }
                    });
                }

                if ($transaction) {
                    return redirect()->route('confirmed.order', Crypt::encryptString($code));
                } else {
                    return redirect()->route('checkout.index')->with('error_message', 'Hubo un error y no se pudo procesar tu pedido, intente más tarde.');
                }
            } else {
                if (!\Cart::isEmpty()) {
                    \Cart::clear();
                }
                return back()->with('error_message', 'El comercio no recibe pedidos en este momento, intenta hacer tu pedido más tarde');
            }
        } else {
            return back()->with('error_message', 'Este comercio está cerrado, intenta hacer tu pedido más tarde');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $code = Crypt::decryptString($code);
        $order = Order::where('code', $code)->first();
        $items = LineItem::where('order_id', $order->id)->get();
        $restaurant = $order->restaurant;

        return view('thankyou')->with([
            'items' => $items,
            'order' => $order,
            'code' => $code,
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
