<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // News Types
            'Breaking News',
            'Analysis',
            'Opinion',
            'Investigation',
            'Exclusive',
            'Interview',
            'Report',
            'Update',
            
            
            // Topics
            'Technology',
            'Innovation',
            'AI & Machine Learning',
            'Cybersecurity',
            'Startups',
            'Policy',
            'Economy',
            'Society',
            'Environment',
            'Climate Change',
            'Health',
            'Education',
            'Entertainment',
            'Sports',
            'Culture',
            'Science',
            'Travel',
            'Lifestyle',
            'Business',
            'Finance',
            'Markets',
            'Real Estate',
            'Retail',
            'E-commerce',
            'Politics',
            'World News',
            'Local News',
            'Human Rights',
            'Social Justice',
            'Arts',
            'Music',
            'Film',
            'Television',
            'Books',
            'Food & Drink',
            'Fashion',
            'Automotive',
            'Gaming',
            'Space Exploration',
            'Health & Wellness',
            'Mental Health',
            'Fitness',
            'Nutrition',
            'Parenting',
            'Relationships',
            'Travel & Leisure',
            
            // Content Features
            'Trending',
            'Featured',
            'Long Read',
            'Quick Take',
            'Video',
            'Podcast',
            'Infographic',
            'Photo Gallery',
            'Live Coverage',
            'Breaking',

            
            // Regions
            'US News',
            'Europe',
            'Asia',
            'Middle East',
            'Africa',
            'Latin America',
        ];

        $createdCount = 0;
        
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => $tagName]
            );
            
            if ($tag->wasRecentlyCreated) {
                $createdCount++;
            }
        }

        $this->command->info("  Successfully created {$createdCount} new tags (Total: " . count($tags) . ")");
    }
}