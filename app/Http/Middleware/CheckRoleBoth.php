<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRoleBoth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);
        if (Auth::check() && (Auth::user()->role != 'admin' && Auth::user()->role != 'dealer')) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Invalid user credentials/access.');
        }

        return $response;
    }
}
