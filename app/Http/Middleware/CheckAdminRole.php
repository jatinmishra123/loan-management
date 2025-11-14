<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = auth('admin')->user();

        if (!$user) {
            abort(403, 'Unauthorized access.');
        }

        // ✅ Super Admin can access everything
        if ($user->role_id == 1 || $user->role === 'super_admin') {
            return $next($request);
        }

        // ✅ Normal Admin can access admin routes
        if ($role === 'admin' && ($user->role_id == 2 || $user->role === 'admin')) {
            return $next($request);
        }

        abort(403, 'Access denied.');
    }
}
