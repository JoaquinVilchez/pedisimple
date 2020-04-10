<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;
use App\Product;
use Carbon\Carbon;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $product = Product::find($request->id);

            \Cart::session($userID)->add(array(
                'id' => $request->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'attributes' => array(),
                'associatedModel' => $product
            ));
                    
        return redirect()->back()->with('success_message', 'Agregado al carrito con exito');

    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function empty(){
        $userID = Auth::user()->id;

        \Cart::session($userID)->clear();
        return redirect()->back()->with('success_message', 'Carrito vaciado con exito');
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
    public function update(Request $request)
    {
        $userID = Auth::user()->id;
        \Cart::session($userID)->update($request->id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity
            ),
        ));

        return redirect()->back()->with('success_message', 'Cantidad editada con exito');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id){
        $userID = Auth::user()->id;
        \Cart::session($userID)->remove($id);
        return redirect()->back()->with('success_message', 'Producto removido con exito del carrito.');
    }
}
