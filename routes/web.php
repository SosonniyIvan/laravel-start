<?php

use Illuminate\Support\Facades\Route;

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

Route::get('test', function (){
    app(\App\Services\Contract\FileStorageServiceInterface::class)->remove('test');
});

Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');

Route::resource('products', \App\Http\Controllers\ProductsController::class)->only(['index', 'show']);
Route::resource('categories', \App\Http\Controllers\CategoriesController::class)->only(['index', 'show']);

Auth::routes();

Route::name('admin.')->prefix('admin')->middleware(['role admin|moderator'])->group(function (){
   Route::get('dashboard', \App\Http\Controllers\Admin\DashBoardController::class)->name('dashboard');//admin.dashboard
   Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
});

Route::name('cart.')->prefix('cart')->group(function (){
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('index');
    Route::post('{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('add');
    Route::delete('/', [\App\Http\Controllers\CartController::class, 'remove'])->name('remove');
    Route::post('{product}/count', [\App\Http\Controllers\CartController::class, 'countUpdate'])->name('count.update');
});
