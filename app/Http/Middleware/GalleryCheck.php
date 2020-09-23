<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GalleryCheck
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
        $user = Auth::check();
        if($user){

            $role = Auth::user()->role;
        
            if($role == "gallery"){ 
                return $next($request); 
            }else{
                return redirect()->back()->with('error', 'Access Denied');
            } 
        
        }else{
            
            return redirect()->back()->with('error', 'Sorry, you can not access without Login.');
        
        }
    }
}
