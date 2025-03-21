<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(
    ['auth', 'verified'],
)->prefix('dashboard')->group(function () {
    Route::resource('/category', App\Http\Controllers\Dashboard\CategoryController::class);
    Route::resource('/post', App\Http\Controllers\Dashboard\PostController::class);
    Route::post('/post/upload/{post}', [App\Http\Controllers\Dashboard\PostController::class,'upload'])->name('post.upload');

    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
