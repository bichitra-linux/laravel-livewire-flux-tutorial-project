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
            'Breaking News',
            'Analysis',
            'Opinion',
            'Investigation',
            'Trending',
            'Featured',
            'Exclusive',
            'Interview',
            'Report',
            'Update',
            'Technology',
            'Innovation',
            'Policy',
            'Economy',
            'Society',
            'Environment',
            'Health',
            'Education',
            'Entertainment',
            'Sports',
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => $tagName]
            );
        }

        $this->command->info('✅ Successfully created ' . count($tags) . ' tags!');
    }
}