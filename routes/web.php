<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\RoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('/categories', CategoryController::class);
   /*  Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::post('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::get('/lessons/edit', [LessonController::class, 'edit'])->name('lessons.edit'); */
    Route::post('/lessons/update/{lesson}', [LessonController::class, 'update'])->name('lesson.update');
    Route::resource('/lessons', LessonController::class);
    Route::resource('/roles', RoleController::class);
    
});
