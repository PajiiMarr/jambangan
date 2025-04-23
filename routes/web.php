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

Route::get('/', LandingPage::class)->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('events', 'events')
    ->middleware(['auth', 'verified'])
    ->name('events');

Route::get('performances',[PerformancesController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('performances');

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

// Route::gcet('/posts/{title}', \App\Http\Controllers\ViewPost::class)
//     ->middleware(['auth', 'verified'])
//     ->name('view-post');

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
