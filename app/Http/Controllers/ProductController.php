<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Product;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function isAvailable(Request $request)
    {
        $product = Product::find($request->product_id);
        if($product->state == 'available'){
            $product->update(['state'=>'not-available']);
            return redirect()->back()->with('success_message', 'Producto cambiado a no disponible');
        }else{
            $product->update(['state'=>'available']);
            return redirect()->back()->with('success_message', 'Producto cambiado a disponible');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $restaurant = $user->restaurant;
        $products = $restaurant->products()->orderBy('category_id', 'asc')->get();
        return view('restaurant.products.list')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Auth::user()->restaurant->categories;
        return view('restaurant.products.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $restaurant_id = Auth::user()->restaurant->id;

        if($request->hasFile('image')){

            $file = $request->file('image');

            $path = $file->hashName('public');

            $image = Image::make($file)->encode('jpg', 75);
            
            $image->fit(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            });

            Storage::put($path, (string) $image->encode());       

            Product::create([
                'name' => $request->name,
                'details' => $request->details,
                'price' => $request->price,
                'state' => $request->state,
                'category_id' => $request->category_id,
                'restaurant_id' => $restaurant_id,
                'image' => $path
            ]);

        }else{
            Product::create([
                'name' => $request->name,
                'details' => $request->details,
                'price' => $request->price,
                'state' => $request->state,
                'category_id' => $request->category_id,
                'restaurant_id' => $restaurant_id
            ]);
        }


        return redirect()->route('product.index')->with('success_message', 'Producto agregado con éxito');
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
        $product = Product::findOrFail($id);
        $categories = Auth::user()->restaurant->categories;
        return view('restaurant.products.edit')->with([
            'categories' => $categories,
            'product' => $product
        ]);
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
        $product = Product::findOrFail($id);

        $data=request()->validate([
            'name'=>'required',
            'details'=>'nullable',
            'price'=>'required',
            'state' => 'required',
            'category_id' => 'required',
            'restaurant_id' => 'nullable',
        ]);

        if($request->hasFile('image')){

            $old_image = $product->image;

            $file = $request->file('image');

            $path = $file->hashName('public');

            // dd($path);

            $image = Image::make($file)->encode('jpg', 75);
            
            // $image->fit(250, 250, function ($constraint) {
            //     $constraint->aspectRatio();
            // });

            if($old_image != 'public/no_image.png'){
                Storage::delete($old_image);
            }
            Storage::put($path, (string) $image->encode());

            $product->update(['image'=>$path]);  
        }

        if($request->action==='delete'){
            $product->update(['image'=>'public/no_image.png']); 
        }

        $product->update($data);
        return redirect(route('product.index'))->with('success_message', 'Producto editado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect(route('product.index'))->with('success_message', 'Producto eliminado con éxito');
    }
}
