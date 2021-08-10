<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){

        if (Auth::check()) {
            if(Auth::user()->type == \App\Models\User::ADMIN){

                return $next($request);
            }  else {
                return Redirect::to(route('home'));
            }
        }
        return Redirect::to('/login');
    }
}
