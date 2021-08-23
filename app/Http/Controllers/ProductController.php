<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product;
use App\Restaurant;
use App\RestaurantCategory;
use App\Category;
use App\Variant;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use Carbon\Carbon;
use Mail;
use App\Mail\NewTemporaryProduct;
use App\Notifications\UpdatePricesReminder;

class ProductController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPrices()
    {
        $products = Product::where('restaurant_id', Auth::user()->restaurant->id)->where('temporary', false)->where('state', '!=', 'removed')->get();
        $restaurant = Auth::user()->restaurant;

        foreach (Auth::user()->unreadNotifications->where('type', 'App\Notifications\UpdatePricesReminder') as $notification) {
            $notification->markAsRead();
        }

        return view('restaurant.products.updateprices')->with(['products' => $products, 'restaurant' => $restaurant]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePrices(Request $request)
    {
        for ($i = 0; $i < count($request->product); $i++) {
            $product = Product::find($request->product[$i]);
            $product->update([
                'price' => $request->price[$i]
            ]);
        }
        $restaurant = Restaurant::find(Auth::user()->restaurant->id);
        $restaurant->update([
            'shipping_price' => $request->delivery
        ]);

        return redirect('/productos/menu')->with('success_message', 'Precios actualizados con éxito');
    }


    public function showData(Request $request)
    {
        $product = Product::find($request->productid);
        $variants = $product->getVariants;

        $availableVariants = $variants->filter(function ($variant, $key) {
            return $variant->state == 'available';
        });

        return view('showData')->with([
            'variants' => $availableVariants,
            'product' => $product
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
        $today = Carbon::today()->toDateString();
        return Excel::download(new ProductsExport, 'productos-' . $today . '-' . Auth::user()->restaurant->slug . '.xlsx');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        request()->validate([
            'method' => 'required',
            'file' => 'required'
        ]);


        $file = $request->file('file');

        $items = Excel::toCollection(new ProductsImport, $file);

        $restaurant = Auth::user()->restaurant;

        if ($request->method == "update") {
            $errors = 0;
            foreach ($items as $item) {
                for ($i = 0; $i < count($item); $i++) {

                    $price = $item[$i]['precio'];

                    if (substr($price, 0, 1) == '$') {
                        $price = substr($price, 1);
                        $price = floatval($price);
                    }

                    if ($item[$i]['nombre'] == null || $price == null || $item[$i]['categoria'] == null) {
                        $errors = $errors + 1;
                    } else {

                        if ($item[$i]['variantes'] != null && $item[$i]['variantes_maximo'] == null) {
                            $errors = $errors + 1;
                        } else {
                            if ($item[$i]['variantes_maximo'] < $item[$i]['variantes_minimo']) {
                                $errors = $errors + 1;
                            } else {

                                //CATEGORIA

                                $category_name = $item[$i]['categoria'];
                                $category = Category::where('restaurant_id', $restaurant->id)->where('name', $category_name)->first();

                                if ($category == null) {
                                    Category::create([
                                        'name' => $category_name,
                                        'state' => 'available',
                                        'restaurant_id' => $restaurant->id
                                    ]);

                                    $category = Category::where('restaurant_id', $restaurant->id)->where('name', $category_name)->first();
                                }

                                //FIN-CATEGORIA

                                //VARIANTES MAXIMO MINIMO
                                if ($item[$i]['variantes'] != null) {
                                    $variants = true;

                                    if ($item[$i]['variantes_maximo'] > count(explode(',', $item[$i]['variantes']))) {
                                        $item[$i]['variantes_maximo'] = count(explode(',', $item[$i]['variantes']));
                                    }
                                } else {
                                    $variants = false;
                                }
                                //FIN VARIANTES MAXIMO MINIMO

                                //PRODUCTO

                                if ($item[$i]['token_no_borrar'] != null) {
                                    $product_id = decrypt($item[$i]['token_no_borrar']);
                                    $product = Product::where('restaurant_id', $restaurant->id)->where('state', '!=', 'removed')->where('id', $product_id)->first();
                                }

                                if ($item[$i]['token_no_borrar'] == null || $product == null) {
                                    $product = Product::create([
                                        'name' => $item[$i]['nombre'],
                                        'details' => $item[$i]['descripcion'],
                                        'price' => $price,
                                        'category_id' => $category->id,
                                        'restaurant_id' => $restaurant->id,
                                        'variants' => $variants,
                                        'minimum_variants' => $item[$i]['variantes_minimo'],
                                        'maximum_variants' => $item[$i]['variantes_maximo']
                                    ]);
                                } else {
                                    if ($product !== null) {
                                        $product->update([
                                            'name' => $item[$i]['nombre'],
                                            'details' => $item[$i]['descripcion'],
                                            'price' => $price,
                                            'category_id' => $category->id,
                                            'variants' => $variants,
                                            'minimum_variants' => $item[$i]['variantes_minimo'],
                                            'maximum_variants' => $item[$i]['variantes_maximo']
                                        ]);
                                    }
                                }

                                //FIN-PRODUCTO

                                //VARIANTES

                                $old_variants_array = [];
                                if (isset($product->getVariants)) {
                                    $old_variants = $product->getVariants;
                                    foreach ($old_variants as $old_variant) {
                                        $old_variant = DB::table('variants')->where('id', $old_variant->id)->where('restaurant_id', $restaurant->id)->get();
                                        array_push($old_variants_array, $old_variant);
                                    }
                                } else {
                                    $old_variants = null;
                                }

                                $new_variants_array = [];

                                if ($item[$i]['variantes'] != null) {
                                    $new_variants = explode(',', $item[$i]['variantes']);

                                    foreach ($new_variants as $new_variant) {
                                        $new_variant_name = strtolower(trim($new_variant));
                                        $new_variant = DB::table('variants')->where('name', $new_variant_name)->where('restaurant_id', $restaurant->id)->get();
                                        if (count($new_variant) == 0) {
                                            $new_variant = Variant::create([
                                                'name' => ucfirst($new_variant_name),
                                                'restaurant_id' => $restaurant->id
                                            ]);
                                            $new_variant = DB::table('variants')->where('id', $new_variant->id)->get();
                                        }
                                        array_push($new_variants_array, $new_variant);
                                    }
                                }

                                if (!empty($old_variants_array)) {
                                    $array_difference = array_diff($old_variants_array, $new_variants_array);
                                    foreach ($array_difference as $old_variant_to_delete) {
                                        DB::table('products_variants')->where('product_id', $product->id)->where('variant_id', $old_variant_to_delete[0]->id)->delete();
                                    }
                                }

                                if ($item[$i]['variantes'] != null) {
                                    if (!empty($new_variants_array)) {
                                        foreach ($new_variants_array as $new_variant_to_add) {
                                            $exists = DB::table('products_variants')->where('product_id', $product->id)->where('variant_id', $new_variant_to_add[0]->id)->first();
                                            if ($exists == null) {
                                                DB::table('products_variants')->insert([
                                                    'product_id' => $product->id,
                                                    'variant_id' => $new_variant_to_add[0]->id,
                                                ]);
                                            }
                                        }
                                    }
                                }
                                //FIN - VARIANTES
                            }
                        }
                    }
                }
            }
        } elseif ($request->method == "replace") {

            $errors = 0;
            $products = Product::where('restaurant_id', $restaurant->id)->where('state', '!=', 'removed')->where('temporary', false)->get();

            if ($products != null) {
                foreach ($products as $product) {

                    $variants = $product->getVariants;
                    if ($variants != null) {
                        foreach ($variants as $variant) {
                            DB::table('products_variants')->where('product_id', $product->id)->where('variant_id', $variant->id)->delete();
                        }
                    }

                    if ($product->lineItem->count() > 0) {
                        $product->update(['state' => 'removed']);
                    } else {
                        $product->delete();
                    }
                }
            }

            foreach ($items as $item) {
                for ($i = 0; $i < count($item); $i++) {

                    $price = $item[$i]['precio'];

                    if (substr($price, 0, 1) == '$') {
                        $price = substr($price, 1);
                        $price = floatval($price);
                    }

                    if ($item[$i]['nombre'] == null || $price == null || $item[$i]['categoria'] == null) {
                        $errors = $errors + 1;
                    } else {
                        $category_name = $item[$i]['categoria'];
                        $category = Category::where('restaurant_id', $restaurant->id)->where('name', $category_name)->first();

                        if ($category == null) {
                            Category::create([
                                'name' => $category_name,
                                'state' => 'available',
                                'restaurant_id' => $restaurant->id
                            ]);

                            $category = Category::where('restaurant_id', $restaurant->id)->where('name', $category_name)->first();
                        }

                        //VARIANTES MAXIMO MINIMO
                        if ($item[$i]['variantes'] != null) {
                            $variants = true;

                            if ($item[$i]['variantes_maximo'] > count(explode(',', $item[$i]['variantes']))) {
                                $item[$i]['variantes_maximo'] = count(explode(',', $item[$i]['variantes']));
                            }
                        } else {
                            $variants = false;
                        }
                        //FIN VARIANTES MAXIMO MINIMO

                        //PRODUCTO

                        $product_id = decrypt($item[$i]['token_no_borrar']);
                        $product = Product::where('restaurant_id', $restaurant->id)->where('state', '!=', 'removed')->where('id', $product_id)->first();

                        if ($item[$i]['token_no_borrar'] == null || $product == null) {
                            $product = Product::create([
                                'name' => $item[$i]['nombre'],
                                'details' => $item[$i]['descripcion'],
                                'price' => $price,
                                'category_id' => $category->id,
                                'restaurant_id' => $restaurant->id,
                                'variants' => $variants,
                                'minimum_variants' => $item[$i]['variantes_minimo'],
                                'maximum_variants' => $item[$i]['variantes_maximo']
                            ]);
                        } else {
                            if ($product !== null) {
                                $product->update([
                                    'name' => $item[$i]['nombre'],
                                    'details' => $item[$i]['descripcion'],
                                    'price' => $price,
                                    'category_id' => $category->id,
                                    'variants' => $variants,
                                    'minimum_variants' => $item[$i]['variantes_minimo'],
                                    'maximum_variants' => $item[$i]['variantes_maximo']
                                ]);
                            }
                        }

                        //FIN PRODUCTO

                        //VARIANTES

                        $new_variants_array = [];

                        if ($item[$i]['variantes'] != null) {
                            $new_variants = explode(',', $item[$i]['variantes']);

                            foreach ($new_variants as $new_variant) {
                                $new_variant_name = strtolower(trim($new_variant));
                                $new_variant = DB::table('variants')->where('name', $new_variant_name)->where('restaurant_id', $restaurant->id)->get();
                                if (count($new_variant) == 0) {
                                    $new_variant = Variant::create([
                                        'name' => ucfirst($new_variant_name),
                                        'restaurant_id' => $restaurant->id
                                    ]);
                                    $new_variant = DB::table('variants')->where('id', $new_variant->id)->get();
                                }
                                array_push($new_variants_array, $new_variant);
                            }
                        }

                        if ($item[$i]['variantes'] != null) {
                            if (!empty($new_variants_array)) {
                                foreach ($new_variants_array as $new_variant_to_add) {
                                    $exists = DB::table('products_variants')->where('product_id', $product->id)->where('variant_id', $new_variant_to_add[0]->id)->first();
                                    if ($exists == null) {
                                        DB::table('products_variants')->insert([
                                            'product_id' => $product->id,
                                            'variant_id' => $new_variant_to_add[0]->id,
                                        ]);
                                    }
                                }
                            }
                        }
                        //FIN - VARIANTES
                    }
                }
            }
        } //endif

        if ($errors > 0) {
            return redirect()->back()->with('success_message', 'Archivo importado con éxito')->with('error_message', $errors . ' producto/s no fueron importados. Los campos nombre, precio y categoria son obligatorios.');
        } else {
            return redirect()->back()->with('success_message', 'Archivo importado con éxito');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function isAvailable(Request $request)
    {
        $product = Product::find($request->product_id);
        $this->authorize('pass', $product);

        if ($product->state == 'available') {
            $product->update(['state' => 'not-available']);
            return redirect()->back()->with('success_message', 'Producto cambiado a no disponible');
        } else {
            $product->update(['state' => 'available']);
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
        $products = Product::where('restaurant_id', $restaurant->id)
            ->where('temporary', false)
            ->where('state', '!=', 'removed')
            ->orderBy('state', 'asc')
            ->paginate(45);

        return view('restaurant.products.list')->with('products', $products);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function temporaries()
    {
        $user = Auth::user();
        $restaurant = $user->restaurant;
        $products = $restaurant->products()->where('temporary', true)->where('state', '!=', 'removed')->orderBy('created_at', 'desc')->get();
        return view('restaurant.products.temporaries')->with('products', $products);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stopTemporaryProduct(Request $request)
    {
        $product = Product::find($request->productid);
        $today = Carbon::today()->toDateString();

        $product->update([
            'end_date' => $today
        ]);

        return redirect()->route('product.temporaries');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Auth::user()->restaurant->categories->where('state', '!=', 'removed');
        $variants = Variant::where('restaurant_id', Auth::user()->restaurant->id)->get();
        return view('restaurant.products.create')->with([
            'categories' => $categories,
            'variants' => $variants
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has_variants == 'on') {
            $minimumRule = 'required|numeric|min:' . $request->minimum;
            $maximumRule = 'required|numeric|gte:' . $request->maximum;
            $variantsRule = 'required|array';
        } else {
            $minimumRule = 'nullable';
            $maximumRule = 'nullable';
            $variantsRule = 'nullable';
        }

        if ($request->temporary == 'on') {
            $categoryRule = 'nullable';
            $startDateRule = 'required|date_format:d/m/Y|before:end_date';
            $endDateRule = 'required|date_format:d/m/Y|after:start_date';
        } else {
            $categoryRule = 'required';
            $startDateRule = 'nullable';
            $endDateRule = 'nullable';
        }

        request()->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => $categoryRule,
            'start_date' => $startDateRule,
            'end_date' => $endDateRule,
            'minimum' => $minimumRule,
            'maximum' => $maximumRule,
            'variants' => $variantsRule
        ]);



        $restaurant_id = Auth::user()->restaurant->id;

        //DATOS DE IMAGEN
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $path = $file->hashName();

            $image = Image::make($file)->fit(785, 785, function ($constraint) {
                $constraint->aspectRatio();
            })->crop(785, 785)->encode('jpg', 75);

            Storage::put("public/uploads/products/" . $path, $image->__toString());
        } else {
            $path = 'no_image.png';
        }

        //DATOS DE FECHA TEMPORAL
        if ($request->temporary == 'on') {
            $temporary = true;
            $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
            $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date);
        } else {
            $temporary = false;
            $startDate = null;
            $endDate = null;
        }

        //DATOS DE CATEGORIA
        if ($request->category_id == null) {
            $category = null;
        } else {
            $category = $request->category_id;
        }

        if ($request->has_variants == 'on') {
            $variants = true;
            $minimum_variants = $request->minimum;
            $maximum_variants = $request->maximum;
        } else {
            $variants = false;
            $minimum_variants = null;
            $maximum_variants = null;
        }

        $product = Product::create([
            'name' => $request->name,
            'details' => $request->details,
            'price' => $request->price,
            'state' => $request->state,
            'category_id' => $category,
            'restaurant_id' => $restaurant_id,
            'image' => $path,
            'temporary' => $temporary,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'variants' => $variants,
            'minimum_variants' => $minimum_variants,
            'maximum_variants' => $maximum_variants,
        ]);

        if ($request->has_variants == 'on') {
            foreach ($request->variants as $variant) {
                DB::table('products_variants')->insert([
                    'product_id' => $product->id,
                    'variant_id' => $variant,
                ]);
            }
        }

        if ($request->temporary == 'on') {
            Mail::to("contacto@pedisimple.com")->send(new NewTemporaryProduct(Auth::user()->restaurant, $product));
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
        $this->authorize('pass', $product);

        $categories = Auth::user()->restaurant->categories;
        $variants = Variant::where('restaurant_id', Auth::user()->restaurant->id)->get();

        return view('restaurant.products.edit')->with([
            'categories' => $categories,
            'product' => $product,
            'variants' => $variants
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
        $this->authorize('pass', $product);

        if ($request->has_variants == 'on') {
            $minimumRule = 'required|numeric|min:' . $request->minimum;
            $maximumRule = 'required|numeric|gte:' . $request->maximum;
            $variantsRule = 'required|array';
        } else {
            $minimumRule = 'nullable';
            $maximumRule = 'nullable';
            $variantsRule = 'nullable';
        }

        if ($request->temporary == 'on') {
            $temporaryRule = 'required';
            $categoryRule = 'nullable';
            $startDateRule = 'required|date_format:d/m/Y|before:end_date';
            $endDateRule = 'required|date_format:d/m/Y|after:start_date';
        } else {
            $temporaryRule = 'nullable';
            $categoryRule = 'required';
            $startDateRule = 'nullable';
            $endDateRule = 'nullable';
        }

        request()->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => $categoryRule,
            'temporary' => $temporaryRule,
            'start_date' => $startDateRule,
            'end_date' => $endDateRule,
            'minimum' => $minimumRule,
            'maximum' => $maximumRule,
            'variants' => $variantsRule
        ]);

        if ($request->hasFile('image')) {

            $old_image = $product->image;

            $file = $request->file('image');

            $path = $file->hashName();

            $image = Image::make($file)->fit(785, 785, function ($constraint) {
                $constraint->aspectRatio();
            })->crop(785, 785)->encode('jpg', 75);

            if ($old_image != 'no_image.png') {
                Storage::delete('public/uploads/products/' . $old_image);
            }

            Storage::put("public/uploads/products/" . $path, $image->__toString());

            $product->update(['image' => $path]);
        }

        if ($request->delete_image == 'yes') {
            Storage::delete('public/uploads/products/' . $product->image);
        }

        if ($request->action === 'delete') {
            $product->update(['image' => 'no_image.png']);
        }

        if ($request->has_variants == "on") {
            $variants = $product->getVariants;
            $new_variants = $request->variants;

            $old_variants = [];

            foreach ($variants as $variant) {
                array_push($old_variants, $variant->id);
            }

            if ($request->variants == null) {
                $old_variants = $product->getVariants;
                if (count($old_variants) > 0) {
                    foreach ($old_variants as $variant) {
                        DB::table('products_variants')->where('product_id', $product->id)->where('variant_id', $variant->id)->delete();
                    }
                }
                $has_variants = false;
                $maximum = null;
                $minimum = null;
            } else {
                $remove_variants = array_diff($old_variants, $new_variants);
                $add_variants = array_diff($new_variants, $old_variants);
                foreach ($remove_variants as $remove_variant) {
                    DB::table('products_variants')->where('product_id', $product->id)->where('variant_id', $remove_variant)->delete();
                }

                foreach ($add_variants as $add_variant) {
                    DB::table('products_variants')->insert([
                        'product_id' => $product->id,
                        'variant_id' => $add_variant,
                    ]);
                }
                $has_variants = true;
                $maximum = $request->maximum;
                $minimum = $request->minimum;
            }
        } else {
            if (isset($product->getVariants) > 0) {
                foreach ($product->getVariants as $variant) {
                    DB::table('products_variants')->where('product_id', $product->id)->where('variant_id', $variant->id)->delete();
                }
                $has_variants = false;
                $maximum = null;
                $minimum = null;
            }
        }

        //DATOS DE FECHA TEMPORAL
        if ($request->temporary == true) {
            $temporary = true;
            $startTemporaryDate = Carbon::createFromFormat('d/m/Y', $request->start_date);
            $endTemporaryDate = Carbon::createFromFormat('d/m/Y', $request->end_date);

            // dd($request->start_date, $request->end_date, $startTemporaryDate, $endTemporaryDate);

        } else {
            $temporary = false;
            $startTemporaryDate = null;
            $endTemporaryDate = null;
        }

        //DATOS DE CATEGORIA
        if ($request->category_id == null) {
            $category = null;
        } else {
            $category = $request->category_id;
        }

        $product->update([
            'name' => $request->name,
            'details' => $request->details,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'state' => $request->state,
            'temporary' => $temporary,
            'start_date' => $startTemporaryDate,
            'end_date' => $endTemporaryDate,
            'variants' => $has_variants,
            'maximum_variants' => $maximum,
            'minimum_variants' => $minimum
        ]);

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
        $this->authorize('pass', $product);

        if (count($product->getVariants) > 0) {
            foreach ($product->getVariants as $variant) {
                DB::table('products_variants')->where('product_id', $product->id)->where('variant_id', $variant->id)->delete();
            }
        }

        if ($product->lineItem->count() > 0) {
            $product->update([
                'state' => 'removed'
            ]);
        } else {
            $old_image = $product->image;

            if ($old_image != 'no_image.png') {
                $path_old_image = 'images/uploads/products/' . $old_image;
                if (file_exists($path_old_image)) {
                    unlink($path_old_image);
                }
            }

            $product->delete();
        }
        return redirect()->back()->with('success_message', 'Producto eliminado con éxito');
    }

    public function destroyAll()
    {

        $products = Product::where('restaurant_id', Auth::user()->restaurant->id)->get();
        foreach ($products as $product) {
            $this->authorize('pass', $product);

            if ($product->temporary == false) {
                if (count($product->getVariants) > 0) {
                    foreach ($product->getVariants as $variant) {
                        DB::table('products_variants')->where('product_id', $product->id)->where('variant_id', $variant->id)->delete();
                    }
                }

                if ($product->lineItem->count() > 0) {
                    $product->update([
                        'state' => 'removed'
                    ]);
                } else {
                    $old_image = $product->image;

                    if ($old_image != 'no_image.png') {
                        $path_old_image = 'images/uploads/products/' . $old_image;
                        if (file_exists($path_old_image)) {
                            unlink($path_old_image);
                        }
                    }

                    $product->delete();
                }
            }
        }
        return redirect(route('product.index'))->with('success_message', 'Productos eliminados con éxito');
    }
}
