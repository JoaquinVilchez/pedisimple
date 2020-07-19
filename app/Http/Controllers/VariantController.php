<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Variant;
use App\Product;

class VariantController extends Controller
{
    public function ajaxCreate(Request $request){
        request()->validate([
            'name' => 'required'
            ]);
                                    
        $variant = Variant::create([
            'name' => $request->name,
            'description' => $request->description,
            'state' => 'available',
            'restaurant_id' => Auth::user()->restaurant->id
        ]);
        return view('variantAjaxCreate')->with('variant', $variant);
    }

    public function showItemVariants(Request $request){
        $product = $request->product;
        $variants = Variant::find($request->variants);
        return view('showItemVariants')->with([
            'variants' => $variants,
            'product' => $product,
            'aditional_notes' => $request->aditional_notes
        ]);
    }

    public function getVariants(Request $request){
        $product = Product::find($request->productid);
        $variants = $product->getVariants;

        return view('restaurant.variants.show')->with([
            'variants' => $variants,
            'product' => $product
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $variants = Variant::where('restaurant_id', Auth::user()->restaurant->id)->paginate(15);

        return view('restaurant.variants.list')->with('variants', $variants);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = count(Product::where('restaurant_id', Auth::user()->restaurant->id)->get());
        return view('restaurant.variants.create')->with('products', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required'
        ]);

        Variant::create([
            'name' => $request->name,
            'description' => $request->description,
            'state' => $request->state,
            'restaurant_id' => Auth::user()->restaurant->id
        ]);

        return redirect(route('variant.index'))->with('success_message', 'Variante creada con éxito');
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
        $variant = Variant::find($id);
        $this->authorize('pass', $variant);

        return view('restaurant.variants.edit')->with('variant', $variant);
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
        $variant = Variant::findOrFail($id);
        $this->authorize('pass', $variant);

        $variant->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'state'=>$request->state
        ]);

        return redirect()->route('variant.index')->with('success_message', 'Variación editada con éxito');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
    {
        $variant = Variant::findOrFail($request->variantid);
        $this->authorize('pass', $variant);
        $variants = DB::table('products_variants')->where('variant_id', $request->variantid)->delete();
        $variant->delete();

        return redirect()->route('variant.index')->with('success_message', 'Variación eliminada con éxito');
    }
}
