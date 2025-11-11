<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reaction;
use App\Models\Post;
use App\Models\User;
use App\Enums\PostStatus;
use App\Enums\ReactionType;

class ReactionSeeder extends Seeder
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

        $this->command->info('💖 Generating reactions for posts...');

        $totalReactions = 0;
        
        // Reaction probability weights (more realistic distribution)
        $reactionWeights = [
            ReactionType::Like->value => 40,   // 40% - Most common
            ReactionType::Love->value => 25,   // 25% - Very common
            ReactionType::Haha->value => 15,   // 15% - Common
            ReactionType::Wow->value => 10,    // 10% - Less common
            ReactionType::Care->value => 5,    // 5% - Rare
            ReactionType::Sad->value => 3,     // 3% - Rare
            ReactionType::Angry->value => 2,   // 2% - Very rare
        ];

        // Progress bar
        $bar = $this->command->getOutput()->createProgressBar($posts->count());
        $bar->start();

        foreach ($posts as $post) {
            // Number of reactions based on post views (more views = more reactions)
            // But with randomness: 5-30% of views convert to reactions
            $engagementRate = $faker->randomFloat(2, 0.05, 0.30);
            $reactionCount = (int) ($post->views * $engagementRate);
            
            // Ensure at least 3 reactions, max 100 per post
            $reactionCount = max(3, min($reactionCount, 100));

            // Get random users (excluding post author and duplicates)
            $eligibleUsers = $users->where('id', '!=', $post->user_id);
            
            // If we need more reactions than available users, allow duplicates
            if ($reactionCount > $eligibleUsers->count()) {
                $reactionCount = $eligibleUsers->count();
            }

            $reactingUsers = $eligibleUsers->random(min($reactionCount, $eligibleUsers->count()));

            foreach ($reactingUsers as $user) {
                // Choose reaction type based on weights
                $reactionType = $this->getWeightedRandomReaction($reactionWeights, $faker);

                // Random date between post creation and now
                $createdAt = $faker->dateTimeBetween($post->created_at, 'now');

                try {
                    // Create reaction (unique constraint on user_id + post_id)
                    Reaction::create([
                        'user_id' => $user->id,
                        'post_id' => $post->id,
                        'type' => $reactionType,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);

                    $totalReactions++;
                } catch (\Exception $e) {
                    // Skip if duplicate (unique constraint violation)
                    continue;
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine(2);
        
        // Display reaction statistics
        $this->displayStatistics($totalReactions);
    }

    /**
     * Get weighted random reaction type
     */
    private function getWeightedRandomReaction(array $weights, $faker): ReactionType
    {
        $totalWeight = array_sum($weights);
        $random = $faker->numberBetween(1, $totalWeight);
        
        $currentWeight = 0;
        foreach ($weights as $type => $weight) {
            $currentWeight += $weight;
            if ($random <= $currentWeight) {
                return ReactionType::from($type);
            }
        }
        
        // Fallback to Like
        return ReactionType::Like;
    }

    /**
     * Display reaction statistics
     */
    private function displayStatistics(int $totalReactions): void
    {
        $this->command->info("✅ Successfully created {$totalReactions} reactions!");
        $this->command->newLine();

        // Get breakdown by type
        $breakdown = [];
        foreach (ReactionType::cases() as $type) {
            $count = Reaction::where('type', $type->value)->count();
            $percentage = $totalReactions > 0 ? round(($count / $totalReactions) * 100, 1) : 0;
            $breakdown[] = [
                $type->emoji(),
                $type->label(),
                $count,
                $percentage . '%'
            ];
        }

        $this->command->table(
            ['Emoji', 'Type', 'Count', 'Percentage'],
            $breakdown
        );

        // Additional statistics
        $this->command->newLine();
        $this->command->info('📊 Additional Statistics:');
        
        $postsWithReactions = Post::has('reactions')->count();
        $avgReactionsPerPost = $postsWithReactions > 0 
            ? round($totalReactions / $postsWithReactions, 1) 
            : 0;

        $this->command->line("   • Posts with reactions: {$postsWithReactions}");
        $this->command->line("   • Average reactions per post: {$avgReactionsPerPost}");
        
        $topPost = Post::withCount('reactions')
            ->orderBy('reactions_count', 'desc')
            ->first();
        
        if ($topPost) {
            $this->command->line("   • Most reacted post: \"{$topPost->title}\" ({$topPost->reactions_count} reactions)");
        }
    }
}