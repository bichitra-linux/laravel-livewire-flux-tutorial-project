<?php
use App\Models\User;
use Spatie\Permission\Models\Role;

test('profile page is displayed', function () {
    Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create();
    $user->assignRole('user');

    $response = $this->actingAs($user)->get(route('user.profile.edit')); // correct name
    $response->assertStatus(200);
});