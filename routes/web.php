<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\About;
use App\Livewire\Contact;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Public posts route (no auth)
Route::get('/posts', [PublicPostController::class, 'index'])->name('public.posts.index');
Route::get('/posts/{id}', [PublicPostController::class, 'show'])->name('public.posts.show');

// About and Contact pages (Livewire)
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Terms of Service and Privacy Policy pages
Route::view('terms', 'terms-of-service.index')->name('terms');
Route::view('privacy', 'privacy-policy.index')->name('privacy');

// Newsletter public routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Reactions routes (auth required)
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/reactions', [ReactionController::class, 'toggle'])->name('reactions.toggle');
    Route::get('/posts/{post}/reactions/{type?}', [ReactionController::class, 'users'])->name('reactions.users');
});

// ✅ ADMIN ROUTES (admin, editor, writer ONLY)
Route::middleware(['auth', 'verified', 'admin.only'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Posts Management
    Route::resource('posts', PostController::class);

    // Comments Management
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
    Route::post('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/bulk-approve', [CommentController::class, 'bulkApprove'])->name('comments.bulk-approve');
    Route::post('/comments/bulk-delete', [CommentController::class, 'bulkDelete'])->name('comments.bulk-delete');


    // Newsletter Management
    Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::get('/newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');

    // Users Management 
    Route::resource('users', UserController::class)->only(['index', 'show', 'destroy']);

    // Analytics Management
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');



    // Notifications Management
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/clear-read', [NotificationController::class, 'clearRead'])->name('notifications.clearRead');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');



    // ✅ Admin Settings (unique names)

    Route::get('confirm-password', fn() => view('livewire.auth.confirm-password'))
        ->name('admin.password.confirm');

    Route::post('confirm-password', function (Request $request) {
        if (!Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => __('The provided password does not match our records.'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());
        return redirect()->intended();
    })->name('admin.password.confirm.store');

    

    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('admin.profile.edit');
    Volt::route('settings/password', 'settings.password')->name('admin.password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('admin.appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('admin.two-factor.show');
});

// ✅ USER ROUTES (role:user ONLY)
Route::middleware(['auth', 'verified', 'user.only'])->prefix('user')->group(function () {
    // Redirect /user to /user/settings/profile
    Route::redirect('/', 'settings/profile');

    Route::get('confirm-password', fn() => view('livewire.auth.confirm-password'))
        ->name('user.password.confirm');

    Route::post('confirm-password', function (Request $request) {
        if (!Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => __('The provided password does not match our records.'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());
        return redirect()->intended();
    })->name('user.password.confirm.store');

    // ✅ User Settings (unique names)
    Volt::route('settings/profile', 'user.settings.profile')->name('user.profile.edit');
    Volt::route('settings/password', 'user.settings.password')->name('user.password.edit');
    Volt::route('settings/appearance', 'user.settings.appearance')->name('user.appearance.edit');

    Volt::route('settings/two-factor', 'user.settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('user.two-factor.show');
});