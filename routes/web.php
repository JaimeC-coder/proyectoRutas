<?php

use App\Http\Controllers\GoogleCalendarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanInvitationsController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/google/connect', [GoogleCalendarController::class, 'redirectToGoogle'])->name('google.connect');
    Route::get('/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::post('/google/disconnect', [GoogleCalendarController::class, 'disconnect'])->name('google.disconnect');
});

Route::get('/invitation/{token}', [PlanInvitationsController::class, 'accept'])
    ->name('invitation.accept');

Route::post('/invitation/{token}/register', [PlanInvitationsController::class, 'register'])
    ->name('invitation.register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        Route::prefix('plans')->group(function () {
            Route::get('/', [\App\Http\Controllers\PlansController::class, 'index'])->name('plans.index');
            Route::get('/create', [\App\Http\Controllers\PlansController::class, 'create'])->name('plans.create');
            Route::post('/', [\App\Http\Controllers\PlansController::class, 'store'])->name('plans.store');
            Route::get('/{plan}', [\App\Http\Controllers\PlansController::class, 'show'])->name('plans.show');
            Route::get('/{plan}/edit', [\App\Http\Controllers\PlansController::class, 'edit'])->name('plans.edit');
            Route::put('/{plan}', [\App\Http\Controllers\PlansController::class, 'update'])->name('plans.update');
            Route::delete('/{plan}', [\App\Http\Controllers\PlansController::class, 'destroy'])->name('plans.destroy');
        });
    });
});
