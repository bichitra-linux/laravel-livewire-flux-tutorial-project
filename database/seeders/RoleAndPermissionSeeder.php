<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Post permissions
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',
            
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Newsletter permissions
            'view newsletter',
            'export newsletter',
            
            // Category & Tag permissions
            'manage categories',
            'manage tags',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // 1. Admin Role - Full access
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 2. Editor Role - Can manage content
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'view posts',
            'create posts',
            'edit posts',
            'publish posts',
            'manage categories',
            'manage tags',
        ]);

        // 3. Writer Role - Can create and edit own posts
        $writerRole = Role::firstOrCreate(['name' => 'writer']);
        $writerRole->givePermissionTo([
            'view posts',
            'create posts',
            'edit posts',
        ]);

        // 4. User Role - Basic access
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo([
            'view posts',
        ]);

        $this->command->info('  Roles and permissions created successfully!');

        // Assign admin role to the main user
        $adminUser = User::where('email', 'est@gmail.com')->first();
        if ($adminUser && !$adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
            $this->command->info('  Admin role assigned to est@gmail.com');
        }

        // Create sample users with different roles
        $this->createSampleUsers($editorRole, $writerRole, $userRole);
    }

    /**
     * Create sample users for testing
     */
    private function createSampleUsers($editorRole, $writerRole, $userRole)
    {
        // Editor user
        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Jane Editor',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        if (!$editor->hasRole('editor')) {
            $editor->assignRole('editor');
            $this->command->info('  Editor user created: editor@example.com');
        }

        // Writer user
        $writer = User::firstOrCreate(
            ['email' => 'writer@example.com'],
            [
                'name' => 'Mike Writer',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        if (!$writer->hasRole('writer')) {
            $writer->assignRole('writer');
            $this->command->info('  Writer user created: writer@example.com');
        }

        // Regular user
        $regularUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        if (!$regularUser->hasRole('user')) {
            $regularUser->assignRole('user');
            $this->command->info('  Regular user created: user@example.com');
        }

        // Unverified user (no role)
        $unverified = User::firstOrCreate(
            ['email' => 'unverified@example.com'],
            [
                'name' => 'Sarah Unverified',
                'password' => bcrypt('password'),
                'email_verified_at' => null, // Not verified
            ]
        );
        $this->command->info('  Unverified user created: unverified@example.com');
    }
}
