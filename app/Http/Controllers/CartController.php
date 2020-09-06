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

        if($product->variants==true){
            $variantsRule='required|array|min:'.$product->minimum_variants.'|max:'.$product->maximum_variants;
        }else{
            $variantsRule='nullable';
        }

        request()->validate([   
            'variants'=>$variantsRule
        ]);
        
        $restaurant = $product->restaurant;

        if($restaurant->isOpen()){
            if(\Cart::isEmpty()){
                if (count($product->getVariants)>0) {
                    \Cart::add(array(
                        'id' => generateCode(),
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $request->quantity,
                        'attributes' => ['variants'=>$request->variants, 'aditional_notes' => $request->aditional_notes],
                        'associatedModel' => $product
                    ));
                }else{
                    \Cart::add(array(
                        'id' => $request->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'attributes' => ['aditional_notes' => $request->aditional_notes],
                        'quantity' => $request->quantity,
                        'associatedModel' => $product
                    ));
                }

                if($restaurant->shipping_method == 'delivery' || $restaurant->shipping_method == 'delivery-pickup'){

                    $condition = new \Darryldecode\Cart\CartCondition(array(
                        'name' => 'Delivery',
                        'type' => 'tax',
                        'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                        'value' => $restaurant->shipping_price,
                        'attributes' => array( // attributes field is optional
                            'description' => 'Costo del envio'
                        )
                    ));

                    \Cart::condition($condition);
                }

                return view('carrito')->with('restaurant', $restaurant);

                // return redirect()->back()->with('success_message', 'Agregado al carrito con éxito');
            }else{
                $firstItem = \Cart::getContent()->first();
                
                if($product->restaurant->id == $firstItem->associatedModel->restaurant->id){
                    if (count($product->getVariants)>0) {
                        \Cart::add(array(
                            'id' => generateCode(),
                            'name' => $product->name,
                            'price' => $product->price,
                            'quantity' => $request->quantity,
                            'attributes' => ['variants'=>$request->variants, 'aditional_notes' => $request->aditional_notes],
                            'associatedModel' => $product
                        ));
                    }else{
                        \Cart::add(array(
                            'id' => $request->id,
                            'name' => $product->name,
                            'price' => $product->price,
                            'quantity' => $request->quantity,
                            'attributes' => ['aditional_notes' => $request->aditional_notes],
                            'associatedModel' => $product
                        ));
                    }

                    if($restaurant->shipping_method == 'delivery' || $restaurant->shipping_method == 'delivery-pickup'){
                    
                        $condition = new \Darryldecode\Cart\CartCondition(array(
                            'name' => 'Delivery',
                            'type' => 'tax',
                            'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                            'value' => $restaurant->shipping_price,
                            'attributes' => array( // attributes field is optional
                                'description' => 'Costo del envio'
                            )
                        ));

                        \Cart::condition($condition);
                    }

                    return view('carrito')->with('restaurant', $restaurant);

                }else{
                    return response()->json([
                        'errors'  => 'El producto debe ser del mismo comercio.',
                    ], 400);
                }
            }
        }else{
            return response()->json([
                'errors'  => 'Este comercio está cerrado, intenta hacer tu pedido más tarde',
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function empty(Request $request){
        $restaurant = Restaurant::findOrFail($request->restaurant);
        \Cart::clearCartConditions();
        \Cart::clear();
        
        return view('carrito')->with('restaurant', $restaurant);
        // return redirect()->back()->with('success_message', 'Carrito vaciado con éxito');
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
        $restaurant = Restaurant::findOrFail($request->restaurant);  

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
        }else{
            \Cart::removeCartCondition('Delivery');
        }
        
        if(\Cart::getCondition('Delivery')){
            $deliveryTax = $restaurant->shipping_price;
        }else{
            $deliveryTax = 0;
        }

        $data = [
            'subtotal' => \Cart::getSubtotal(),
            'total' => \Cart::getTotal(),
            'deliveryTax' => $deliveryTax
        ];

        return $data;
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

        $data = [
            'subtotal' => \Cart::getSubtotal(),
            'total' => \Cart::getTotal(),
            'itemPrice' => \Cart::get($id)->price,
            'items' => \Cart::getTotalQuantity()
        ];

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request)
    {
        \Cart::remove($request->id);

        $data = [
            'subtotal' => \Cart::getSubtotal(),
            'total' => \Cart::getTotal(),
            'items' => \Cart::getTotalQuantity()
        ];
        
        return $data;
    }
}
