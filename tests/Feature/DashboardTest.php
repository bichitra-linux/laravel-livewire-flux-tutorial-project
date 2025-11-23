<?php
use App\Models\User;
use Spatie\Permission\Models\Role;

test('authenticated users can visit the dashboard', function () {
    Role::firstOrCreate(['name' => 'admin']);
    $user = User::factory()->create(['password' => bcrypt('Password123!')]);
    $user->assignRole('admin');

    $this->actingAs($user);
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
});