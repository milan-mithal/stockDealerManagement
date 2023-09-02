<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckNewUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);
        if ((Auth::check() && Auth::user()->new_user == 'newuser') || (Auth::check() && Auth::user()->new_user == 'forgotpass')) {
            return redirect()->route('newpasswordpage')->with('success', 'Create New Password.');
        }

        return $response;
    }
}
