<?php
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;

test('email can be verified', function () {
    Role::firstOrCreate(['name' => 'admin']);
    $user = User::factory()->unverified()->create();
    $user->assignRole('admin');

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();

    // admin user should be allowed in admin dashboard
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});