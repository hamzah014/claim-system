<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the staff guard is authenticated
        if (!auth()->guard('staff')->check()) {
            // If not logged in, redirect to staff login page
            return redirect()->route('login');
        }
        return $next($request);
    }
}