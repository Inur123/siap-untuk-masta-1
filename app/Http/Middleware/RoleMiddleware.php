<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array(Auth::user()->role, $roles)) {
            // If user role is not in the allowed roles, return 403 Forbidden.
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
