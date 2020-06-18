<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Restaurant;
use App\Category;   
use App\Product;
use App\City;
use App\RestaurantCategory;
use App\Address;
use App\OpeningDateTime;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Mail\RequestMail;
use App\Mail\RequestMailAdmin;
use App\Mail\newCommerce;
use App\Mail\newCommerceAdmin;
use App\Mail\UpdateStatusMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {            
        $restaurants = Restaurant::orderBy('state', 'desc')->get();
        return view('admin.restaurant.list')->with('restaurants', $restaurants);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {    
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        $restaurant->update(['state' => $request->state]);

        $data = [
            'name' => $restaurant->name,
            'slug' => $restaurant->slug,
            'user_name' => $restaurant->user->first_name,
        ];

        if($request->state == 'active'){
            Mail::to($restaurant->user->email)->send(new UpdateStatusMail($data));
        }

        return redirect()->back()->with('success_message', 'Estado actualizado con éxito');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function request(Request $request)
    {            
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'commerce' => $request->commerce,
            'aditional_notes' => $request->aditional_notes
        ];

        Mail::to($request->email)->send(new RequestMail);
        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new RequestMailAdmin($data));

        return redirect()->back()->with('success_message', 'Mensaje enviado con éxito');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function openingTime()
    {
        $restaurant = Auth::user()->restaurant;
        $days = OpeningDateTime::where('restaurant_id', $restaurant->id)->get()->toArray();
        $schedule = [1,2,3,4,5,6,7];

            if (count($days)>0) {
                foreach ($days as $day) {  
                        // dd($day);                 
                        $replace_day = (array($day['weekday']-1=>$day));
                        $schedule = array_replace_recursive($schedule, $replace_day);
                }  
            }

        return view('restaurant.info.times')->with([
            'restaurant' => $restaurant,
            'schedule' => $schedule
        ]);
    }

    public function openingTimeUpdate(Request $request){
        
        if ($request->start_hour_1 == null and $request->end_hour_1 == null and $request->start_hour_2 == null and $request->end_hour_2 == null) {
            $rule1 = 'required';
            $rule2 = 'required';
        }else{
            if($request->start_hour_1 != null or $request->end_hour_1 != null){
                $rule1 = 'required';
                if($request->start_hour_2 != null or $request->end_hour_2 != null){
                    $rule2 = 'required';
                }else{
                    $rule2 = 'nullable';
                }
            }
    
            if($request->start_hour_2 != null or $request->end_hour_2 != null){
                $rule1 = 'required';
                if($request->start_hour_1 != null or $request->end_hour_1 != null){
                    $rule2 = 'required';
                }else{
                    $rule2 = 'nullable';
                }
            }
        }

        $request->validate([
            'start_hour_1'=> $rule1,
            'end_hour_1'=> $rule1,
            'start_hour_2' => $rule2,
            'end_hour_2' => $rule2,
        ]);
        
        $restaurant = Auth::user()->restaurant;
        
        if($request->state == 'on'){
            $state='open';
        }else{
            $state='closed';
        }

        if ($request->id) {
            $day = OpeningDateTime::where('restaurant_id', $restaurant->id)->where('id', $request->id)->first();
            
            $day->update([
                'state' => $state,
                'start_hour_1' => $request->start_hour_1,
                'end_hour_1' => $request->end_hour_1,
                'start_hour_2' => $request->start_hour_2,
                'end_hour_2' => $request->end_hour_2,
            ]);

            return redirect()->back()->with('success_message', 'Horario modificado con éxito');

        }else{
            OpeningDateTime::create([
                'restaurant_id' => $restaurant->id,
                'weekday' => $request->weekday,
                'state' => $state,
                'start_hour_1' => $request->start_hour_1,
                'end_hour_1' => $request->end_hour_1,
                'start_hour_2' => $request->start_hour_2,
                'end_hour_2' => $request->end_hour_2,
            ]);

            return redirect()->back()->with('success_message', 'Horario agregado con éxito');
        }
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
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = RestaurantCategory::all();
        $cities = City::all();
        return view('restaurant.create')->with([
            'categories' => $categories,
            'cities' => $cities
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
        if($request->shipping_method == 'pickup'){
            $rule = 'nullable';
        }else{
            $rule = 'required';
        }

        if($request->second_phone != null or $request->second_characteristic != null ){
            $second_phone_rule = 'required';
        }else{
            $second_phone_rule = 'nullable';
        }

        $data=request()->validate([
            'name'=> ['required', 'string'],
            'street'=> ['required', 'string'],
            'number'=> ['required'],
            'city_id'=> ['required'],
            'characteristic' => 'required|min:4',
            'phone' => 'required|min:6',
            'second_characteristic' => $second_phone_rule.'|min:4',
            'second_phone' => $second_phone_rule.'|min:6',
            'description'=> ['nullable', 'string'],
            'shipping_method'=> ['required'],
            'shipping_price'=> $rule,
            'shipping_time'=> ['nullable'],
            'food_categories'=> ['required'],
            'image'=> ['nullable'],
        ]);

        $slug = str_replace(' ', '-', normaliza($data['name']));

        if($request->hasFile('image')){

            $file = $request->file('image');

            $path = $file->hashName();

            $image = Image::make($file)->encode('jpg', 75);
            
            $image->fit(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save('images/uploads/commerce/'.$path);         

            $data['image'] = $path;

        }else{
            $data['image'] = 'commerce.png';
        }

        Restaurant::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'slug' => $slug,
            'characteristic' => $data['characteristic'],
            'phone' => $data['phone'],
            'second_characteristic' => $data['second_characteristic'],
            'second_phone' => $data['second_phone'],
            'shipping_price' => $data['shipping_price'],
            'shipping_time' => $data['shipping_time'],
            'shipping_method' => $data['shipping_method'],
            'state' => 'pending',
            'user_id' => Auth::user()->id,
            'image' => $data['image'],
        ]);

        $restaurant = Restaurant::where('user_id', Auth::user()->id)->first();        

        
        Address::create([
            'street' => $data['street'],
            'number' => $data['number'],
            'restaurant_id' => $restaurant->id,
            'city_id' => $data['city_id']
        ]);
            
            
        for ($i=0; $i < count($data['food_categories']); $i++) { 
        DB::table('relation_restaurant_category')->insert([
            'restaurant_id' => $restaurant->id,
            'category_restaurant_id' => $data['food_categories'][$i]
            ]);   
        }
            
        $restaurant = Auth::user()->restaurant;
        
        Mail::to(Auth::user()->email)->send(new newCommerce($restaurant));
        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new newCommerceAdmin($restaurant));

        return redirect()->route('product.index');

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
        $products = Product::where('state', 'available')->where('temporary', true)->get();
        $days = OpeningDateTime::where('restaurant_id', $restaurant->id)->get()->toArray();

        $temporary_products = $products->filter(function ($products) {
            if($products->isTemporaryActive()){
                return $products;
            }
        });


        if(count($days)>0){
            $schedule = array(1,2,3,4,5,6,7);
            foreach ($days as $day) {  
                    // dd($day);                 
                    $replace_day = (array($day['weekday']-1=>$day));
                    $schedule = array_replace_recursive($schedule, $replace_day);
            }  
            
            $today = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
            $weekday = $today->dayOfWeek;       
            $state = isOpen($days, $weekday, $today);
            if($state==null){
                $state=false;
            }

        }elseif($days==null){
            $schedule = null;
            $state=false;
        }

        return view('restaurant.profile')->with([
            'restaurant' =>  $restaurant,
            'categories' => $categories,
            'days' => $schedule,
            'state' => $state,
            'temporary_products' => $temporary_products
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

        if($request->shipping_method == 'pickup'){
            $shipping_price_rule = 'nullable';
        }else{
            $shipping_price_rule = 'required';
        }

        if($request->second_phone != null or $request->second_characteristic != null ){
            $second_phone_rule = 'required';
        }else{
            $second_phone_rule = 'nullable';
        }
        
        $data=request()->validate([
            'name'=>'required',
            'street'=>'required',
            'number'=>'required',
            'city_id' => 'required',
            'characteristic' => 'required|min:4',
            'phone' => 'required|min:6',
            'second_characteristic' => $second_phone_rule.'|min:4',
            'second_phone' => $second_phone_rule.'|min:6',
            'description' => 'nullable',
            'shipping_method' => 'required',
            'shipping_price' => $shipping_price_rule,
            'shipping_time' => 'nullable',
            'food_categories' => 'required'
        ]);

        $slug = str_replace(' ', '-', normaliza($data['name']));

        //IMAGE
        if($request->hasFile('image')){

            $old_image = $restaurant->image;

            $file = $request->file('image');

            $path = $file->hashName();

            $image = Image::make($file)->encode('jpg', 75);
            
            if($old_image != 'commerce.png'){
                $path_old_image = 'images/uploads/commerce/'.$old_image;
                    if(file_exists($path_old_image)){
                        unlink($path_old_image);
                    }
            }    
            
            $image->fit(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save('images/uploads/commerce/'.$path);         

            $restaurant->update(['image'=>$path]);  
        }
        //FIN IMAGE

        if($request->action==='delete'){
            $restaurant->update(['image'=>'commerce.png']); 
        }

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
            DB::table('relation_restaurant_category')->where('category_restaurant_id', $foodCategories[$i]->category_restaurant_id)->where('restaurant_id', $restaurant->id)->delete();
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
            'characteristic'=> $data['characteristic'],
            'phone'=> $data['phone'],
            'second_characteristic'=> $data['second_characteristic'],
            'second_phone'=> $data['second_phone'],
            'description'=> $data['description'],
            'slug' => $slug,
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

