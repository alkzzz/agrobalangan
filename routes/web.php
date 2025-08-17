<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LokasiAgropolitanController;
use App\Http\Controllers\KepemilikanLahanController;
use App\Http\Controllers\AnalisisTanahController;
use App\Http\Controllers\MediaController;

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/lokasi-agropolitan/geojson', [LokasiAgropolitanController::class, 'geojson'])->name('lokasi-agropolitan.geojson');
Route::get('/kepemilikan-lahan/geojson', [KepemilikanLahanController::class, 'geojson'])->name('kepemilikan-lahan.geojson');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('lokasi-agropolitan')->name('lokasi-agropolitan.')->group(function () {
        Route::get('/', [LokasiAgropolitanController::class, 'index'])->name('index');
        Route::get('/details/{id}', [LokasiAgropolitanController::class, 'detail'])->name('detail');
    });

    Route::prefix('lokasi-agropolitan/{lokasi}/dokumentasi')->name('lokasi.dokumentasi.')->group(function () {
        Route::get('/kepemilikan', [LokasiAgropolitanController::class, 'showKepemilikanDokumentasi'])->name('kepemilikan');
        Route::get('/tanah', [LokasiAgropolitanController::class, 'showTanahDokumentasi'])->name('tanah');
        Route::get('/irigasi', [LokasiAgropolitanController::class, 'showIrigasiDokumentasi'])->name('irigasi');
        Route::get('/jalan', [LokasiAgropolitanController::class, 'showJalanDokumentasi'])->name('jalan');
        Route::post('/', [LokasiAgropolitanController::class, 'storeDokumentasi'])->name('store');
    });

    Route::patch('/media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

    Route::prefix('kepemilikan-lahan')->name('kepemilikan-lahan.')->group(function () {
        Route::get('/edit/{id}', [KepemilikanLahanController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [KepemilikanLahanController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [KepemilikanLahanController::class, 'destroy'])->name('destroy');
    });

    Route::put('/analisis-tanah/update/{analisis_tanah}', [AnalisisTanahController::class, 'update'])->name('analisis-tanah.update');
});
