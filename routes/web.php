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
use App\Http\Controllers\UsersController;
use App\Models\LogsController;

// Public Routes
Route::get('/', LandingPage::class)->name('home-public');
Route::get('/about', [AboutController::class, 'index'])->name('about-public');
Route::get('/events', [EventsController::class, 'index'])->name('events-public');
Route::get('/events/{id}', [EventsController::class, 'show'])->name('events.show');
Route::get('/performances', [PerformanceController::class, 'index'])->name('performances-public');
Route::get('/performances/{id}', [PerformanceController::class, 'show'])->name('performances.show');
Route::get('/posts', [PostController::class, 'index'])->name('posts-public');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.details');
Route::get('/bookings', [BookingController::class, 'publicIndex'])->name('bookings-public');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

// Admin Routes
Route::middleware(['auth', 'verified', 'request.accepted'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Performances Management
    Route::view('/admin/performances', 'performances-admin')->name('performances');
    
    // Posts Management
    Route::view('/admin/posts', 'posts')->name('posts');
    
    // Events Management
    Route::view('/admin/events', 'events-admin')->name('events');
    
    // Site Management
    Route::view('/admin/manage', 'manage')->name('manage');
    
    // Officers Management
    Route::get('/admin/officers', [OfficerController::class, 'index'])->name('officers');
    
    // Bookings Management
    Route::get('/admin/bookings', [BookingController::class, 'index'])->name('bookings');
    
    Route::get('/admin/users', [UsersController::class, 'index'])
        ->name('admin-users')
        ->middleware('is_superadmin');;
        
    Route::get('/admin/logs', [LogsController::class, 'index'])->name('logs');
});

// Settings Routes
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('/favicon.svg', function () {
    $svgContent = Blade::render('<x-app-logo-icon />');
    return response($svgContent, 200, [
        'Content-Type' => 'image/svg+xml',
    ]);
});

Route::view('/register/pending', 'request_pending')->name('register_pending');
Route::view('/register/rejected', 'request_rejected')->name('register_rejected');

require __DIR__.'/auth.php';
