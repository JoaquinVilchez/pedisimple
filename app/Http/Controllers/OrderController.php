<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Order;
use App\User;
use App\LineItem;
use Redirect;

class OrderController extends Controller
{
    public function getClosedDetails(Request $request){
        $order = Order::find($request->id);
        $items = LineItem::where('order_id', $order->id)->get();
        $restaurant = Auth::user()->restaurant;
        if($order->user_id!=null){
            $user = User::find($order->user_id)->toArray();
        }else{
            $user=[
                'first_name' => $order->guest_first_name,
                'last_name' => $order->guest_last_name,
                'number' => $order->guest_number,
                'floor' => $order->guest_floor,
                'department' => $order->guest_department,
                'characteristic' => $order->guest_characteristic,
                'phone' => $order->guest_phone,
                'image' => 'user.png'
            ];
        }
        
        return view('detailClosedOrderModal')->with([
            'order' => $order,
            'items' => $items,
            'user' => $user,
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function new(){
        Auth::user()->unreadNotifications->markAsRead();
        $orders = Order::where('restaurant_id', Auth::user()->restaurant->id)->where('state', 'pending')->orderBy('id','desc')->paginate(10);
        return view('restaurant.orders.new')->with('orders', $orders);
    }

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function accepted(){
        $orders = Order::where('restaurant_id', Auth::user()->restaurant->id)->where('state', 'accepted')->orderBy('id','desc')->paginate(10);
        return view('restaurant.orders.accepted')->with('orders', $orders);
    }

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function closed(){
        $orders = Order::where('restaurant_id', Auth::user()->restaurant->id)->where('state', 'closed')->orderBy('id','desc')->paginate(15);
        
        // Auth::user()->restaurant->orders->where('state', 'closed')->sortDesc();
        return view('restaurant.orders.closed')->with('orders', $orders);
    }

    /**
     * Remove the specified resource from storage.
     *0
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

        $newUrl='https://wa.me/549'.str_replace('-','',whatsappNumberCustomer($order)).'?text='.urlencode(whatsappMessageCustomer($order));
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

        $newUrl='https://wa.me/549'.str_replace('-','',whatsappNumberCustomer($order)).'?text='.urlencode(whatsappRejectOrderMessage($order));
        session()->flash('newurl', $newUrl);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        $order = Order::find($request->orderid);
        $order->update([
            'state' => 'canceled'
        ]);

        if ($request->send == 'on') {
            $newUrl='https://wa.me/549'.str_replace('-','',whatsappNumberCustomer($order)).'?text='.urlencode(whatsappCancelOrderMessage($order));
            session()->flash('newurl', $newUrl);
        }

        return back()->with('success_message', 'Pedido cancelado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request)
    {

        // dd($request->all());
        $order = Order::find($request->order['id']);
        if($request->order['shipping_method']=='delivery'){
            if($order->address_id==null){
                if($order->guest_street==null && $order->guest_number==null){
                    $request->validate([
                        'order.items' => 'required|array|min:1',
                        'order.street' => 'required',
                        'order.number' => 'required',
                        'order.floor' => 'nullable',
                        'order.department' => 'nullable'
                    ]);
                }else{
                    $request->validate([
                        'order.items' => 'required|array|min:1'
                    ]);
                }
            }else{
                $request->validate([
                    'order.items' => 'required|array|min:1'
                ]);
            }
        }else{
            $request->validate([
                'order.items' => 'required|array|min:1'
            ]);
        }

        $request = $request->order;

        $order->update([
            'shipping_method'=>$request['shipping_method'],
            'subtotal'=>$request['subtotal'],
            'total'=>$request['total']
        ]);

        if($request['shipping_method']=='delivery'){
            if($request['street']!=null && $request['number'] !=null){
                $order->update([
                    'guest_street' => $request['street'],
                    'guest_number' => $request['number'],
                    'guest_floor' => $request['floor'],
                    'guest_department' => $request['department'],
                ]);
            }
        }

        foreach($order->lineItems as $original_item){
            $original_item->delete();
        }

        foreach ($request['items'] as $new_item) {
            LineItem::create([
                'order_id'=>$order->id,
                'product_id'=>$new_item['product_id'],
                'price'=>$new_item['price'],
                'quantity'=>$new_item['quantity'],
                'variants'=>$new_item['variants'],
                'aditional_notes'=>$new_item['aditional_notes']
            ]);
        }   

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editOrder(Request $request)
    {
        $order = Order::find($request->orderid);        
        return view('editOrder')->with('order', $order);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(15);
        return view('user.orders')->with('orders', $orders);
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

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

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
