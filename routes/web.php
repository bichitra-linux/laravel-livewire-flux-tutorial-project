<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\SettingForm;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Public posts route (no auth)
Route::get('/posts', [PublicPostController::class, 'index'])->name('public.posts.index');
Route::get('/posts/{id}', [PublicPostController::class, 'show'])->name('public.posts.show');

// Reactions routes (auth required)
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/reactions', [ReactionController::class, 'toggle'])->name('reactions.toggle');
    Route::get('/posts/{post}/reactions/{type?}', [ReactionController::class, 'users'])->name('reactions.users');
});

// Newsletter public routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// ✅ ADMIN ROUTES - All grouped under /admin prefix with auth middleware
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts Management
    Route::resource('posts', PostController::class);
    
    // Newsletter Management
    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::get('/newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');
    
    // ✅ Users Management - Now properly in /admin namespace
    Route::resource('users', UserController::class)->only(['index', 'show', 'destroy']);
});

// Settings Form
Route::get('/settings-form', SettingForm::class)->middleware(['auth']);

// About page
Route::view('about', 'about')->name('about');

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
