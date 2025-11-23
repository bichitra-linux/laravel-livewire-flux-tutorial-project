<?php

use Illuminate\Support\Facades\Route;

test('new users can register', function () {
    if (!Route::has('register')) {
        $this->markTestSkipped('Registration route is not enabled.');
    }

    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'terms' => true, // ✅ Add required field
    ]);

    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    $response->assertRedirect(route('home', absolute: false));
});