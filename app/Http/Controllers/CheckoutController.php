<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;
use Auth;
use Carbon\Carbon;
use App\Order;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('checkout');
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
        $userID = Auth::user()->id;

        //GENERAR UN CODIGO Y GUARDARLO EN UNA VARIABLE PARA GUARDARLO EN EL ORDER Y DESPEUS PODER BUSCAR LA ORDER CON ESE CODE.

        Order::create([
            'user_id' => $userID,
            'restaurant_id' => $request->restaurant_id,
            'ordered' => Carbon::now(),
            'state' => 'pendiente',
            'shipping_method' => $request->shipping_method,
            'total' => \Cart::session($userID)->getTotal()
        ]);

        $order = Order::where('user_id', $userID)->orderBy('created_at', 'desc')->first();
        $items = \Cart::session($userID)->getContent();

        foreach ($items as $item) {
        DB::table('line_items')->insert([
                ['order_id' => $order->id, 'product_id' => $item->id, 'quantity' => $item->quantity]
            ]);
        }

        \Cart::session($userID)->clear();
        return view('thankyou')->with([
            'items' => $items,
            'order' => $order    
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
