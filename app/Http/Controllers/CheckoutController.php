<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Cart;
use Carbon\Carbon;
use App\Order;
use App\Product;
use App\Address;
use App\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\LineItem;
use App\Notifications\OrderProcessed;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Cart::isEmpty()) {
            return view('checkout');
        }else{
            foreach(\Cart::getContent() as $item) { 
                $itemId = $item->id;
                if($itemId!=null){
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
    public function store(Request $request){
    //CREAR CODIGO
        //Genera un codigo de referencia para el pedido
        do {
            $code = generateCode();
            $oderCode=Order::where('code', $code)->first();
        }while ($oderCode!=null);

    //CHECKEA METODO DE ENVIO
        if(\Cart::getCondition('Delivery')){
            $shipping_method = 'delivery';
        }else{
            $shipping_method = 'pickup';
        }

    //CREAR PEDIDO
        if($request->auth_user=='true'){
            $userID = Auth::user()->id;

            //CHECKEA SI EL PEDIDO ES CON DELIVERY O SIN (EN CASO DE QUE SEA RETIRO EN LOCAL NO REGISTRA DIRECCION)
            if (\Cart::getCondition('Delivery')) {
                //DIRECCION
                if($request->address_type=='data-address') {

                    $address = Address::find($request->address);
                    $delivery_price = \Cart::getCondition('Delivery')->getValue();
                    //Crea el pedido con la direccion registrada previamente del usuario
                    $order = Order::create([
                        'user_id' => $userID,
                        'address_id' => $address->id,
                        'restaurant_id' => $request->restaurant_id,
                        'ordered' => Carbon::now(),
                        'state' => 'pending',
                        'shipping_method' => $shipping_method,
                        'delivery' => $delivery_price,
                        'subtotal' => \Cart::getSubtotal(),
                        'total' => \Cart::getTotal(),
                        'code' => $code
                    ]);

                }elseif($request->address_type=='new-address'){
                    
                    //Si el usuario apreta checkbox para guardar direccion en su perfil
                    if($request->save=='on'){
                        $address = Address::create([
                            'street' => $request->client_street,
                            'number' => $request->client_number,
                            'floor' => $request->client_floor,
                            'department' => $request->client_department,
                            'user_id' => $userID,
                            'city_id' => 1 //Venado Tuerto - Unica ciudad
                        ]);
                        
                        //Crea el pedido con la direccion creada recientemente
                        $order = Order::create([
                            'user_id' => $userID,
                            'address_id' => $address->id,
                            'restaurant_id' => $request->restaurant_id,
                            'ordered' => Carbon::now(),
                            'state' => 'pending',
                            'shipping_method' => $shipping_method,
                            'delivery' => $delivery_price,
                            'subtotal' => \Cart::getSubtotal(),
                            'total' => \Cart::getTotal(),
                            'code' => $code
                        ]);

                    }else{
                        //Crea el pedido con la direccion de paso
                        $order = Order::create([
                            'user_id' => $userID,
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
                            'code' => $code
                        ]);
                    }
                }//FIN-DIRECCION  
            }else{
                //Crea el pedido sin direccion de envio (retiro en local)
                $order = Order::create([
                    'user_id' => $userID,
                    'restaurant_id' => $request->restaurant_id,
                    'ordered' => Carbon::now(),
                    'state' => 'pending',
                    'shipping_method' => $shipping_method,
                    'subtotal' => \Cart::getSubtotal(),
                    'total' => \Cart::getTotal(),
                    'code' => $code
                ]);
            }
            
        
        }elseif($request->auth_user=='false'){
            
            //CHECKEA SI EL PEDIDO ES CON DELIVERY O SIN (EN CASO DE QUE SEA RETIRO EN LOCAL NO REGISTRA DIRECCION)
            if (\Cart::getCondition('Delivery')) {
                $order = Order::create([
                    'restaurant_id' => $request->restaurant_id,
                    'ordered' => Carbon::now(),
                    'state' => 'pending',
                    'shipping_method' => $shipping_method,
                    'delivery' => $delivery_price,
                    'subtotal' => \Cart::getSubtotal(),
                    'total' => \Cart::getTotal(),
                    'guest_first_name' => $request->client_first_name,
                    'guest_last_name' => $request->client_last_name,
                    'guest_street' => $request->client_street,
                    'guest_number' => $request->client_number,
                    'guest_floor' => $request->client_floor,
                    'guest_department' => $request->client_department,
                    'guest_characteristic' => $request->client_characteristic,
                    'guest_phone' => $request->client_phone,
                    'code' => $code
                ]);
            }else{
                $order = Order::create([
                    'restaurant_id' => $request->restaurant_id,
                    'ordered' => Carbon::now(),
                    'state' => 'pending',
                    'shipping_method' => $shipping_method,
                    'total' => \Cart::getTotal(),
                    'code' => $code
                ]);
            }
    
        }

        // $order = Order::where('user_id', $userID)->orderBy('created_at', 'desc')->first();
        $items = \Cart::getContent();

        foreach ($items as $item) {
            LineItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity
            ]);
        }

        \Cart::clear();

        //WHATSAPP
        $restaurant = Restaurant::find($request->restaurant_id);
        $restaurant_owner = $restaurant->user;
        $restaurant_owner->notify(new OrderProcessed($order));

        return redirect()->route('confirmed.order', Crypt::encryptString($code));
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

        // dd($code,$order,$items);

        return view('thankyou')->with([
            'items' => $items,
            'order' => $order,
            'code' => $code,
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
