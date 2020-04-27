<?php

namespace App\Http\Middleware;

use Closure;
use App\Invitation as InvitationClass;

class Invitation
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
        
        $token = substr($request->getRequestUri(), 10);
        if($token==false){
            return redirect()->route('home'); //
        }else{
            $person = InvitationClass::where('token', $token)->first();       

            if($person!=null){
                if($person->state=='without-using'){
                    return $next($request);
                }else{
                    return redirect()->route('home');
                }
            }else{
                return redirect()->route('home');
            }
        }
        
    }
}


// %242y%2410%24   Iw3f9TtH2OR4mmQTVq3QiOAEt.wlJh1juSMKo30a3KiHMErKNZO    BD
// $2y$10$         Iw3f9TtH2OR4mmQTVq3QiOAEt.wlJh1juSMKo30a3KiHMErKNZO  URL