<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokasiAgropolitanController;
use App\Http\Controllers\KepemilikanLahanController;
// use App\Http\Controllers\PotentialAreaController;

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/lokasi-agropolitan/geojson', [LokasiAgropolitanController::class, 'geojson'])->name('lokasi-agropolitan.geojson');

Route::get('/lokasi-agropolitan', [LokasiAgropolitanController::class, 'index'])->name('lokasi-agropolitan.index');
Route::get('/lokasi-agropolitan/details/{id}', [LokasiAgropolitanController::class, 'detail'])->name('lokasi-agropolitan.detail');

Route::get('/kepemilikan-lahan/geojson', [KepemilikanLahanController::class, 'geojson'])->name('kepemilikan-lahan.geojson');
