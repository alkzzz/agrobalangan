<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PotentialAreaController;

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/potential-areas', [PotentialAreaController::class, 'index'])->name('potential-area.index');
Route::get('/potential-areas/geojson', [PotentialAreaController::class, 'geojson'])->name('potential-area.geojson');
