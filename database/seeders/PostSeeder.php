<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Enums\PostStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        
        // Get or create the main admin user
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
            $this->command->error('❌ No categories found. Please run CategorySeeder first.');
            return;
        }

        // Get all tags
        $allTags = Tag::all();

        if ($allTags->isEmpty()) {
            $this->command->error('❌ No tags found. Please run TagSeeder first.');
            return;
        }

        // Ensure storage directory exists
        $storageDir = storage_path('app/public/posts');
        if (!File::exists($storageDir)) {
            File::makeDirectory($storageDir, 0755, true);
            $this->command->info('📁 Created posts directory');
        }

        $postCount = 0;
        $totalPosts = 50; // Create 50 posts

        // Progress bar
        $bar = $this->command->getOutput()->createProgressBar($totalPosts);
        $bar->start();

        for ($i = 0; $i < $totalPosts; $i++) {
            // Random category
            $category = $categories->random();
            
            // Generate title based on category
            $title = $this->generateTitle($category->slug, $faker);
            
            // Generate rich HTML content (3-8 paragraphs)
            $content = $this->generateContent($faker, rand(3, 8));
            
            // Generate placeholder image using picsum.photos
            $imagePath = $this->generatePlaceholderImage($i + 1);
            
            // Random status (mostly published)
            $status = $faker->randomElement([
                PostStatus::Published,
                PostStatus::Published,
                PostStatus::Published,
                PostStatus::Published, // 80% published
                PostStatus::Draft,     // 20% draft
            ]);
            
            // Random date within last 60 days
            $createdAt = $faker->dateTimeBetween('-60 days', 'now');
            $updatedAt = $faker->dateTimeBetween($createdAt, 'now');
            
            // Create post
            $post = Post::create([
                'title' => $title,
                'content' => $content,
                'user_id' => $user->id,
                'category_id' => $category->id,
                'status' => $status,
                'image' => $imagePath,
                'views' => $faker->numberBetween(50, 10000),
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);

            // Attach 2-5 random tags
            $randomTags = $allTags->random(rand(5, 15));
            $post->tags()->attach($randomTags);

            $postCount++;
            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine(2);
        $this->command->info("✅ Successfully created {$postCount} posts for user: {$user->name}!");
    }

    /**
     * Generate title based on category
     */
    private function generateTitle(string $categorySlug, $faker): string
    {
        $titles = [
            'politics' => [
                'Breaking: Major Policy Changes Announced in Parliament',
                'Election {year}: What You Need to Know',
                'Government Unveils New Economic Recovery Plan',
                'Political Leaders Meet to Discuss Climate Action',
                'Senate Passes Landmark Healthcare Reform Bill',
                'New Legislative Measures Target Economic Inequality',
                'Presidential Address: Key Takeaways from Today\'s Speech',
                'Opposition Party Presents Alternative Budget Proposal',
            ],
            'technology' => [
                'AI Revolution: How Machine Learning is Changing {industry}',
                'The Future of Quantum Computing Explained',
                'Cybersecurity Threats to Watch in {year}',
                '{company} Announces Groundbreaking New Product Line',
                'The Rise of Web3 and Decentralized Applications',
                '{number}G Network: What It Means for the Future',
                'Silicon Valley\'s Next Big Thing: {tech}',
                'Tech Giants Face New Regulatory Challenges',
            ],
            'culture' => [
                'Oscar Winners {year}: Complete List and Highlights',
                'New Museum Exhibition Celebrates Modern Art',
                'Behind the Scenes of This Year\'s Biggest Blockbuster',
                'Music Festival {year}: Lineup and What to Expect',
                'The Renaissance of Indie Cinema',
                'Streaming Wars: Who\'s Winning in {year}?',
                'Cultural Icon {name} Reflects on Decades of Influence',
                'Art Market Trends: What\'s Hot in Contemporary Art',
            ],
            'business' => [
                'Stock Market Hits Record High Amid Economic Optimism',
                'Startup Success: How {company} Became a Unicorn',
                'Global Trade Agreements: What They Mean for Businesses',
                'The Future of Remote Work and Digital Nomads',
                'Cryptocurrency Regulation: New Framework Proposed',
                'IPO Watch: {company} Goes Public This Week',
                'Small Business Recovery: Stories of Resilience',
                'Corporate Sustainability: More Than Just Buzzwords',
            ],
            'world' => [
                'International Summit Focuses on Global Cooperation',
                'Natural Disaster Relief Efforts Mobilize Worldwide',
                'UNESCO Adds New Sites to World Heritage List',
                'Climate Conference Ends with Landmark Agreement',
                'Space Agency Announces New Mars Mission Details',
                'Humanitarian Crisis: International Response Needed',
                'Global Partnership Aims to Combat Poverty',
                'Historic Peace Talks Make Progress in {region}',
            ],
            'science' => [
                'Breakthrough Discovery Could Change Medicine Forever',
                'New Study Reveals Surprising Findings About {topic}',
                'Space Exploration: {mission} Reaches Major Milestone',
                'Climate Science: Latest Data Confirms Urgent Need for Action',
                'Vaccine Development: Promising Results in Clinical Trials',
                'Physics Breakthrough: Scientists Observe {phenomenon}',
                'Marine Biology: Discovering New Species in Deep Ocean',
                'Neuroscience Advances Understanding of {condition}',
            ],
            'health' => [
                'Mental Health Awareness: Breaking the Stigma',
                'Nutrition Study Challenges Conventional Wisdom',
                'Fitness Trends {year}: What\'s Worth Trying?',
                'Medical Breakthrough Offers Hope for {condition} Patients',
                'Public Health Alert: What You Need to Know',
                'Alternative Medicine: Separating Fact from Fiction',
                'Sleep Science: Why Quality Rest Matters More Than Ever',
                'Wellness Revolution: Holistic Approaches Gain Traction',
            ],
            'sports' => [
                '{team} Wins Championship in Dramatic Fashion',
                'Olympic Preparations: Athletes Ready for {year}',
                'Transfer News: {player} Makes Surprise Move',
                'Record-Breaking Performance at {event}',
                'Sports Science: How Technology is Changing the Game',
                'Underdog Story: {team} Defies All Odds',
                'Controversy at {event}: What Really Happened',
                'Hall of Fame Inductees: Celebrating Legends',
            ],
        ];

        // Get titles for category or use generic
        $categoryTitles = $titles[$categorySlug] ?? [
            $faker->catchPhrase() . ': ' . $faker->sentence(6),
        ];

        // Pick random title
        $title = $faker->randomElement($categoryTitles);

        // Replace placeholders
        $title = str_replace('{year}', $faker->year('-1 year'), $title);
        $title = str_replace('{company}', $faker->company(), $title);
        $title = str_replace('{name}', $faker->name(), $title);
        $title = str_replace('{player}', $faker->firstName() . ' ' . $faker->lastName(), $title);
        $title = str_replace('{team}', $faker->city() . ' ' . $faker->randomElement(['Warriors', 'United', 'FC', 'Tigers', 'Eagles']), $title);
        $title = str_replace('{event}', $faker->randomElement(['World Cup', 'Olympics', 'Championship', 'Grand Prix']), $title);
        $title = str_replace('{region}', $faker->country(), $title);
        $title = str_replace('{industry}', $faker->randomElement(['Healthcare', 'Finance', 'Education', 'Manufacturing']), $title);
        $title = str_replace('{tech}', $faker->randomElement(['Blockchain', 'IoT', 'Edge Computing', 'Robotics']), $title);
        $title = str_replace('{number}', $faker->randomElement(['5', '6']), $title);
        $title = str_replace('{topic}', $faker->randomElement(['Sleep', 'Diet', 'Exercise', 'Stress']), $title);
        $title = str_replace('{condition}', $faker->randomElement(['Alzheimer\'s', 'Diabetes', 'Cancer', 'Heart Disease']), $title);
        $title = str_replace('{mission}', $faker->randomElement(['Artemis', 'Voyager', 'Mars 2020', 'Europa Clipper']), $title);
        $title = str_replace('{phenomenon}', $faker->randomElement(['Gravitational Waves', 'Dark Matter', 'Quantum Entanglement']), $title);

        return $title;
    }

    /**
     * Generate rich HTML content
     */
    private function generateContent($faker, int $paragraphs = 5): string
    {
        $content = '<div class="prose prose-lg">';
        
        // Opening paragraph (usually a summary)
        $content .= '<p class="lead">' . $faker->paragraph(4) . '</p>';
        
        // Main content paragraphs
        for ($i = 0; $i < $paragraphs - 2; $i++) {
            $content .= '<p>' . $faker->paragraph(rand(5, 10)) . '</p>';
            
            // Occasionally add a heading
            if ($i > 0 && $i % 3 === 0) {
                $content .= '<h3>' . $faker->sentence(rand(3, 6)) . '</h3>';
            }
            
            // Occasionally add a quote
            if ($i > 0 && $i % 4 === 0) {
                $content .= '<blockquote class="border-l-4 border-blue-500 pl-4 italic">';
                $content .= '<p>' . $faker->paragraph(2) . '</p>';
                $content .= '<cite>— ' . $faker->name() . ', ' . $faker->jobTitle() . '</cite>';
                $content .= '</blockquote>';
            }
            
            // Occasionally add a list
            if ($i > 0 && $i % 5 === 0) {
                $content .= '<ul class="list-disc list-inside">';
                for ($j = 0; $j < rand(3, 5); $j++) {
                    $content .= '<li>' . $faker->sentence() . '</li>';
                }
                $content .= '</ul>';
            }
        }
        
        // Closing paragraph
        $content .= '<p>' . $faker->paragraph(3) . '</p>';
        
        $content .= '</div>';
        
        return $content;
    }

    /**
     * Generate placeholder image using Lorem Picsum
     */
    private function generatePlaceholderImage(int $id): ?string
    {
        try {
            // Use Lorem Picsum for placeholder images
            $imageUrl = "https://picsum.photos/seed/{$id}/1920/1080";
            
            // Download image
            $imageContent = @file_get_contents($imageUrl);
            
            if ($imageContent === false) {
                $this->command->warn("⚠️  Failed to download image {$id}, skipping...");
                return null;
            }
            
            // Generate filename
            $filename = 'post_' . $id . '_' . time() . '.jpg';
            $path = storage_path('app/public/posts/' . $filename);
            
            // Save image
            file_put_contents($path, $imageContent);
            
            return 'posts/' . $filename;
            
        } catch (\Exception $e) {
            $this->command->warn("⚠️  Image generation failed: " . $e->getMessage());
            return null;
        }
    }
}