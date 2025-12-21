<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrackUserActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            Auth::user()->updateActivity();
            Log::info('User activity tracked for: ' . Auth::user()->email);
        }

        return $next($request);
    }
}