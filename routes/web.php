<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TechniqueController;
use App\Http\Controllers\TrainingSessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
    if (Auth::check()) {
        return Redirect::route('dashboard');
    }

    return Redirect::route('login');
    /*
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
    */
});

Route::middleware(['auth:sanctum', 'verified', 'academy'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])
        ->name('dashboard')
        ->withoutMiddleware(['academy']);

    Route::get('/guide', function () {
        return Inertia::render('Guide');
    })->name('guide');

    Route::get('/training-session', [TrainingSessionController::class, 'create'])
        ->name('trainingSession.create');
    Route::post('/training-session', [TrainingSessionController::class, 'submit'])
        ->name('trainingSession.submit');
    Route::get('/training-session/{trainingSessionId}/edit', [TrainingSessionController::class, 'edit'])
        ->name('trainingSession.edit');
    Route::delete('/training-session/{trainingSessionId}', [TrainingSessionController::class, 'delete'])
        ->name('trainingSession.delete');
    Route::post('/training-session/{trainingSessionId}/participant', [TrainingSessionController::class, 'participant'])
        ->name('trainingSession.participant');

    Route::get('/technique', [TechniqueController::class, 'index'])
        ->name('technique.index');
    Route::get('/technique/create', [TechniqueController::class, 'create'])
        ->name('technique.create');
    Route::get('/technique/{techniqueId}/edit', [TechniqueController::class, 'edit'])
        ->name('technique.edit');
    Route::post('/technique', [TechniqueController::class, 'submit'])
        ->name('technique.submit');
    Route::delete('/technique/{techniqueId}', [TechniqueController::class, 'delete'])
        ->name('technique.delete');

});
