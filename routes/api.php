<?php

use App\Http\Controllers\API\EventApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/events', [EventApiController::class, 'index'])->name('api.events');
});
?>
