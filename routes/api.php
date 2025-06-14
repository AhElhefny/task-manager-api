<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tasks', TaskController::class)->except(['store']);
Route::post('/tasks', [TaskController::class, 'store'])->middleware('throttle:task-creation');
Route::patch('tasks/{task}/update-status', [TaskController::class, 'updateStatus']);
