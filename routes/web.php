<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('home');})
->name('home');

Route::get('/layouts', function () {
    return view('layouts.master');
});

 Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index'); 
 // 
 Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

 Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); 

 Route::post('/', [TaskController::class,'store'])->name('task.store');

 Route::put('/tasks/{id}/update', [TaskController::class, 'update'])->name('tasks.update');

 Route::get('/tasks/{id}/delete', [TaskController::class, 'delete'])->name('tasks.delete');
 Route::delete('/tasks/{id}/destroy', [TaskController::class, 'destroy'])->name('tasks.destroy');
 Route::get('/tasks/progress', [TaskController::class, 'progres'])->name('tasks.progress');

//  //Tes Rouute
//  Route::prefix('tasks')
//     ->controller(TasksController::class)
//     ->group(function () {
//         Route::get('/', 'index');
//         Route::get('/create', 'tasks.create'); 
//         Route::get('/{id}', 'show');
//         Route::get('/{id}/edit', 'edit'); 
//     });