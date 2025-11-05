<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if user has ONLY the 'user' role (not admin/editor/writer)
        if ($user && $user->hasRole('user') && !$user->hasAnyRole(['admin', 'editor', 'writer'])) {
            return $next($request);
        }

        // Redirect admin users to dashboard
        if ($user && $user->hasAnyRole(['admin', 'editor', 'writer'])) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Please use the admin panel.');
        }

        // If no role, redirect to home
        return redirect()->route('home')->with('error', 'Access denied.');
    }
}