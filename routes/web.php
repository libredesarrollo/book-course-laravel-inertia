<?php

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
])->prefix('dashboard')->group(function () {
    Route::resource('/category', App\Http\Controllers\Dashboard\CategoryController::class);
    Route::resource('/post', App\Http\Controllers\Dashboard\PostController::class);
    Route::post('/post/upload/{post}', [App\Http\Controllers\Dashboard\PostController::class, 'upload'])->name('post.upload');
    Route::delete('/post/image/delete/{post}', [App\Http\Controllers\Dashboard\PostController::class, 'imageDelete'])->name('post.image.delete');

    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Route::inertia('indexinertia','Dashboard/Post/Index');
