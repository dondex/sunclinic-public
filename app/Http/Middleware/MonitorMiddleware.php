<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class MonitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
            if(Auth::user()->role_as == '2')
            {
                return $next($request);
            }
            else
            {
                return redirect('/')->with('status', 'Access Denied! As you are not a Monitor');
            }
        }
        else
        {
            return redirect('/login')->with('status', 'Please Login First');
        }
    }
}