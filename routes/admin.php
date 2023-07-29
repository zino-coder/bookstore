<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::get('/update/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
});
