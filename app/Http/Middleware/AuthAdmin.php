<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if(Auth::check()){
          if(Auth::user()->utype==='ADM'){
            return $next($request);
        }
        else{
            Session::flush();
            return Redirect()->route('login');
        }
        } 
        else{
             return Redirect()->route('login');
        }
        
        
    }
}
