<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Enums\PostStatus;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample post titles by category
        $postData = [
            'politics' => [
                'Breaking: Major Policy Changes Announced in Parliament',
                'Election 2024: What You Need to Know',
                'Government Unveils New Economic Recovery Plan',
                'Political Leaders Meet to Discuss Climate Action',
                'Senate Passes Landmark Healthcare Reform Bill',
            ],
            'tech' => [
                'AI Revolution: How Machine Learning is Changing Everything',
                'The Future of Quantum Computing Explained',
                'Cybersecurity Threats to Watch in 2024',
                'Apple Announces Groundbreaking New Product Line',
                'The Rise of Web3 and Decentralized Applications',
            ],
            'culture' => [
                'Oscar Winners 2024: Complete List and Highlights',
                'New Museum Exhibition Celebrates Modern Art',
                'Behind the Scenes of This Year\'s Biggest Blockbuster',
                'Music Festival 2024: Lineup and What to Expect',
                'The Renaissance of Indie Cinema',
            ],
            'business' => [
                'Stock Market Hits Record High Amid Economic Optimism',
                'Startup Success: How This Company Became a Unicorn',
                'Global Trade Agreements: What They Mean for Businesses',
                'The Future of Remote Work and Digital Nomads',
                'Cryptocurrency Regulation: New Framework Proposed',
            ],
            'world' => [
                'International Summit Focuses on Global Cooperation',
                'Natural Disaster Relief Efforts Mobilize Worldwide',
                'UNESCO Adds New Sites to World Heritage List',
                'Climate Conference Ends with Landmark Agreement',
                'Space Agency Announces New Mars Mission Details',
            ],
        ];

        // Sample content paragraphs
        $contentTemplates = [
            'In a significant development that has captured global attention, experts are analyzing the far-reaching implications of recent events. Sources close to the matter suggest that this could mark a turning point in how we approach this critical issue.',
            
            'The announcement comes at a crucial time when stakeholders across various sectors are seeking clarity and direction. Industry leaders have welcomed this development, viewing it as a positive step forward that addresses long-standing concerns.',
            
            'According to multiple sources, the impact of this decision will be felt across numerous domains. Analysts predict that we will see substantial changes in the coming months, with both challenges and opportunities emerging for those involved.',
            
            'Experts have been quick to weigh in on the matter, offering diverse perspectives on what this means for the future. While some remain cautiously optimistic, others have raised important questions that deserve careful consideration.',
            
            'The situation continues to evolve, with new information coming to light regularly. Stakeholders are advised to stay informed as developments unfold, as the implications could be significant for various communities and industries.',
        ];

        // Sample tags
        $allTags = [
            'breaking-news', 'analysis', 'opinion', 'investigation', 'trending',
            'featured', 'exclusive', 'interview', 'report', 'update',
            'technology', 'innovation', 'policy', 'economy', 'society',
            'environment', 'health', 'education', 'entertainment', 'sports'
        ];

        // Create tags if they don't exist
        foreach ($allTags as $tagName) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => ucwords(str_replace('-', ' ', $tagName))]
            );
        }

        // ✅ Get or create a SINGLE admin user (all posts will belong to this user)
        $user = User::firstOrCreate(
            ['email' => 'est@gmail.com'],
            [
                'name' => 'est',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info("📝 Using user: {$user->name} ({$user->email})");

        // Get all categories
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('No categories found. Please run CategorySeeder first.');
            return;
        }

        $postCount = 0;

        // Create posts for each category
        foreach ($postData as $categorySlug => $titles) {
            $category = $categories->firstWhere('slug', $categorySlug);
            
            if (!$category) continue;

            foreach ($titles as $title) {
                // Generate rich content (3-5 paragraphs)
                $paragraphCount = rand(3, 5);
                $content = '<p>' . implode('</p><p>', 
                    array_slice(
                        array_merge($contentTemplates, $contentTemplates), 
                        0, 
                        $paragraphCount
                    )
                ) . '</p>';

                // ✅ Create post - ALL posts belong to the single admin user
                $post = Post::create([
                    'title' => $title,
                    'content' => $content,
                    'user_id' => $user->id,  // ✅ Single user only
                    'category_id' => $category->id,
                    'status' => PostStatus::Published,
                    'views' => rand(50, 5000),
                    'created_at' => now()->subDays(rand(0, 30)),
                    'updated_at' => now()->subDays(rand(0, 30)),
                ]);

                // Attach 2-4 random tags
                $tags = Tag::inRandomOrder()->limit(rand(2, 4))->get();
                $post->tags()->attach($tags);

                $postCount++;

                $this->command->info("Created post: {$title}");
            }

            // Stop after 20 posts
            if ($postCount >= 20) break;
        }

        $this->command->info("✅ Successfully created {$postCount} posts for user: {$user->name}!");
    }
}