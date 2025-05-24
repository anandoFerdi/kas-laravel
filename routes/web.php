<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('home');
// });

Route::resource('/', App\Http\Controllers\DashboardController::class)->middleware('auth');
Route::resource('uangMasuk', App\Http\Controllers\MasukController::class)->middleware('auth');
Route::resource('uangKeluar', App\Http\Controllers\KeluarController::class)->middleware('auth');
// Route::resource('export_pdf', App\Http\Controllers\LaporanController::class)->middleware('auth');
Route::get('/export_masuk', [App\Http\Controllers\LaporanController::class, 'masuk']);
Route::get('/export-pdf-uangMasuk', [App\Http\Controllers\MasukController::class, 'export_pdf']);
Route::get('/export-pdf-uangKeluar', [App\Http\Controllers\KeluarController::class, 'export_pdf']);

Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
