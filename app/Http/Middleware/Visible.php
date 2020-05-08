<?php

namespace App\Http\Middleware;

use Closure;
use App\Restaurant;
use Illuminate\Support\Facades\URL;

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

        if($restaurant->state == 'active' && count($restaurant->products) !=0 && count($restaurant->categories) !=0){
            return $next($request);
        }else{
            return redirect()->route('list.index');
        }
    }
}
