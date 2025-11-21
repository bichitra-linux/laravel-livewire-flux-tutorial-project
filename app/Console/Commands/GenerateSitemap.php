<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Category;
use App\Enums\PostStatus;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate XML sitemap';

    public function handle()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Home page
        $sitemap .= $this->addUrl(route('home'), '1.0', 'daily');

        // Posts
        $posts = Post::where('status', PostStatus::Published)
            ->select('slug', 'updated_at')
            ->get();

        foreach ($posts as $post) {
            $sitemap .= $this->addUrl(
                route('public.posts.show', $post->slug),
                '0.8',
                'weekly',
                $post->updated_at
            );
        }

        // Categories
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap .= $this->addUrl(
                route('public.posts.index', ['category' => $category->slug]),
                '0.6',
                'weekly'
            );
        }

        // Static pages
        $sitemap .= $this->addUrl(route('about'), '0.5', 'monthly');
        $sitemap .= $this->addUrl(route('contact'), '0.5', 'monthly');

        $sitemap .= '</urlset>';

        file_put_contents(public_path('sitemap.xml'), $sitemap);

        $this->info('Sitemap generated successfully!');
    }

    private function addUrl($loc, $priority = '0.5', $changefreq = 'weekly', $lastmod = null)
    {
        $url = '<url>';
        $url .= '<loc>' . htmlspecialchars($loc) . '</loc>';
        $url .= '<priority>' . $priority . '</priority>';
        $url .= '<changefreq>' . $changefreq . '</changefreq>';
        
        if ($lastmod) {
            $url .= '<lastmod>' . Carbon::parse($lastmod)->toIso8601String() . '</lastmod>';
        }
        
        $url .= '</url>';
        
        return $url;
    }
}