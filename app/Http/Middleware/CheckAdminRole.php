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
        $method = $request->route()->getActionMethod();

        if (in_array($method, ['create', 'store', 'edit', 'update', 'destroy'])) {
            if (session('user_role') !== 'Admin') {
                return redirect()->route('anggota.index')
                    ->with('error', 'Access denied. Admin privileges required for this action.');
            }
        }

        return $next($request);
    }
}
