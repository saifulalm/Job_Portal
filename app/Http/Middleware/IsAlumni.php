<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAlumni
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and if their role is 'alumni'
        if (auth()->check() && auth()->user()->role === 'alumni') {
            return $next($request);
        }

        // If not, abort with a 403 Forbidden error
        abort(403, 'Unauthorized Action');
    }
}
