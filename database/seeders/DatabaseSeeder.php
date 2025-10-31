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

        // Create test user if doesn't exist
        User::firstOrCreate(
            ['email' => 'est@gmail.com'],
            [
                'name' => 'est',
                'password' => bcrypt('123456789'),
                'email_verified_at' => now(),
            ]
        );
        // Seed in correct order
        $this->call([
            RoleAndPermissionSeeder::class,
            CategorySeeder::class,  // 1. Categories first
            TagSeeder::class,       // 2. Tags second
            PostSeeder::class,      // 3. Posts last (needs categories & tags)
        ]);

        

        $this->command->info('🎉 Database seeding completed successfully!');
    }
}