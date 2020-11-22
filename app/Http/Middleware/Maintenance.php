<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Request;

class Maintenance
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

        if(env('MAINTENANCE')=='YES'){
            if(Auth::check()){
                if(Auth::user()->restaurant){
                    if(Request::path()==Auth::user()->restaurant->slug){
                        return $next($request);
                    }else{
                        return redirect()->route('product.index');
                    }
                }else{
                    return redirect()->route('app.maintenance');
                }
            }else{
                return redirect()->route('app.maintenance');
            }
        }else{
            return $next($request);
        }
    }
}
