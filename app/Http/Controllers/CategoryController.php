<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;   
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function isAvailable(Request $request)
    {
        $category = Category::find($request->category_id);
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
        $categories = Auth::user()->restaurant->categories;
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
        $restaurant_id = Auth::user()->restaurant->id;

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
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
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect(route('category.index'))->with('success_message', 'Categoria eliminada con éxito');
    }
}
