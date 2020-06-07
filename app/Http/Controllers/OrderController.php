<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\User;
use Redirect;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function new(){
        Auth::user()->unreadNotifications->markAsRead();
        $orders = Auth::user()->restaurant->orders->where('state', 'pending')->sortDesc();
        return view('restaurant.orders.new')->with('orders', $orders);
    }

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function accepted(){
        $orders = Auth::user()->restaurant->orders->where('state', 'accepted')->sortDesc();
        return view('restaurant.orders.accepted')->with('orders', $orders);
    }

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function closed(){
        $orders = Auth::user()->restaurant->orders->where('state', 'closed')->sortDesc();
        return view('restaurant.orders.closed')->with('orders', $orders);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        $order = Order::find($request->acceptorderid);
        $order->update([
            'state' => 'accepted'
        ]);
        
        // Searching the internet I thought I could do it this way, but I found no result.
        $newUrl='https://wa.me/'.str_replace('-', '', whatsappNumberCustomer($order)).'?text='.urlencode(whatsappMessageCustomer($order));
        session()->flash('newurl', $newUrl);
        //===============================================================================

        return back()->with('success_message', 'Pedido aceptado.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request)
    {
        $order = Order::find($request->deleteorderid);
        $order->update([
            'state' => 'rejected'
        ]);

        return back()->with('success_message', 'Pedido rechazado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close(Request $request)
    {
        $order = Order::find($request->orderid);
        $order->update([
            'state' => 'closed'
        ]);

        return back()->with('success_message', 'Pedido cerrado.');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('user.order')->with('order', $order);
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
