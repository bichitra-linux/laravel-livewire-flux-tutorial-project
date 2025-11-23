<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('guests are redirected to the login page', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    
    // Create and assign role
    Role::firstOrCreate(['name' => 'user']);
    $user->assignRole('user');

    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
});