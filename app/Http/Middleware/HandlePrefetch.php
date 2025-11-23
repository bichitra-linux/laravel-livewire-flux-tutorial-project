<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class HandlePrefetch
{
    public function handle(Request $request, Closure $next)
    {
        $purpose = strtolower(($request->header('Purpose', '') . ' ' . $request->header('Sec-Purpose', '') . ' ' . $request->header('X-Purpose', '')));
        if (str_contains($purpose, 'prefetch')) {
            $request->attributes->set('is_prefetch', true);
            $response = $next($request);
            $response->headers->set('X-Prefetch', '1');
            return $response;
        }
        return $next($request);
    }
}