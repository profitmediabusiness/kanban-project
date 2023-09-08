<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

// Route::get('/', function () {
//     return view('home');})
// ->name('home')->middleware('auth');
Route::get('/', [TaskController::class, 'home'])->name('home')->middleware('auth');

Route::get('/layouts', function () {
    return view('layouts.master');
});

// Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index'); 
// Route::get('/tasks/{id}/edit', 'edit')->name('tasks.edit');
// Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); 
// Route::post('/', [TaskController::class,'store'])->name('task.store');
// Route::put('/tasks/{id}/update', [TaskController::class, 'update'])->name('tasks.update');
// Route::get('/tasks/{id}/delete', [TaskController::class, 'delete'])->name('tasks.delete');
// Route::delete('/tasks/{id}/destroy', [TaskController::class, 'destroy'])->name('tasks.destroy');
// Route::get('/tasks/progress', [TaskController::class, 'progres'])->name('tasks.progress');

 Route::prefix('tasks')
 ->name('tasks.')
 ->middleware('auth')
 ->controller(TaskController::class)
 ->group(function () {
    Route::get('/', 'index')->name('index'); 
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::get('/create', 'create')->name('create'); 
    Route::post('/', 'store')->name('store');
    Route::put('/{id}/update', 'update')->name('update');
    Route::get('/{id}/delete', 'delete')->name('delete');
    Route::delete('/{id}/destroy', 'destroy')->name('destroy');
    Route::get('/progress', 'progres')->name('progress');
    Route::patch('{id}/move', 'move')->name('move'); 


 });

 Route::name('auth.')
    ->controller(AuthController::class)
    ->group(function(){
        Route::middleware('guest')->group(function ()
        { 
       Route::get('signup','signupForm')->name('signupForm');
      Route::post('signup','signup')->name('signup');
      Route::get('login', 'loginForm')->name('loginForm');
      Route::post('login', 'login')->name('login');
        });
      

      Route::middleware('auth')->group(function ()
      {
        Route::post('logout', 'logout')->name('logout');
      });
      
 }
);
