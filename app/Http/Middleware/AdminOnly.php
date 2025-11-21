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

        // ✅ Check if user has admin/editor/writer role
        if ($user && $user->hasAnyRole(['admin', 'editor', 'writer'])) {
            return $next($request);
        }

        // ✅ Use abort(403) instead of redirect for authenticated users without permission
        if ($user && $user->hasRole('user')) {
            abort(403, 'You do not have permission to access the admin area.');
        }

        // ✅ Redirect unauthenticated users to login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        // ✅ Fallback: 403 for users without any role
        abort(403, 'Access denied.');
    }
}