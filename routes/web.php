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

Route::resource('/item_master',
    'App\Http\Controllers\ItemMasterController',
    ['except' => ['show']])
    ->middleware(['auth']);

Route::resource('/item', 'App\Http\Controllers\ItemController')
    ->middleware(['auth']);

Route::get('/qty', [App\Http\Controllers\QtyController::class, 'edit'])
    ->middleware(['auth'])->name('qty.edit');

Route::put('/qty', [App\Http\Controllers\QtyController::class, 'update'])
    ->middleware(['auth'])->name('qty.update');

Route::get('/sheet/{year}/{month}',
    [App\Http\Controllers\SheetController::class, 'index'])
    ->middleware(['auth'])->name('sheet.index');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
