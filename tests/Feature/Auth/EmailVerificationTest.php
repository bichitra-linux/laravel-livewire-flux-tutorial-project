<?php



use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

test('email verification screen can be rendered', function () {
    $user = User::factory()->unverified()->create();
    
    // ✅ Assign Role
    Role::firstOrCreate(['name' => 'user']);
    $user->assignRole('user');

    $response = $this->actingAs($user)->get('/email/verify');

    $response->assertStatus(200);
});

test('email can be verified', function () {
    $user = User::factory()->unverified()->create();
    
    // ✅ Assign Role
    Role::firstOrCreate(['name' => 'user']);
    $user->assignRole('user');

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();
    
    // ✅ Assign Role
    Role::firstOrCreate(['name' => 'user']);
    $user->assignRole('user');

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('invalid-email')]

    );

    $this->actingAs($user)->get($verificationUrl);

expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});