<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
    Route::get('/carts/checkout', [CartController::class, 'checkout'])->name('carts.checkout');
    Route::post('/carts', [CartController::class, 'store'])->name('carts.store');
    Route::delete('/carts/{id}', [CartController::class, 'delete'])->name('carts.delete');
    Route::post('/carts/increment/{id}', [CartController::class, 'increment'])->name('carts.increment');
    Route::post('/carts/decrement/{id}', [CartController::class, 'decrement'])->name('carts.decrement');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

Route::prefix('areas')->name('areas.')->group(function () {
    Route::get('provinces', [AreaController::class, 'getProvinces'])->name('provinces');
    Route::get('/{provinceId}/cities', [AreaController::class, 'getCities'])->name('cities');
    Route::post('cost', [AreaController::class, 'getCosts'])->name('cost');
});

require __DIR__ . '/auth.php';
