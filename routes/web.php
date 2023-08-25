<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('admin/login', [AdminAuthController::class, 'viewLogin'])->name('admin.login');
Route::post('admin/auth', [AdminAuthController::class, 'login'])->name('admin.auth');
Route::get('addtocart/{id}', [CartController::class, 'add'])->name('addtocart');
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('place-order', [CheckoutController::class, 'checkout'])->name('checkout.place-order');
Route::get('placed', [CheckoutController::class, 'success'])->name('checkout.success');
