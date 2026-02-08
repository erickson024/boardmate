<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearPropertyRegistrationOnNavigation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentRoute = $request->route()->getName();

        if (auth()->check() && $currentRoute !== 'property-registration') {
            $sessionKey = "property_reg_" . auth()->id();
            $draftStatusKey = "property_draft_status_" . auth()->id();

            // If they have registration data but navigated away (browser back button, URL change)
            if (session()->has($sessionKey) && !session()->has($draftStatusKey)) {
                // Mark as having a draft (they left without choosing)
                session()->put($draftStatusKey, true);
            }
        }
        return $next($request);
    }
}
