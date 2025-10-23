<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is not logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if the user is logged in but not verified
        if (!Auth::user()->hasVerifiedEmail()) {
            // Avoid redirect loop if already on verification routes
            if (!$request->is('email/verify', 'email/verification-notification')) {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
