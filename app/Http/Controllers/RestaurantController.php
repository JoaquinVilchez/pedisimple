<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Restaurant;
use App\Category;   
use App\City;
use App\RestaurantCategory;
use App\Address;
use App\OpeningDateTime;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\DB;
use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function openingTime()
    {
        $restaurant = Auth::user()->restaurant;
        $days = OpeningDateTime::where('restaurant_id', $restaurant->id)->get();
        return view('restaurant.info.times')->with([
            'restaurant' => $restaurant,
            'days' => $days
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
        $restaurant = Auth::user()->restaurant;
        return view('restaurant.info.general')->with('restaurant',$restaurant);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('restaurant.dashboard');
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        $categories = Category::where('restaurant_id', $restaurant->id)->where('state', 'available')->get();
        $opening_times = OpeningDateTime::where('restaurant_id', $restaurant->id)->get();

        return view('restaurant.profile')->with([
            'restaurant' =>  $restaurant,
            'categories' => $categories,
            'opening_times' => $opening_times
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $address = $restaurant->address;
        $cities = City::all();
        $foodCategories = RestaurantCategory::all();
        $restaurantFoodCategories = $restaurant->restaurantCategories;
        return view('restaurant.info.edit')->with([
            'restaurant' => $restaurant,
            'address' => $address,
            'cities' => $cities,
            'foodCategories' => $foodCategories,
            'restaurantFoodCategories' => $restaurantFoodCategories
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
        $restaurant = Restaurant::findOrFail($id);

        $data=request()->validate([
            'name'=>'required',
            'street'=>'required',
            'number'=>'required',
            'city_id' => 'required',
            'phone' => 'nullable',
            'description' => 'nullable',
            'shipping_method' => 'required',
            'shipping_price' => 'nullable',
            'shipping_time' => 'nullable',
            'food_categories' => 'required'
        ]);

        //IMAGE
        if($request->hasFile('image')){
            $old_image = $restaurant->image;

            $file = $request->file('image');

            $path = $file->hashName('public');

            $image = Image::make($file)->encode('jpg', 75);
            
            $image->fit(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            });

            if($old_image != 'public/commerce.png'){
                Storage::delete($old_image);
            }
            Storage::put($path, (string) $image->encode());

            $restaurant->update(['image'=>$path]);  
        }
        //FIN IMAGE

        //ADDRESS
        $address = Address::where([
            ['restaurant_id', '=', $restaurant->id],
            ['street', '=', $data['street']],
            ['number', '=', $data['number']],
            ['city_id', '=', $data['city_id']],
        ]);

        if(count($address->get())==0){
            $old_address = Address::where('restaurant_id', '=', $restaurant->id)->first();
            $old_address->update([
                'street' => $data['street'],
                'number' => $data['number'],
                'city_id' => $data['city_id']
            ]);
        }
        //FIN ADDRESS

                        //OPTIMIZAR
        //FOOD CATEGORIES
        $foodCategories = DB::table('relation_restaurant_category')->where('restaurant_id', $restaurant->id)->get();
        for ($i=0; $i < count($foodCategories); $i++){
            DB::table('relation_restaurant_category')->where('category_restaurant_id', $foodCategories[$i]->category_restaurant_id)->delete();
        }
        for ($i=0; $i < count($data['food_categories']); $i++) { 
            DB::table('relation_restaurant_category')->insert([
                'restaurant_id' => $restaurant->id,
                'category_restaurant_id' => $data['food_categories'][$i]
            ]);
        }
        //FIN FOOD CATEGORIES

        $restaurant->update([
            'name'=> $data['name'],
            'phone'=> $data['phone'],
            'description'=> $data['description'],
            'shipping_method'=> $data['shipping_method'],
            'shipping_price'=> $data['shipping_price'],
            'shipping_time'=> $data['shipping_time']
        ]);

        return redirect(route('restaurant.info'))->with('success_message', 'Datos editados con éxito');
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

