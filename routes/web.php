<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PricelistController;
use App\Http\Controllers\HpsController;

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
    return view('layouts.master');
});

Route::get('/master', function () {
    return view('layouts.master');
})->name('layouts.master');

// Kategori
Route::resource('categories', CategoryController::class);

// Jasa
Route::resource('services', ServiceController::class);
Route::post('/categories/store-from-service', [CategoryController::class, 'storeFromService'])->name('categories.services');

// HPS
Route::get('/hps', [HpsController::class, 'index'])->name('hps.index');
Route::get('/overview', [HpsController::class, 'overview'])->name('hps.overview');
Route::get('/hps/create', [HpsController::class, 'create'])->name('hps.create');
Route::post('/hps/store', [HpsController::class, 'store'])->name('hps.store');
Route::get('/hps/{hpsHeader}', [HpsController::class, 'show'])->name('hps.show');
Route::get('/hps/{hpsHeader}/edit', [HpsController::class, 'edit'])->name('hps.edit');
Route::put('/hps/{hpsHeader}', [HpsController::class, 'update'])->name('hps.update');
Route::delete('/hps/{hpsHeader}', [HpsController::class, 'destroy'])->name('hps.destroy');

