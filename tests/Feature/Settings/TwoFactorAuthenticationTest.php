<?php
use App\Models\User;
use Spatie\Permission\Models\Role;

test('two factor settings page can be rendered', function () {
    Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create();
    $user->assignRole('user');

$this->actingAs($user)
         ->withSession(['auth.password_confirmed_at' => now()->timestamp]);
    $response = $this->get(route('user.two-factor.show')); // correct name
    $response->assertStatus(200);
});