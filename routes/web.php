<?php

use App\Http\Controllers\SubtaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('todos', TodoController::class)->except(['show']);
Route::patch('/todos/{id}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');
Route::post('/todos/clear-completed', [TodoController::class, 'clearCompleted'])->name('todos.clearCompleted');
Route::post('/todos/toggle-all', [TodoController::class, 'toggleAll'])->name('todos.toggle-all');

Route::post('/todos/{todo}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
Route::patch('/subtasks/{subtask}/toggle', [SubtaskController::class, 'toggle'])->name('subtasks.toggle');
Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');