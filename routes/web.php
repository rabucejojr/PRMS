<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\PressReleaseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/press-releases', [PressReleaseController::class, 'publicIndex'])->name('press-releases.public');
Route::get('/press-releases/{slug}', [PressReleaseController::class, 'publicShow'])->name('press-releases.public.show');

// Password Reset Routes
Route::middleware('guest')->group(function () {
    // Show forgot password form
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Send password reset link
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:3,1') // Rate limit: 3 attempts per minute
        ->name('password.email');

    // Show reset password form
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Process password reset
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Authenticated routes
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'pressReleases' => \App\Models\PressRelease::orderByDesc('created_at')->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('press-releases', PressReleaseController::class);
});

require __DIR__.'/auth.php';
