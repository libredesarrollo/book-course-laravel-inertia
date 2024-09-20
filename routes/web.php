<?php

use App\Http\Controllers\Contact\CompanyController;
use App\Http\Controllers\Contact\DetailController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Contact\GeneralController;
use App\Http\Controllers\Contact\PersonController;

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

Route::group([
    'prefix' => 'contact',
    // 'middleware' => [
    //     'auth:sanctum',
    //     config('jetstream.auth_session'),
    //     'verified',
    // ]
], function () {
    Route::resource('contact-general', GeneralController::class)->only(['create', 'edit', 'store', 'update']);
    Route::resource('contact-company', CompanyController::class)->only(['create', 'edit', 'store', 'update']);
    Route::resource('contact-person', PersonController::class)->only(['create', 'edit', 'store', 'update']);
    Route::resource('contact-detail', DetailController::class)->only(['create', 'edit', 'store', 'update']);
});

// Route::inertia('indexinertia','Dashboard/Post/Index');
