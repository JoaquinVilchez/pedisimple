<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RestaurantCategory;
use App\Restaurant;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        // $categories = DB::table('relation_restaurant_category')->select('category_restaurant_id')->get()->groupBy('category_restaurant_id');

        $filter = $request->get('filter');
        $filters = [];
        $categories = RestaurantCategory::with('restaurants')->get();

        if($filter!=null){
            $category = RestaurantCategory::with('restaurants')->where('name', $filter)->where('state', 'active')->get();
                foreach ($category as $filter_category) {
                    $restaurants = $filter_category->restaurants;
                }

                $available_restaurants = $restaurants->filter(function ($restaurants) {
                    if($restaurants->state == 'active'){
                        return $restaurants;
                    }
                });
                
                array_push($filters, $filter);
        }else{
            $available_restaurants = Restaurant::with('products')->with('categories')->with('address')->where('state', 'active')->get();
            $filter = false;
        }
        
        $filtered_categories = $categories->filter(function ($categories) {
            $active_restaurants = [];

            foreach ($categories->restaurants as $restaurant) {
                if($restaurant->state=='active'){
                    array_push($active_restaurants, $restaurant);
                }
            }

            if(count($active_restaurants)>0){
                return $active_restaurants;
            }
        });

        return view('list')->with([
            'categories'=>$filtered_categories,
            'restaurants'=>$available_restaurants,
            'filters'=>$filters
        ]);
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
        //
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
    public function update(Request $request, $id)
    {
        //
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
}
