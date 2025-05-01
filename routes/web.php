<?php

use App\Http\Controllers\BookingController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use App\Http\Controllers\LandingPage;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PerformancesController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\PostController;

Route::get('/', LandingPage::class)->name('home');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/events', [EventsController::class, 'index'])->name('events');
Route::get('/events/{id}', [EventsController::class, 'show'])->name('events.show');

Route::get('/performances', [PerformanceController::class, 'index'])->name('performances');
Route::get('/performances/{id}', [PerformanceController::class, 'show'])->name('performances.show');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('posts', 'posts')
    ->middleware(['auth', 'verified'])
    ->name('posts');

Route::view('pages', 'pages')
    ->middleware(['auth', 'verified'])
    ->name('pages');

Route::view('contents', 'contents')
->middleware(['auth', 'verified'])
->name('contents');

Route::view('manage', 'manage')
->middleware(['auth', 'verified'])
->name('manage');

Route::get('officers',[OfficerController::class, 'index'])
->middleware(['auth', 'verified'])
->name('officers');

Route::get('bookings',[BookingController::class, 'index'])
->middleware(['auth', 'verified'])
->name('bookings');

Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.details');

Route::get('/favicon.svg', function () {
    $svgContent = Blade::render('<x-app-logo-icon />');

    return response($svgContent, 200, [
        'Content-Type' => 'image/svg+xml',
    ]);
});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
