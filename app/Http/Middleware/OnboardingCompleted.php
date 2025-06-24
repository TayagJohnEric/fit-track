<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnboardingCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has completed onboarding
        if (auth()->check()) {
            $user = auth()->user();
            
            // If user doesn't have a profile, redirect to onboarding
            if (!$user->userProfile) {
                return redirect()->route('onboarding.welcome');
            }
        }

        return $next($request);
    }
}