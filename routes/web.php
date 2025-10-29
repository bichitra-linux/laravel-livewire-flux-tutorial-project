<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\SettingForm;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\publicPostController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Updated: Dashboard now at /admin/dashboard with auth
Route::get('admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Updated: Posts now at /admin/posts with auth
Route::resource('admin/posts', PostController::class)->middleware(['auth']);

Route::get('/settings-form', SettingForm::class)->middleware(['auth']);

// Public posts route (no auth)
Route::get('/posts', [PublicPostController::class, 'index'])->name('public.posts.index');
Route::get('/posts/{id}', [PublicPostController::class, 'show'])->name('public.posts.show');


Route::view('about', 'about')
    ->name('about');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
