<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

test('users can authenticate using the login screen', function () {
    Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create(['password' => Hash::make('password')]);
    $user->assignRole('user');

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});