<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->is_admin) {
            return $next($request); // User is an admin, allow access to the route
        }

        // User is not an admin, you can redirect, abort, or handle it as needed
        return abort(403, 'Unauthorized'); // For example, return a 403 Forbidden response

    }
}
