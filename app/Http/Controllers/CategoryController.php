<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Product;


class CategoryController extends Controller
{

    public function reorder(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer',
            ]);
            

        foreach ($request->ids as $index => $id) {
            DB::table('categories')
                ->where('id', $id)
                ->update([
                    'position' => $index + 1
                ]);
        }



        return response(null, Response::HTTP_NO_CONTENT);
    }

    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function isAvailable(Request $request)
    {
        $category = Category::find($request->category_id);
        $this->authorize('pass', $category);

        if($category->state == 'available'){
            $category->update(['state'=>'not-available']);
            return redirect()->back()->with('success_message', 'Categoria cambiada a no disponible');
        }else{
            $category->update(['state'=>'available']);
            return redirect()->back()->with('success_message', 'Categoria cambiada a disponible');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Auth::user()->restaurant->categories->sortBy('position');
        return view('restaurant.categories.list')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.categories.create');
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
            'state' => 'required'
        ]);

        $restaurant_id = Auth::user()->restaurant->id;

        Category::create([
            'name' => ucfirst(strtolower($request->name)),
            'description' => ucfirst(strtolower($request->description)),
            'restaurant_id' => $restaurant_id
        ]);

        return redirect(route('category.index'))->with('success_message', 'Categoria agregada con éxito');
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
        $category = Category::findOrFail($id);
        $this->authorize('pass', $category);

        return view('restaurant.categories.edit')->with('category', $category);
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
        $category = Category::findOrFail($id);
        $this->authorize('pass', $category);

        $data=request()->validate([
            'name'=>'required',
            'description'=>'nullable',
            'state' => 'required',
            'restaurant_id' => 'nullable',
        ]);
        
        $category->update($data);
        return redirect(route('category.index'))->with('success_message', 'Categoria editada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->categoryid);
        $this->authorize('pass', $category);

        $products = Product::where('category_id', $category->id)->get();
        if($products!=null){
            foreach($products as $product){
                $this->authorize('pass', $product);
                $product->delete();
            }
        }
        $category->delete();
        return redirect()->route('category.index')->with('success_message', 'Categoria eliminada con éxito');
    }
}
