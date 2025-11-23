<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Spatie\Permission\Models\Role;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();
    
    // ✅ Assign Role
    Role::firstOrCreate(['name' => 'user']);
    $user->assignRole('user');

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password', // Ensure factory uses 'password'
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});