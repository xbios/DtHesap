<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CariController;
use App\Http\Controllers\FaturaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cari Routes
    Route::resource('caris', CariController::class);
    Route::get('caris/{cari}/balance', [CariController::class, 'balance'])->name('caris.balance');
    Route::get('caris/{cari}/movements', [CariController::class, 'movements'])->name('caris.movements');

    // Fatura Routes
    Route::resource('faturas', FaturaController::class);
    Route::post('faturas/{fatura}/details', [FaturaController::class, 'addDetail'])->name('faturas.add-detail');

    // Stok Routes
    Route::resource('stoks', \App\Http\Controllers\StokController::class);

    // Kasa Routes
    Route::resource('kasas', \App\Http\Controllers\KasaController::class);

    // Banka Routes
    Route::resource('bankas', \App\Http\Controllers\BankaController::class);

    // Firma Routes
    Route::resource('firmas', \App\Http\Controllers\FirmaController::class);
    Route::post('firmas/{id}/switch', [\App\Http\Controllers\FirmaController::class, 'switch'])->name('firmas.switch');
});

require __DIR__ . '/auth.php';
