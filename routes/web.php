<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrainingSessionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    Route::get('/training-session', [TrainingSessionController::class, 'create'])->name('trainingSession.create');

    Route::post('/training-session', [TrainingSessionController::class, 'submit'])->name('trainingSession.submit');

    Route::get('/training-session/{trainingSession}/edit', [TrainingSessionController::class, 'edit'])->name(
        'trainingSession.edit'
    );

    Route::post('/training-session/{trainingSession}/participant', [TrainingSessionController::class, 'participant'])
        ->name('trainingSession.participant');
});
