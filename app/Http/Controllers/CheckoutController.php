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
use PDF;
use App\Notifications\OrderProcessed;
use App\Notifications\NewOrder;

class CheckoutController extends Controller
{

    public function download(Order $order){
        $items = $order->lineitems;
        $logo = asset('images/logo.png');
        $pdf = PDF::loadView('pdf.receipt', array('order' => $order, 'items' => $items, 'logo' => $logo));
        return $pdf->stream();
    }

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

    //OPTIMIZACION: SE PUEDE HACER UN ARRAY $args QUE CONTENGA LOS CAMPOS GENERALES A USAR
    //EN CREATE Y VALIDATE Y DEPENDIENDO DE LAS CONDICIONES IR AGREGANDOLE LAS CARACTERISTICAS
    //QUE FALTEN CON UNA FUNCION DE AGREGAR ELEMENTOS A ARRAY. ESTO ES PARA NO REPETIR TANTO CODIGO

    $restaurant = Restaurant::find($request->restaurant_id);
    if($restaurant->isOpen()){
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

            $user = Auth::user();

            if($user->restaurant == $restaurant){
                return back()->with('error_message', 'No puedes hacer un pedido a tu propio comercio.');
            }else{
                //CHECKEA SI EL PEDIDO ES CON DELIVERY O SIN (EN CASO DE QUE SEA RETIRO EN LOCAL NO REGISTRA DIRECCION)
                if (\Cart::getCondition('Delivery')) {

                    $delivery_price = \Cart::getCondition('Delivery')->getValue();
                    //DIRECCION
                    if($request->address_type=='data-address') {

                        $request->validate([
                            'address' => 'required'
                        ]);

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

                    }elseif($request->address_type=='new-address'){
                        
                        $request->validate([
                            'client_street' => 'required',
                            'client_number' => 'required|numeric'
                        ]);

                        //Si el usuario apreta checkbox para guardar direccion en su perfil
                        if($request->save=='on'){
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

                        }else{
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
                    }//FIN-DIRECCION  
                }else{
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
            }            
        
        }elseif($request->auth_user=='false'){
            
            //CHECKEA SI EL PEDIDO ES CON DELIVERY O SIN (EN CASO DE QUE SEA RETIRO EN LOCAL NO REGISTRA DIRECCION)
            if (\Cart::getCondition('Delivery')) {

                $request->validate([
                    'client_first_name' => 'required',
                    'client_last_name' => 'required',
                    'client_characteristic' => 'required|numeric|min:4',
                    'client_phone' => 'required|numeric|min:6',
                    'client_street' => 'required',
                    'client_number' => 'required|numeric',
                ]);

                $delivery_price = \Cart::getCondition('Delivery')->getValue();
                $order = Order::create([
                    'restaurant_id' => $request->restaurant_id,
                    'ordered' => Carbon::now(),
                    'state' => 'pending',
                    'shipping_method' => $shipping_method,
                    'delivery' => $delivery_price,
                    'subtotal' => \Cart::getSubtotal(),
                    'total' => \Cart::getTotal(),
                    'client_aditional_notes' => $request->client_aditional_notes,
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
                $request->validate([
                    'client_first_name' => 'required',
                    'client_last_name' => 'required',
                    'client_characteristic' => 'required|numeric|min:4',
                    'client_phone' => 'required|numeric|min:6'
                ]);

                $order = Order::create([
                    'restaurant_id' => $request->restaurant_id,
                    'ordered' => Carbon::now(),
                    'state' => 'pending',
                    'shipping_method' => $shipping_method,
                    'subtotal' => \Cart::getSubtotal(),
                    'total' => \Cart::getTotal(),
                    'client_aditional_notes' => $request->client_aditional_notes,
                    'guest_first_name' => $request->client_first_name,
                    'guest_last_name' => $request->client_last_name,
                    'guest_characteristic' => $request->client_characteristic,
                    'guest_phone' => $request->client_phone,
                    'code' => $code
                ]);
            }
    
        }

        // $order = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
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
        $restaurant_owner = $restaurant->user;
        
        //MENSAJE DE WHATSAPP AL COMERCIANTE
        // $restaurant_owner->notify(new OrderProcessed($order));
        //MAIL AL COMERCIANTE
        //=================
        $restaurant_owner->notify(new NewOrder($order));

        return redirect()->route('confirmed.order', Crypt::encryptString($code));
    }else{
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
