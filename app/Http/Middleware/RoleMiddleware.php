<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
       if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Convert string to array, supports comma-separated roles
    $roles = explode(',', $roles);

    if (!in_array(Auth::user()->role, $roles)) {
        return redirect()->route('home'); // or abort(403)
    }

        return $next($request);
    }
}
