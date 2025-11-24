<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');

        // Create test user if doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'est@gmail.com'],
            [
                'name' => 'est',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info("  Main user created: {$user->email}");

        // Seed in correct order (with dependencies)
        $this->call([
            RoleAndPermissionSeeder::class,  // 1. Roles first (needed for users)
            CategorySeeder::class,           // 2. Categories (needed for posts)
            TagSeeder::class,                // 3. Tags (needed for posts)
            PostSeeder::class, 
            CommentSeeder::class,            // 4. Comments (needs posts, users)
            ReactionSeeder::class,           // 5. Reactions (needs posts, users)
        ]);

        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->newLine();
        $this->command->info('📧 Test Users:');
        $this->command->table(
            ['Email', 'Password', 'Role'],
            [
                ['est@gmail.com', '123456789', 'Admin'],
                ['editor@example.com', 'password', 'Editor'],
                ['writer@example.com', 'password', 'Writer'],
                ['user@example.com', 'password', 'User'],
            ]
        );
    }
}