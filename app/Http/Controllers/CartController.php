<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Cart;
use App\Product;
use App\Restaurant;
use Carbon\Carbon;

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
        $product = Product::find($request->id);
        $restaurant = $product->restaurant;

        if(\Cart::isEmpty()){
            \Cart::add(array(
                'id' => $request->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'associatedModel' => $product
            ));

            return redirect()->back()->with('success_message', 'Agregado al carrito con éxito');
        }else{
            $firstItem = \Cart::getContent()->first();
            $product = Product::find($request->id);
            
            if($product->restaurant->id == $firstItem->model->restaurant->id){
                \Cart::add(array(
                    'id' => $request->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $request->quantity,
                    'associatedModel' => $product
                ));

                return redirect()->back()->with('success_message', 'Agregado al carrito con éxito');
            }else{
                return redirect()->back()->with('error_message', 'El producto debe ser del mismo comercio.');
            }

            // foreach (\Cart::getContent() as $item) {
            //     $item->attributes;
            // }

        }   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function empty(){
        \Cart::clearCartConditions();
        \Cart::clear();
        return redirect()->back()->with('success_message', 'Carrito vaciado con éxito');
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
    public function deliveryTax(Request $request)
    {
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        
        $condition = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'Delivery',
            'type' => 'tax',
            'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
            'value' => $restaurant->shipping_price,
            'attributes' => array( // attributes field is optional
                'description' => 'Costo del envio'
            )
        ));
        if($request->shipping_method == 'delivery'){
            \Cart::condition($condition);
            $option="delivery";
        }else{
            \Cart::clearCartConditions();
        $option="pickup";   
        }

        return redirect()->back()->with('option', $option);
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
        \Cart::update($id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity
            ),
        ));

        return redirect()->back()->with('success_message', 'Cantidad editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \Cart::remove($id);
        return redirect()->back()->with('success_message', 'Producto removido con éxito del carrito.');
    }
}
