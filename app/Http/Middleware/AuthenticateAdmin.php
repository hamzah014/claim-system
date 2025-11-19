<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the admin guard is authenticated
        if (!auth()->guard('admin')->check()) {
            // If not logged in, redirect to admin login page
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}