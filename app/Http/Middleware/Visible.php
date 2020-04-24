<?php

namespace App\Http\Middleware;

use Closure;
use App\Restaurant;

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
        $slug = substr($request->getRequestUri(), 10);
        $commerce = Restaurant::where('slug', $slug)->first();

        if($commerce->state == 'active' && count($commerce->products) !=0 && count($commerce->categories) !=0){
            return $next($request);
        }else{
            return redirect()->route('list.index');
        }
    }
}
