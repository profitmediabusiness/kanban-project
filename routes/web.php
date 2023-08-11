<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('home');})
->name('home');

Route::get('/layouts', function () {
    return view('layouts.master');
});

Route::get('/tasks/', [TaskController::class, 'index'])
->name('tasks.index'); 
 // 
 Route::get('/tasks/{id}/edit', [TaskController::class, 
 'edit'])->name('tasks.edit');

 Route::get('/tasks/create', [TaskController::class, 
 'create'])->name('tasks.create'); 

 //Tes Rouute
 Route::prefix('tasks')
    ->controller(TasksController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'tasks.create');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::get('/{id}/edit', 'edit');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });