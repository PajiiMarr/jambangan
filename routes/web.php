<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('events', 'events')
    ->middleware(['auth', 'verified'])
    ->name('events');

Route::view('posts', 'posts')
    ->middleware(['auth', 'verified'])
    ->name('posts');

// Route::get('/posts/{title}', \App\Http\Controllers\ViewPost::class)
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
