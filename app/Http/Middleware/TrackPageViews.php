<?php

namespace App\Http\Middleware;

use App\Models\Analytics;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackPageViews
{


    // Routes to exclude from tracking
    private array $excludedRoutes = [
        // Add any routes you want to exclude, e.g., 'test-*' for debug routes
    ];
    public function handle(Request $request, Closure $next): Response
    {


        $response = $next($request);

        // Track all routes except excluded ones
        if ($this->shouldTrackRoute($request)) {
            $this->recordPageView($request);
        }

        return $response;
    }

    private function shouldTrackRoute(Request $request): bool
    {
        $routeName = $request->route()?->getName();

        // Skip if no route name or in excluded list
        if (!$routeName) {
            return false;
        }

        foreach ($this->excludedRoutes as $excluded) {
            if (str_contains($routeName, $excluded)) {
                return false;
            }
        }

        return true;
    }

    private function recordPageView(Request $request): void
    {
        $routeName = $request->route()?->getName();
        $eventType = $this->determineEventType($routeName);
        // Add geolocation (requires IP geolocation service)
        $location = $this->getLocationFromIP($request->ip());

        // Get post if it's a post route
        $post = $routeName === 'public.posts.show' ? $request->route('post') : null;

        Analytics::create([
            'event_type' => $eventType,
            'user_id' => Auth::id(),
            'post_id' => $post?->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            'metadata' => [
                'device' => $this->detectDeviceType($request),
                'browser' => $this->detectBrowserType($request),
                'route_name' => $routeName,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'country' => $location['country'],
                'city' => $location['city'],
                'region' => $location['region'],
            ],
            'created_at' => now(),
        ]);
    }

    private function getLocationFromIP(string $ip): array
{
    // Use ipapi.co
    try {
        $response = Http::get("http://ipapi.co/{$ip}/json/");
        return $response->json();
    } catch (\Exception $e) {
        return [];
    }
}

    private function determineEventType(string $routeName): string
    {
        // Categorize routes into event types
        if ($routeName === 'home') {
            return 'home_visit';
        }
        if ($routeName === 'about') {
            return 'about_visit';
        }
        if ($routeName === 'contact') {
            return 'contact_visit';
        }
        if ($routeName === 'terms') {
            return 'terms_visit';
        }
        if ($routeName === 'privacy') {
            return 'privacy_visit';
        }
        if (str_starts_with($routeName, 'public.posts.')) {
            return 'post_visit';
        }
        if (str_starts_with($routeName, 'newsletter.')) {
            return 'newsletter_action';
        }
        if (str_starts_with($routeName, 'reactions.')) {
            return 'reaction_action';
        }
        if (str_starts_with($routeName, 'admin.')) {
            return 'admin_activity';
        }
        if (str_starts_with($routeName, 'user.')) {
            return 'user_activity';
        }
        if (str_starts_with($routeName, 'test-')) {
            return 'debug_test';
        }

        return 'page_visit'; // Default for any other routes
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