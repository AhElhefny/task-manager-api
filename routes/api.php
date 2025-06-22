<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['controller' => TaskController::class,'prefix' => 'tasks'],function(){
    Route::post('/', 'store')->middleware('throttle:task-creation');
    Route::patch('{task}/update-status', 'updateStatus'); 
});
Route::apiResource('tasks', TaskController::class)->except(['store']);

