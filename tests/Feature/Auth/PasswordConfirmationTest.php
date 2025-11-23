<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('confirm password screen can be rendered', function () {
    $user = User::factory()->create();
    Role::firstOrCreate(['name' => 'user']);
    $user->assignRole('user');

    $response = $this->actingAs($user)->get('/user/confirm-password');

    $response->assertStatus(200);
});