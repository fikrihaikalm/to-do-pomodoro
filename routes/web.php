<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PomodoroController;
use App\Http\Controllers\HomeController;

// Home Route dengan Controller
Route::get('/', [HomeController::class, 'index'])->name('home');

// Task Routes
Route::resource('tasks', TaskController::class);
Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])
    ->name('tasks.complete');

// Pomodoro Routes
Route::get('/pomodoro/history', [PomodoroController::class, 'history'])
    ->name('pomodoro.history');
Route::post('/pomodoro/start', [PomodoroController::class, 'start'])
    ->name('pomodoro.start');
Route::put('/pomodoro/{session}', [PomodoroController::class, 'update'])
    ->name('pomodoro.update');
Route::post('/pomodoro/{session}/complete', [PomodoroController::class, 'complete'])
    ->name('pomodoro.complete');
Route::post('/pomodoro/{session}/cancel', [PomodoroController::class, 'cancel'])
    ->name('pomodoro.cancel');
Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])
    ->name('tasks.complete');