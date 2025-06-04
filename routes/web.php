<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PressReleaseController;



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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'pressReleases' => \App\Models\PressRelease::orderByDesc('created_at')->get()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('press-releases', PressReleaseController::class);
});

require __DIR__ . '/auth.php';
