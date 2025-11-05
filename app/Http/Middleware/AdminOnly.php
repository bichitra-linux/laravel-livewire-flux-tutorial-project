<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if user has admin/editor/writer role
        if ($user && $user->hasAnyRole(['admin', 'editor', 'writer'])) {
            return $next($request);
        }

        // Redirect regular users to user settings
        if ($user && $user->hasRole('user')) {
            return redirect()->route('user.profile.edit')->with('error', 'Access denied. You do not have admin privileges.');
        }

        // If no valid role, redirect to home
        return redirect()->route('home')->with('error', 'Access denied.');
    }
}