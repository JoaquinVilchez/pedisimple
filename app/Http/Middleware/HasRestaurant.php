<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class HasRestaurant
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
        if(Auth::user()->restaurant == null){
            return redirect()->route('restaurant.create');
        }else{
            return $next($request);
        }
    }
}
