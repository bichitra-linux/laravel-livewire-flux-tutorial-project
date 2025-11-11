<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Enums\PostStatus;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Get all published posts
        $posts = Post::where('status', PostStatus::Published)->get();

        if ($posts->isEmpty()) {
            $this->command->error('❌ No published posts found. Please run PostSeeder first.');
            return;
        }

        // Get all users
        $users = User::all();

        if ($users->count() < 2) {
            $this->command->error('❌ Not enough users. Please run RoleAndPermissionSeeder first.');
            return;
        }

        $this->command->info('💬 Generating comments for posts...');

        $totalComments = 0;
        $totalReplies = 0;

        // Progress bar
        $bar = $this->command->getOutput()->createProgressBar($posts->count());
        $bar->start();

        foreach ($posts as $post) {
            // Random number of comments per post (3-10)
            $commentCount = rand(3, 10);

            for ($i = 0; $i < $commentCount; $i++) {
                // Random user (excluding post author to make it realistic)
                $commenter = $users->where('id', '!=', $post->user_id)->random();

                // Generate realistic comment based on post category
                $content = $this->generateComment($post->category->slug ?? 'general', $faker);

                // Random approval status (90% approved)
                $isApproved = $faker->randomElement([
                    true, true, true, true, true, 
                    true, true, true, true,  // 90% approved
                    false,                    // 10% pending
                ]);

                // Random date between post creation and now
                $createdAt = $faker->dateTimeBetween($post->created_at, 'now');

                // Create parent comment
                $comment = Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $commenter->id,
                    'content' => $content,
                    'parent_id' => null,
                    'is_approved' => $isApproved,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                $totalComments++;

                // 50% chance to have replies (1-3 replies)
                if ($faker->boolean(50)) {
                    $replyCount = rand(1, 3);

                    for ($j = 0; $j < $replyCount; $j++) {
                        // Different user for reply
                        $replier = $users->where('id', '!=', $commenter->id)->random();

                        // Generate reply content
                        $replyContent = $this->generateReply($faker);

                        // Replies are created after the parent comment
                        $replyCreatedAt = $faker->dateTimeBetween($createdAt, 'now');

                        // Create reply
                        Comment::create([
                            'post_id' => $post->id,
                            'user_id' => $replier->id,
                            'content' => $replyContent,
                            'parent_id' => $comment->id,
                            'is_approved' => true, // Replies are mostly approved
                            'created_at' => $replyCreatedAt,
                            'updated_at' => $replyCreatedAt,
                        ]);

                        $totalReplies++;
                    }
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine(2);
        $this->command->info("✅ Successfully created {$totalComments} comments and {$totalReplies} replies!");
    }

    /**
     * Generate realistic comment based on category
     */
    private function generateComment(string $category, $faker): string
    {
        $comments = [
            'politics' => [
                'This is a significant development. The implications could be far-reaching.',
                'I appreciate the balanced perspective on this issue. Well researched!',
                'This policy change will definitely impact small businesses in our community.',
                'Great analysis! I hadn\'t considered that angle before.',
                'The statistics mentioned here are concerning. We need more transparency.',
                'Finally, someone addressing the real issues! Thank you for this article.',
                'I disagree with some points, but I respect the thorough investigation.',
                'This is exactly what I\'ve been saying for months. Glad to see it covered here.',
            ],
            'technology' => [
                'Fascinating read! The future of AI is both exciting and a bit scary.',
                'I\'ve been following this trend for a while. Great summary of the current state!',
                'As a developer, I can confirm this is spot on. The technology is game-changing.',
                'The security implications mentioned here are really important to consider.',
                'This innovation could revolutionize how we work. Can\'t wait to see it in action!',
                'Excellent breakdown of complex concepts. Made it easy to understand.',
                'I\'m curious about the environmental impact. Would love to see a follow-up on that.',
                'The comparison with existing solutions was really helpful. Thanks!',
            ],
            'culture' => [
                'This was such an inspiring read! The creativity behind this is amazing.',
                'I saw this exhibition last week and it was absolutely breathtaking.',
                'The cultural significance of this cannot be overstated. Well written!',
                'This brings back so many memories. Thank you for covering this topic.',
                'The artist\'s perspective is so unique. Really makes you think differently.',
                'I appreciate how you connected the historical context to modern times.',
                'This deserves more attention! Sharing with all my friends.',
                'The photography in this piece is stunning. Compliments to the team!',
            ],
            'business' => [
                'Smart business move. I\'ve been watching this company for a while.',
                'The market analysis here is spot on. Very valuable insights.',
                'As an entrepreneur, I found this incredibly useful. Thank you!',
                'The financial data supports the argument well. Great research!',
                'This trend is something we\'re seeing across the industry. Good timing on this article.',
                'I\'m curious about the long-term sustainability of this model.',
                'The case studies mentioned are perfect examples. Well chosen!',
                'This aligns with what we\'re experiencing in our startup. Great validation!',
            ],
            'world' => [
                'This is such important news. Thank you for bringing attention to it.',
                'The global implications are huge. Hoping for positive outcomes.',
                'As someone from this region, I appreciate the accurate coverage.',
                'This is a complex situation, and you handled it with great sensitivity.',
                'The international cooperation mentioned here is exactly what we need.',
                'Heartbreaking but necessary to report on. Thank you for your journalism.',
                'This could be a turning point. Fingers crossed for progress.',
                'The historical context provided really helps understand the situation.',
            ],
            'science' => [
                'This is groundbreaking! The potential applications are endless.',
                'As a scientist, I\'m thrilled to see this research getting coverage.',
                'The methodology explained here is fascinating. Can\'t wait for peer review.',
                'This could change everything we know about this field. Incredible!',
                'The implications for medicine are enormous. Hope it moves forward quickly.',
                'Great explanation of complex scientific concepts. Made it accessible!',
                'This research team has been doing amazing work. Well deserved recognition!',
                'The data visualization really helped me understand the findings.',
            ],
            'health' => [
                'This information is so valuable. Thank you for sharing!',
                'As someone dealing with this condition, this gives me hope.',
                'The medical expertise cited here is top-notch. Very credible.',
                'Everyone should read this. Such important health information.',
                'The practical tips at the end are really helpful. Implementing them today!',
                'This aligns with what my doctor has been telling me. Good to see it confirmed.',
                'Mental health awareness is so important. Thank you for addressing this.',
                'The latest research you mentioned is really promising. Exciting times!',
            ],
            'sports' => [
                'What a game! This was one for the history books.',
                'As a longtime fan, I couldn\'t be prouder. What a performance!',
                'The analysis of the tactics used was brilliant. Insightful read!',
                'This player deserves all the recognition. What a season!',
                'The statistics don\'t lie. This team is dominating right now.',
                'I was at the stadium for this. The atmosphere was electric!',
                'Great recap! You captured the excitement perfectly.',
                'This rivalry just got even more interesting. Can\'t wait for the next match!',
            ],
        ];

        // Get category-specific comments or use generic
        $categoryComments = $comments[$category] ?? [
            $faker->paragraph(2),
            'Great article! ' . $faker->sentence(),
            $faker->sentence() . ' ' . $faker->sentence(),
        ];

        return $faker->randomElement($categoryComments);
    }

    /**
     * Generate realistic reply content
     */
    private function generateReply($faker): string
    {
        $replies = [
            'I completely agree with you!',
            'That\'s an interesting perspective. I hadn\'t thought of it that way.',
            'Thanks for adding that context!',
            'I respectfully disagree, but I see where you\'re coming from.',
            'Great point! This is exactly what I was thinking.',
            'Could you elaborate on that? I\'d love to hear more.',
            'This is so true! Well said.',
            'I had a similar experience. Thanks for sharing.',
            'You\'re absolutely right. The evidence supports this.',
            'Interesting take! Do you have any sources for this?',
            'This adds a lot to the discussion. Thank you!',
            'I\'m not sure I follow. Could you explain further?',
            'Spot on! This is the real issue here.',
            'Thank you for this thoughtful response.',
            'I appreciate your perspective on this.',
            'This is exactly the kind of discussion we need.',
            'Well articulated! Couldn\'t have said it better myself.',
            'This made me reconsider my position. Thanks!',
            'Great addition to the conversation!',
            'I\'ve been saying this for years. Glad someone else gets it!',
        ];

        // 70% chance of short reply, 30% chance of longer reply
        if ($faker->boolean(70)) {
            return $faker->randomElement($replies);
        } else {
            return $faker->randomElement($replies) . ' ' . $faker->sentence();
        }
    }
}