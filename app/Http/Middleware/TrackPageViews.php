<?php

namespace App\Http\Middleware;

use App\Models\Analytics;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->routeIs('public.posts.show')) {

            Analytics::create([
                'event_type' => 'page_view',
                'user_id' => auth()->id(),
                'post_id' => $request->route('id'),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->header('referer'),
                'metadata' => [
                    'device' => $this->getDevice($request),
                    'browser' => $this->getBrowser($request),
                ],
                'created_at' => now(),
            ]);
        }
        return $response;
    }

    private function getDevice($request) {
        $agent = strtolower($request->userAgent() ?? '');
        if (str_contains($agent, 'mobile')) return 'mobile';
        if (str_contains($agent, 'tablet')) return 'tablet';
        return 'desktop';

    }

    private function getBrowser($request) {
        $agent = strtolower($request->userAgent() ?? '');
        if (str_contains($agent, 'chrome')) return 'chrome';
        if (str_contains($agent, 'firefox')) return 'firefox';
        if (str_contains($agent, 'safari')) return 'safari';
        if (str_contains($agent, 'edge')) return 'edge';
        return 'other';
    }
}