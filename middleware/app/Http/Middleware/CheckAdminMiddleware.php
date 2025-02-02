<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->role->role == 1 || Auth::user()->role->role == 3){
                return $next($request);
            }else{
                return redirect()->back()->with([
                    'message' => 'You are not Super Admin'
                ]); 
            }
        }
            return redirect()->route('login')->with([
                'message' => 'You are not Super Admin'
            ]); 
    }
}
