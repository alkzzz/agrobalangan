<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokasiAgropolitanController;
// use App\Http\Controllers\PotentialAreaController;

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/lokasi-agropolitan/geojson', [LokasiAgropolitanController::class, 'geojson'])->name('lokasi-agropolitan.geojson');

Route::resource('/lokasi-agropolitan', LokasiAgropolitanController::class);

// Route::get('/area-potensial', [PotentialAreaController::class, 'index'])->name('potential-area.index');
// Route::get('/area-potensial/geojson', [PotentialAreaController::class, 'geojson'])->name('potential-area.geojson');
// Route::get('/area-potensial/{id}', [PotentialAreaController::class, 'show'])->name('potential-area.show');
// Route::post('/area-potensial', [PotentialAreaController::class, 'store'])->name('potential-area.store');
// Route::patch('/area-potensial/{id}', [PotentialAreaController::class, 'update'])->name('potential-area.update');
// Route::delete('/area-potensial/{id}', [PotentialAreaController::class, 'destroy'])->name('potential-area.destroy');
