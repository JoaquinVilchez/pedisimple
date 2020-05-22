<?php

namespace App\Http\Middleware;

use Closure;
use App\Restaurant;
use Illuminate\Support\Facades\URL;
use Auth;
use Policies\RestaurantPolicy;

class Visible
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $slug = rawurldecode(substr($request->getRequestUri(), 10));
        $restaurant = Restaurant::where('slug', $slug)->first();

        if(Auth::check()){
            if(Auth::user()->hasRole('administrator')) {
                return $next($request);
            }elseif(Auth::user()->hasRole('merchant')){
                if($restaurant->state == 'active'){
                    return $next($request);
                }else{
                    if (Auth::user()->restaurant->id == $restaurant->id) {
                        return $next($request);
                    }else{
                        return redirect()->route('list.index');
                    }
                }
            }elseif(Auth::user()->hasRole('customer')){
                if($restaurant->state == 'active' && count($restaurant->products) !=0 && count($restaurant->categories) !=0){
                    return $next($request);
                }else{
                    return redirect()->route('list.index');
                } 
            }
        }else{
            if($restaurant->state == 'active' && count($restaurant->products) !=0 && count($restaurant->categories) !=0){
                return $next($request);
            }else{
                return redirect()->route('list.index');
            }
        }
    }
}
