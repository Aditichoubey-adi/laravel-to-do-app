<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


Route::resource('tasks', TaskController::class)->only(['index', 'store', 'destroy']);


Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');


Route::get('/', function () {
    return redirect()->route('tasks.index');
});