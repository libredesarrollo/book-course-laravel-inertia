<?php

use App\Http\Controllers\Contact\CompanyController;
use App\Http\Controllers\Contact\DetailController;
use App\Http\Controllers\Contact\GeneralController;
use App\Http\Controllers\Contact\PersonController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {
    Route::resource('/category', App\Http\Controllers\Dashboard\CategoryController::class);
    Route::resource('/post', App\Http\Controllers\Dashboard\PostController::class);
    Route::post('/post/upload/{post}', [App\Http\Controllers\Dashboard\PostController::class, 'upload'])->name('post.upload');

    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// step
Route::group([
    'prefix' => 'contact',
    'middleware' => 'auth',
    'verified'
], function () {
    Route::resource('contact-general', GeneralController::class)->only(['create', 'edit', 'store', 'update']);
    Route::resource('contact-company', CompanyController::class)->only(['create', 'edit', 'store', 'update']);
    Route::resource('contact-person', PersonController::class)->only(['create', 'edit', 'store', 'update']);
    Route::resource('contact-detail', DetailController::class)->only(['create', 'edit', 'store', 'update']);
});

// blog
Route::group([
    'prefix' => 'blog',

], function () {
    Route::get('/', [App\Http\Controllers\Blog\PostController::class, 'index'])->name('web.index');
    Route::get('/{post:slug}', [App\Http\Controllers\Blog\PostController::class, 'show'])->name('web.show');
});

// shop

Route::group([
    'prefix' => 'shop',

], function () {
    Route::get('/', [App\Http\Controllers\Shop\CartController::class, 'index'])->name('shop.index');
    Route::post('/add/{post}/{count}', [App\Http\Controllers\Shop\CartController::class, 'add'])->name('shop.add');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
