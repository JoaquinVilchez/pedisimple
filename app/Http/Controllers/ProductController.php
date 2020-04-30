<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\RestaurantCategory;
use App\Category;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'productos-'.Auth::user()->restaurant->slug.'.xlsx');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        request()->validate([
            'method'=>'required',
            'file'=>'required'
        ]);

        $file = $request->file('file');
        $items = Excel::toCollection(new ProductsImport, $file);
        $restaurant = Auth::user()->restaurant;

        if($request->method == "update"){
            foreach($items as $item){
                for ($i=0; $i < count($item) ; $i++) { 
                    $category_name = $item[$i]['categoria'];
                    $category = Category::where('restaurant_id', $restaurant->id)->where('name', $category_name)->first();

                    if($category==null){
                        Category::create([
                            'name' => $category_name,
                            'state' => 'available',
                            'restaurant_id' => $restaurant->id
                        ]);

                        $category = Category::where('restaurant_id', $restaurant->id)->where('name', $category_name)->first();
                    }

                    if($item[$i]['token_no_borrar']==null){
                        Product::create([
                            'name' => $item[$i]['nombre'],
                            'details' => $item[$i]['descripcion'],
                            'price' => $item[$i]['precio'],
                            'category_id' => $category->id,
                            'restaurant_id' => $restaurant->id,
                        ]);

                    }else{
                        $product_id = decrypt($item[$i]['token_no_borrar']);
                        $product = Product::where('restaurant_id', $restaurant->id)->where('id', $product_id)->first();
                        $product->update([
                            'name' => $item[$i]['nombre'],
                            'details' => $item[$i]['descripcion'],
                            'price' => $item[$i]['precio'],
                            'category_id' => $category->id
                        ]);
                    }
                }
            }

        }elseif($request->method == "replace"){

            $products = Product::where('restaurant_id', $restaurant->id)->get();

            if($products!=null){
                foreach ($products as $product) {
                    $product->delete();
                }
            }
            
            foreach($items as $item){
                for ($i=0; $i < count($item) ; $i++) { 
                    $category_name = $item[$i]['categoria'];
                    $category = Category::where('restaurant_id', $restaurant->id)->where('name', $category_name)->first();

                    if($category==null){
                        Category::create([
                            'name' => $category_name,
                            'state' => 'available',
                            'restaurant_id' => $restaurant->id
                        ]);

                        $category = Category::where('restaurant_id', $restaurant->id)->where('name', $category_name)->first();
                    }

                    Product::create([
                        'name' => $item[$i]['nombre'],
                        'details' => $item[$i]['descripcion'],
                        'price' => $item[$i]['precio'],
                        'category_id' => $category->id,
                        'restaurant_id' => $restaurant->id,
                    ]);
                }
            }
        }//endif

        return redirect()->back()->with('success_message', 'Archivo importado con éxito');
    }

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
        request()->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required'
        ]);

        $restaurant_id = Auth::user()->restaurant->id;

        if($request->hasFile('image')){

            $file = $request->file('image');

            $path = $file->hashName();

            $image = Image::make($file)->encode('jpg', 75);
            
            $image->save('images/uploads/products/'.$path);               

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

            $path = $file->hashName();

            $image = Image::make($file)->encode('jpg', 75);
            
            if($old_image != 'no_image.png'){
                $path_old_image = 'images/uploads/products/'.$old_image;
                    unlink($path_old_image);
            }    

            $image->save('images/uploads/products/'.$path);         

            $product->update(['image'=>$path]);  
        }

        if($request->action==='delete'){
            $product->update(['image'=>'no_image.png']); 
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
    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->productid);
        $product->delete();
        return redirect(route('product.index'))->with('success_message', 'Producto eliminado con éxito');
    }

    public function destroyAll()
    {
        $products = Product::all();
        foreach($products as $product){
            $product->delete();
        }
        return redirect(route('product.index'))->with('success_message', 'Productos eliminados con éxito');
    }
}
