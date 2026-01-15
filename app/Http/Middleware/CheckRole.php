<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->role !== $role) {
             // If trying to access admin but is staff
             if ($role === 'super_admin' && Auth::user()->role === 'staff_perpus') {
                 return redirect('/staff');
             }
             // If trying to access staff but is admin (allow admin to access staff?)
             // For now, strict separation as requested.
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
