<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TacheController;

// Routes accessible only to authenticated users
Route::middleware(['auth'])->group(function () {
    // Routes to display the list of tasks and add a new task
    Route::get('/tasks', [TacheController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TacheController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TacheController::class, 'store'])->name('tasks.store');

    // Routes to modify an existing task
    Route::get('/tasks/{task}/edit', [TacheController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TacheController::class, 'update'])->name('tasks.update');

    // Route to delete a task
    Route::delete('/tasks/{task}', [TacheController::class, 'destroy'])->name('tasks.destroy');
   
    // Route to mark a task as complete
    Route::post('/tasks/{task}/complete', [TacheController::class, 'complete'])->name('tasks.complete');
});

// Authentication routes
Auth::routes();

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
