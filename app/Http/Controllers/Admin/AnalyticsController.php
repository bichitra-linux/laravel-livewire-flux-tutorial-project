<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\Post;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    //

    public function index()
    {

        $stats = [
            'total_views' => Analytics::where('event_type', 'post_view')->where('created_at', '>=', now()->subDays(30))->count(),
            'unique_visitors' => Analytics::where('event_type', 'post_view')->where('created_at', '>=', now()->subDays(30))->distinct('ip_address')->count(),
            'avg_time_on_site' => $this->calculateAverageTime(),
            'bounce_rate' => $this->calculateBounceRate(),
        ];

        $topPosts = Post::select('posts.*')->leftJoin('analytics', function ($join) {
            $join->on('posts.id', '=', 'analytics.post_id')
                ->where('analytics.event_type', 'post_view')
                ->where('analytics.created_at', '>=', now()->subDays(30));
        })->selectRaw('COUNT(analytics.id) as views_count')
            ->groupBy('posts.id')
            ->orderByDesc('views_count')
            ->take(10)
            ->get();

        $dailyTraffic = Analytics::where('event_type', 'post_view')->where('created_at', '>=', now()->subDays(30))->selectRaw('DATE(created_at) as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $deviceStats = Analytics::where('created_at', '>=', now()->subDays(30))->selectRaw("JSON_EXTRACT(metadata, '$.device') as device, COUNT(*) as count")->groupBy('device')->pluck('count', 'device');
        return view('analytics.index', compact('stats', 'topPosts', 'dailyTraffic', 'deviceStats'));
    }

    private function calculateAverageTime()
    {
        // Simple estimation based on sequential views
        $sessions = Analytics::where('created_at', '>=', now()->subDays(30))
            ->orderBy('ip_address')
            ->orderBy('created_at')
            ->get()
            ->groupBy('ip_address');

        $totalTime = 0;
        $sessionCount = 0;

        foreach ($sessions as $ipViews) {
            if ($ipViews->count() > 1) {
                $firstView = $ipViews->first()->created_at;
                $lastView = $ipViews->last()->created_at;
                $totalTime += $lastView->diffInSeconds($firstView);
                $sessionCount++;
            }
        }

        return $sessionCount > 0 ? round($totalTime / $sessionCount / 60, 1) : 0; // minutes
    }

    private function calculateBounceRate()
    {
        $totalSessions = Analytics::where('created_at', '>=', now()->subDays(30))
            ->distinct('ip_address')
            ->count();

        $singlePageSessions = Analytics::where('created_at', '>=', now()->subDays(30))
            ->select('ip_address')
            ->groupBy('ip_address')
            ->havingRaw('COUNT(*) = 1')
            ->get()
            ->count();

        return $totalSessions > 0 ? round(($singlePageSessions / $totalSessions) * 100, 1) : 0;
    }
}
