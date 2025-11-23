<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

test('users can authenticate using the login screen', function () {
    Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create(['password' => Hash::make('Password123!')]);
    $user->assignRole('user');

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'Password123!',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});