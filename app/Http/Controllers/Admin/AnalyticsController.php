<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $daysBack = 30;
        $cutoffDate = now()->subDays($daysBack);

        $statistics = [
            'total_views' => $this->countPostViews($cutoffDate),
            'unique_visitors' => $this->countUniqueVisitors($cutoffDate),
            'avg_time_on_site' => $this->computeAverageSessionTime($cutoffDate),
            'bounce_rate' => $this->computeBounceRate($cutoffDate),
        ];

        $popularPosts = $this->fetchPopularPosts($cutoffDate);
        $trafficByDay = $this->fetchDailyTraffic($cutoffDate);
        $deviceBreakdown = $this->fetchDeviceBreakdown($cutoffDate);

        return view('analytics.index', [
            'stats' => $statistics,
            'topPosts' => $popularPosts,
            'dailyTraffic' => $trafficByDay,
            'deviceStats' => $deviceBreakdown,
        ]);
    }

    private function countPostViews($since)
    {
        return Analytics::where('event_type', 'post_view')
            ->where('created_at', '>=', $since)
            ->count();
    }

    private function countUniqueVisitors($since)
    {
        return Analytics::where('event_type', 'post_view')
            ->where('created_at', '>=', $since)
            ->distinct('ip_address')
            ->count('ip_address');
    }

    private function fetchPopularPosts($since)
    {
        return Post::select([
                'posts.id',
                'posts.title',
                'posts.slug',
                'posts.category_id',
                'posts.created_at'
            ])
            ->with('category:id,name')
            ->leftJoin('analytics', function ($join) use ($since) {
                $join->on('posts.id', '=', 'analytics.post_id')
                    ->where('analytics.event_type', '=', 'post_view')
                    ->where('analytics.created_at', '>=', $since);
            })
            ->addSelect(DB::raw('COUNT(analytics.id) as view_total'))
            ->groupBy('posts.id', 'posts.title', 'posts.slug', 'posts.category_id', 'posts.created_at')
            ->orderByDesc('view_total')
            ->take(10)
            ->get();
    }

    private function fetchDailyTraffic($since)
    {
        return Analytics::where('event_type', 'post_view')
            ->where('created_at', '>=', $since)
            ->select(DB::raw('DATE(created_at) as traffic_date'))
            ->addSelect(DB::raw('COUNT(*) as daily_views'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->get();
    }

    private function fetchDeviceBreakdown($since)
    {
        // MySQL JSON extraction
        $query = Analytics::where('created_at', '>=', $since)
            ->whereNotNull('metadata');

        // Use MySQL JSON functions
        return $query
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(metadata, "$.device")) as device_type'))
            ->addSelect(DB::raw('COUNT(*) as device_count'))
            ->groupBy(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(metadata, "$.device"))'))
            ->pluck('device_count', 'device_type');
    }

    private function computeAverageSessionTime($since)
    {
        $visitorSessions = Analytics::where('created_at', '>=', $since)
            ->orderBy('ip_address')
            ->orderBy('created_at')
            ->get(['ip_address', 'created_at'])
            ->groupBy('ip_address');

        $totalSeconds = 0;
        $validSessionCount = 0;

        foreach ($visitorSessions as $sessionViews) {
            if ($sessionViews->count() < 2) {
                continue;
            }

            $startTime = $sessionViews->first()->created_at;
            $endTime = $sessionViews->last()->created_at;
            $sessionDuration = $endTime->diffInSeconds($startTime);
            
            // Filter out unrealistic sessions (< 1 sec or > 1 hour)
            if ($sessionDuration > 0 && $sessionDuration <= 3600) {
                $totalSeconds += $sessionDuration;
                $validSessionCount++;
            }
        }

        if ($validSessionCount === 0) {
            return 0;
        }

        // Convert to minutes
        return round($totalSeconds / $validSessionCount / 60, 1);
    }

    private function computeBounceRate($since)
    {
        $totalVisitors = Analytics::where('created_at', '>=', $since)
            ->distinct('ip_address')
            ->count('ip_address');

        if ($totalVisitors === 0) {
            return 0;
        }

        $singlePageVisits = Analytics::where('created_at', '>=', $since)
            ->select('ip_address')
            ->groupBy('ip_address')
            ->havingRaw('COUNT(*) = 1')
            ->get()
            ->count();

        return round(($singlePageVisits / $totalVisitors) * 100, 1);
    }
}