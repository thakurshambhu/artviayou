<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class UserSlugMiddleware
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
        // dd($request->route('page'));
        $is_exist = DB::table('users')->where([
            'user_name' => $request->route('page')
        ])->first();
        // dd($is_exist);
        if(!empty($is_exist)){
            return redirect('/'.$request->route('page'));
        }else{

            return $next($request);
        }

    }
}
