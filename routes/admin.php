<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/children', [CategoryController::class, 'getChildrenByParent_id'])->name('get-children');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::get('/update/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
});

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
    Route::get('/update/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update');
});

Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
    Route::get('/', [TagController::class, 'index'])->name('index');
    Route::get('/create', [TagController::class, 'create'])->name('create');
    Route::get('/{id}', [TagController::class, 'show'])->name('show');
    Route::get('/update/{id}', [TagController::class, 'edit'])->name('edit');
    Route::post('/', [TagController::class, 'store'])->name('store');
    Route::put('/{id}', [TagController::class, 'update'])->name('update');
});
