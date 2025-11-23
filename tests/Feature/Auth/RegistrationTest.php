<?php

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $this->assertAuthenticated();
    // new users are typical "user" role — admin dashboard is not guaranteed
    $response->assertRedirect(route('home', absolute: false));
});