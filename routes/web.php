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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::name('admin.')->prefix('admin')->middleware(['role admin|moderator'])->group(function (){
   Route::get('dashboard', \App\Http\Controllers\Admin\DashBoardController::class)->name('dashboard');//admin.dashboard
   Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
});
