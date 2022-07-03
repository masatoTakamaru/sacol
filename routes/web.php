<?php

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

Route::get('/', function () {
    return view('home.index');
})->name('home.index');

Route::get('/student/expired',
    [App\Http\Controllers\StudentController::class, 'expired_index'])
    ->middleware(['auth'])->name('student.expired_index');

Route::put('/student/{student}/expired_update',
    [App\Http\Controllers\StudentController::class, 'expired_update'])
    ->middleware(['auth'])->name('student.expired_update');

Route::put('/student/{student}/unexpired_update',
    [App\Http\Controllers\StudentController::class, 'unexpired_update'])
    ->middleware(['auth'])->name('student.unexpired_update');

Route::resource('/student', 'App\Http\Controllers\StudentController')
    ->middleware(['auth']);

Route::get('/item/{year}/{month}',
    [App\Http\Controllers\ItemController::class, 'index'])
    ->middleware(['auth'])->name('item.index');

Route::get('/item/{student}/{year}/{month}/{edit_id?}',
    [App\Http\Controllers\ItemController::class, 'edit'])
    ->middleware(['auth'])->name('item.edit');

Route::post('/item/store',
    [App\Http\Controllers\ItemController::class, 'store'])
    ->middleware(['auth'])->name('item.store');

Route::put('/item/{item}/update',
    [App\Http\Controllers\ItemController::class, 'update'])
    ->middleware(['auth'])->name('item.update');

Route::delete('/item/{item}/destroy',
    [App\Http\Controllers\ItemController::class, 'destroy'])
    ->middleware(['auth'])->name('item.destroy');

Route::get('/item_master/{code}/search',
    [App\Http\Controllers\ItemMasterController::class, 'search']);

Route::resource('/item_master',
    'App\Http\Controllers\ItemMasterController',
    ['except' => ['show']])
    ->middleware(['auth']);

Route::get('/qprice', [App\Http\Controllers\QpriceController::class, 'edit'])
    ->middleware(['auth'])->name('qprice.edit');

Route::put('/qprice', [App\Http\Controllers\QpriceController::class, 'update'])
    ->middleware(['auth'])->name('qprice.update');

Route::resource('/sheet',
    'App\Http\Controllers\SheetController',
    ['only' => ['store', 'update', 'destroy']])
    ->middleware(['auth']);

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])
    ->middleware(['auth'])->name('dashboard');
