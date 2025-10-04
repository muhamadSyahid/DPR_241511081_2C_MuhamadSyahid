<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is Admin for all actions
        if (session('user_role') !== 'Admin') {
            return redirect()->route('anggota.index')
                ->with('error', 'Access denied. Admin privileges required to access this section.');
        }

        return $next($request);
    }
}
