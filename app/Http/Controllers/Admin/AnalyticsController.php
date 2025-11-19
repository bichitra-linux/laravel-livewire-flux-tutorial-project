<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            'new_visitors' => $this->countNewVisitors($cutoffDate),
            'return_rate' => $this->computeReturnRate($cutoffDate),
            'engagement_rate' => $this->computeEngagementRate($cutoffDate),
        ];

        $popularPosts = $this->fetchPopularPosts($cutoffDate);
        $trafficByDay = $this->fetchDailyTraffic($cutoffDate);
        $deviceBreakdown = $this->fetchDeviceBreakdown($cutoffDate);
        $browserStats = $this->fetchBrowserStats($cutoffDate);
        
        // Additional insights
        $peakDay = $this->getPeakTrafficDay($trafficByDay);
        $peakHour = $this->getPeakTrafficHour($cutoffDate);
        $weeklyGrowth = $this->calculateWeeklyGrowth();

        return view('analytics.index', [
            'stats' => $statistics,
            'topPosts' => $popularPosts,
            'dailyTraffic' => $trafficByDay,
            'deviceStats' => $deviceBreakdown,
            'browserStats' => $browserStats,
            'peakDay' => $peakDay,
            'peakHour' => $peakHour,
            'weeklyGrowth' => $weeklyGrowth,
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

    private function countNewVisitors($since)
    {
        // Visitors who appeared for first time in this period
        $visitorsBefore = Analytics::where('created_at', '<', $since)
            ->distinct('ip_address')
            ->pluck('ip_address');

        return Analytics::where('created_at', '>=', $since)
            ->whereNotIn('ip_address', $visitorsBefore)
            ->distinct('ip_address')
            ->count('ip_address');
    }

    private function computeReturnRate($since)
    {
        $totalVisitors = $this->countUniqueVisitors($since);
        
        if ($totalVisitors === 0) {
            return 0;
        }

        $returningVisitors = Analytics::where('created_at', '>=', $since)
            ->select('ip_address')
            ->groupBy('ip_address')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();

        return round(($returningVisitors / $totalVisitors) * 100, 1);
    }

    private function computeEngagementRate($since)
    {
        $totalViews = $this->countPostViews($since);
        
        if ($totalViews === 0) {
            return 0;
        }

        // Count views with > 30 seconds session time
        $engagedViews = Analytics::where('created_at', '>=', $since)
            ->select('ip_address')
            ->groupBy('ip_address')
            ->get()
            ->filter(function ($group) use ($since) {
                $sessions = Analytics::where('ip_address', $group->ip_address)
                    ->where('created_at', '>=', $since)
                    ->orderBy('created_at')
                    ->get(['created_at']);

                if ($sessions->count() < 2) {
                    return false;
                }

                $duration = $sessions->last()->created_at->diffInSeconds($sessions->first()->created_at);
                return $duration > 30;
            })
            ->count();

        return round(($engagedViews / $this->countUniqueVisitors($since)) * 100, 1);
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
        $query = Analytics::where('created_at', '>=', $since)
            ->whereNotNull('metadata');

        return $query
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(metadata, "$.device")) as device_type'))
            ->addSelect(DB::raw('COUNT(*) as device_count'))
            ->groupBy(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(metadata, "$.device"))'))
            ->pluck('device_count', 'device_type');
    }

    private function fetchBrowserStats($since)
    {
        return Analytics::where('created_at', '>=', $since)
            ->whereNotNull('metadata')
            ->select(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(metadata, "$.browser")) as browser_type'))
            ->addSelect(DB::raw('COUNT(*) as browser_count'))
            ->groupBy(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(metadata, "$.browser"))'))
            ->orderByDesc('browser_count')
            ->take(5)
            ->pluck('browser_count', 'browser_type');
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
            
            if ($sessionDuration > 0 && $sessionDuration <= 3600) {
                $totalSeconds += $sessionDuration;
                $validSessionCount++;
            }
        }

        if ($validSessionCount === 0) {
            return 0;
        }

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

    private function getPeakTrafficDay($dailyTraffic)
    {
        if ($dailyTraffic->isEmpty()) {
            return 'N/A';
        }

        $peak = $dailyTraffic->sortByDesc('daily_views')->first();
        return Carbon::parse($peak->traffic_date)->format('l, M d');
    }

    private function getPeakTrafficHour($since)
    {
        $hourlyData = Analytics::where('created_at', '>=', $since)
            ->select(DB::raw('HOUR(created_at) as hour'))
            ->addSelect(DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderByDesc('count')
            ->first();

        if (!$hourlyData) {
            return 'N/A';
        }

        $hour = $hourlyData->hour;
        $time = Carbon::today()->setHour($hour)->format('g:00 A');
        return $time;
    }

    private function calculateWeeklyGrowth()
    {
        $thisWeek = Analytics::where('created_at', '>=', now()->startOfWeek())
            ->count();

        $lastWeek = Analytics::where('created_at', '>=', now()->subWeek()->startOfWeek())
            ->where('created_at', '<', now()->startOfWeek())
            ->count();

        if ($lastWeek === 0) {
            return $thisWeek > 0 ? 100 : 0;
        }

        return round((($thisWeek - $lastWeek) / $lastWeek) * 100, 1);
    }
}