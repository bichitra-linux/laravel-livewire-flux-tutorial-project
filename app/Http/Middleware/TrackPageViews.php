<?php

namespace App\Http\Middleware;

use App\Models\Analytics;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track when viewing individual posts
        if ($request->routeIs('public.posts.show')) {
            $this->recordPageView($request);
        }

        return $response;
    }

    private function recordPageView(Request $request): void
    {

        // Get post from route parameter (already resolved by slug)
        $post = $request->route('post');
        Analytics::create([
            'event_type' => 'post_view',
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'metadata' => [
                'device' => $this->detectDeviceType($request),
                'browser' => $this->detectBrowserType($request),
            ],
            'created_at' => now(),
        ]);
    }

    private function detectDeviceType(Request $request): string
    {
        $userAgent = strtolower($request->userAgent() ?? '');
        
        if (str_contains($userAgent, 'mobile')) {
            return 'mobile';
        }
        
        if (str_contains($userAgent, 'tablet') || str_contains($userAgent, 'ipad')) {
            return 'tablet';
        }
        
        return 'desktop';
    }

    private function detectBrowserType(Request $request): string
    {
        $userAgent = strtolower($request->userAgent() ?? '');
        
        // Check Edge before Chrome (Edge contains 'chrome' in UA)
        if (str_contains($userAgent, 'edg/') || str_contains($userAgent, 'edge/')) {
            return 'edge';
        }
        
        if (str_contains($userAgent, 'chrome')) {
            return 'chrome';
        }
        
        if (str_contains($userAgent, 'firefox')) {
            return 'firefox';
        }
        
        if (str_contains($userAgent, 'safari')) {
            return 'safari';
        }
        
        if (str_contains($userAgent, 'opera') || str_contains($userAgent, 'opr/')) {
            return 'opera';
        }
        
        return 'other';
    }
}