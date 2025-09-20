<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure the user is authenticated and has te customer role
        if (Auth::check() && Auth::user()->role === 'customer') {
            return $next($request);
        }

        // Redirect to the customer login page if not a customer
        return redirect()->route('login')->with('error', 'Unauthorized access');
        
    }
}
