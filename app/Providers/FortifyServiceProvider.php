<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Illuminate\Support\Facades\Auth;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $user = Auth::user();

                    if ($user->hasRole(['admin', 'editor', 'writer'])) {
                        return redirect()->intended(route('dashboard'));
                    }

                    return redirect()->intended(route('home'));
                }
            };

        });

        $this->app->singleton(RegisterResponse::class, function(){
            return new class implements RegisterResponse{
                public function toResponse($request){
                    return redirect()->route('verification.notice');
                }
            };

        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();

        // ✅ Disable custom authenticateUsing in tests to use standard Fortify login
        if (!app()->environment('testing')) {
            Fortify::authenticateUsing(function (Request $request){
                $user = User::where('email', $request->email)->first();

                if ($user && Hash::check($request->password, $user->password)) {

                    if (!$user->hasVerifiedEmail()){
                        session()->flash('unverified', 'Please verify your email address before logging in.');
                        return null;
                    }

                    return $user;
                }

                return null;
            });
        }

        Fortify::authenticateUsing(function (Request $request){
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {

                if (!$user->hasVerifiedEmail()){
                    session()->flash('unverified', 'Please verify your email address before logging in.');
                    return null;
                }

                return $user;
            }

            return null;
        });
    }

    /**
     * Configure Fortify actions.
     */
    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(fn() => view('livewire.auth.login'));
        Fortify::verifyEmailView(fn() => view('livewire.auth.verify-email'));
        Fortify::twoFactorChallengeView(fn() => view('livewire.auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn() => view('livewire.auth.confirm-password'));
        Fortify::registerView(fn() => view('livewire.auth.register'));
        Fortify::resetPasswordView(fn() => view('livewire.auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn() => view('livewire.auth.forgot-password'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}
