<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Variant;
use App\Product;

class VariantController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function isAvailable(Request $request)
    {
        $variant = Variant::find($request->variant_id);

        if ($variant->state == 'available') {
            $variant->update(['state' => 'not-available']);
            return redirect()->back()->with('success_message', 'Variante cambiada a no disponible');
        } else {
            $variant->update(['state' => 'available']);
            return redirect()->back()->with('success_message', 'Variante cambiada a disponible');
        }
    }

    public function ajaxCreate(Request $request)
    {
        request()->validate([
            'name' => 'required'
        ]);

        $variant = Variant::create([
            'name' => $request->name,
            'state' => 'available',
            'restaurant_id' => Auth::user()->restaurant->id
        ]);
        return view('variantAjaxCreate')->with('variant', $variant);
    }

    public function showItemVariants(Request $request)
    {
        $product = $request->product;
        $variants = Variant::find($request->variants);
        return view('showItemVariants')->with([
            'variants' => $variants,
            'product' => $product,
            'aditional_notes' => $request->aditional_notes
        ]);
    }

    public function getVariants(Request $request)
    {
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
            'name' => $request->name,
            'state' => $request->state
        ]);

        return redirect()->route('variant.index')->with('success_message', 'Variante editada con éxito');
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

        DB::table('products_variants')->where('variant_id', $request->variantid)->delete();

        $variant->delete();

        return redirect()->route('variant.index')->with('success_message', 'Variante eliminada con éxito');
    }
}
