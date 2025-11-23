<?php
use App\Models\User;
use Spatie\Permission\Models\Role;

test('users can authenticate using the login screen', function () {
    // create admin role and user with known password
    Role::firstOrCreate(['name' => 'admin']);
    $user = User::factory()->create(['password' => bcrypt('Password123!')]);
    $user->assignRole('admin');

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'Password123!',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});